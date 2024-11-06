<?php
session_start();
date_default_timezone_set("America/Lima");

$bandera=true;

if(empty($_SESSION['vgrole'])){
    $bandera=false;
}

$Id=0;
$res='400';
$msg='Error registrando la cotización.';
$data=[];

if($bandera){
    try{
        if(!empty($_SESSION['car']['cliente']) && !empty($_SESSION['car']['productos']) && !empty($_SESSION['car']['condiciones']) && !empty($_SESSION['vgid'])){
            if(count($_SESSION['car']['productos'])>0){

                $VerCodigo=0;                
        
                $CliId = $_SESSION['car']['cliente']['id'];
                $CliNumero = $_SESSION['car']['cliente']['numero'];
                $CliRuc = $_SESSION['car']['cliente']['ruc'];
                $CliNombre = $_SESSION['car']['cliente']['nombre'];
                $CliDireccion = $_SESSION['car']['cliente']['direccion'];
                $CliContacto = $_SESSION['car']['cliente']['contacto'];
                $CliTelefono = $_SESSION['car']['cliente']['telefono'];
                $CliCorreo = $_SESSION['car']['cliente']['correo'];
    
                $CotTipoPrecio = $_SESSION['car']['condiciones']['tprecio'];
                $CotMoneda = $_SESSION['car']['condiciones']['moneda'];
                $CotTasa = $_SESSION['car']['condiciones']['tasa'];
                $CotDescuento = $_SESSION['car']['condiciones']['descuento'];
                $CotPago = $_SESSION['car']['condiciones']['pago'];
                $CotTiempo = $_SESSION['car']['condiciones']['tiempo'];
                if($_SESSION['car']['condiciones']['chkcodigo'] == "true"){$VerCodigo=1;}
        
                if($CliId>0 && !empty($CliRuc) && !empty($CliNombre) && !empty($CotMoneda) && !empty($CotTasa)){
                    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        
                    $COTIZACION="";
                    $NUMERO=0;
                    $IGV=18;
                    $USUARIO=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
                        
                    $TotValorVenta=0; // suma del valor de los productos
                    $TotDescuentos=0; // vlor de la venta * descuento
                    $BaseImponible=0; // valor de la venta - descuentos
                    $TotImpuestos=0; // base imponible por igv
                    $TotPrecioVenta=0; // base imponible + impuestos
                    
                    $IsProducto=false;
                    if(!empty($_SESSION['car']['productos'])){
                        if(count($_SESSION['car']['productos'])>0){
                            $IsProducto=true;
                            foreach($_SESSION['car']['productos'] as $clave=>$valor){
                                $TotValorVenta+=$valor['cantidad']*$valor['precio'];
                            }              
                            $TotDescuentos = $TotValorVenta * ($CotDescuento / 100);
                            $BaseImponible = $TotValorVenta - $TotDescuentos;
                            $TotImpuestos = $BaseImponible * ($IGV / 100);
                            $TotPrecioVenta = $BaseImponible + $TotImpuestos;
                        }
                    }
        
                    try{            
                        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conmy->beginTransaction();
                
                        $stmt=$conmy->prepare("select (ifnull((max(numero)+1),1)) as v_numero from tblcotizaciones;");
                        $stmt->execute();
                        $row=$stmt->fetch();
                        if($row){
                            $NUMERO=$row['v_numero'];
                        };
                
                        $COTIZACION=date('ym').'-'.str_pad($NUMERO,4,"0",STR_PAD_LEFT).'-1-'.str_pad($CliId,3,"0",STR_PAD_LEFT);
                
                        $stmt=$conmy->prepare("insert into tblcotizaciones(idcliente, idvendedor, numero, cotizacion, fecha, tipoprecio, clinumero, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, vendnombre, pago, tiempo, moneda, tasa, igv, descuento, tot_valorventa, tot_descuentos, base_imponible, tot_impuestos, tot_precioventa, vercodigo, estado, creacion, actualizacion) values 
                            (:IdCliente, :IdVendedor, :Numero, :Cotizacion, :Fecha, :TipoPrecio, :CliNumero, :CliRuc, :CliNombre, :CliDireccion, :CliContacto, :CliTelefono, :CliCorreo, :VendNombre, :Pago, :Tiempo, :Moneda, :Tasa, :Igv, :Descuento, :TotValorVenta, :TotDescuentos, :BaseImponible, :TotImpuestos, :TotPrecioVenta, :VerCodigo, :Estado, :Creacion, :Actualizacion)");
                        $stmt->execute(array(
                            'IdCliente' => $CliId,
                            'IdVendedor' => $_SESSION['vgid'],
                            'Numero' => $NUMERO,
                            'Cotizacion' => $COTIZACION,
                            'Fecha' => date('Y-m-d'),
                            'TipoPrecio' => $CotTipoPrecio,
                            'CliNumero' => $CliNumero,
                            'CliRuc' => $CliRuc,
                            'CliNombre' => $CliNombre,
                            'CliDireccion' => $CliDireccion,
                            'CliContacto' => $CliContacto,
                            'CliTelefono' => $CliTelefono,
                            'CliCorreo' => $CliCorreo,
                            'VendNombre' => $_SESSION['vgnombre'],
                            'Pago' => $CotPago,
                            'Tiempo' => $CotTiempo,
                            'Moneda' => $CotMoneda,
                            'Tasa' => $CotTasa,
                            'Igv' => $IGV,
                            'Descuento' => $CotDescuento,
                            'TotValorVenta' => $TotValorVenta,
                            'TotDescuentos' => $TotDescuentos,
                            'BaseImponible' => $BaseImponible,
                            'TotImpuestos' => $TotImpuestos,
                            'TotPrecioVenta' => $TotPrecioVenta,
                            'VerCodigo' => $VerCodigo,
                            'Estado' => 2,
                            'Creacion' => $USUARIO,
                            'Actualizacion' => $USUARIO
                        ));
                        $Id=$conmy->lastInsertId();
                        
                        // Agregar Productos.
                        if($IsProducto){
                            $stmt=$conmy->prepare("insert into tbldetallecotizacion(idcotizacion, proid, codigo, producto, cantidad, precio, medida, estado) 
                            values(?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bindParam(1, $a1);
                            $stmt->bindParam(2, $b1);
                            $stmt->bindParam(3, $c1);
                            $stmt->bindParam(4, $d1);
                            $stmt->bindParam(5, $e1);
                            $stmt->bindParam(6, $f1);
                            $stmt->bindParam(7, $g1);
                            $stmt->bindParam(8, $h1);            
                                    
                            foreach($_SESSION['car']['productos'] as $clave=>$valor){
                                $a1=$Id;
                                $b1=$valor['id'];
                                $c1=$valor['codigo'];
                                $d1=$valor['nombre'];
                                $e1=$valor['cantidad'];
                                $f1=$valor['precio'];
                                $g1=$valor['medida'];
                                $h1=$valor['estado'];
                                $stmt->execute();
                            }
                        }                    

                        //Agregar Notas Adicionales
                        if(!empty($_SESSION['car']['notas'])){
                            if(count($_SESSION['car']['notas'])>0){
                                $stmt=$conmy->prepare("insert into tblnotascotizacion(cotid, descripcion, creacion) values(?, ?, ?)");
                                $stmt->bindParam(1, $a2);
                                $stmt->bindParam(2, $b2);
                                $stmt->bindParam(3, $c2);
                                foreach($_SESSION['car']['notas'] as $clave=>$valor){
                                    $a2 = $Id;
                                    $b2 = $valor['nota'];
                                    $c2 = $USUARIO;            
                                    $stmt->execute();
                                }
                            }
                        }

                        $conmy->commit();
                        unset($_SESSION["car"]);//Eliminar la variable del carrito de compras
                        $res='200';
                        $msg='Se registró la cotización.';
                    }catch(PDOException $e){
                        $conmy->rollBack();
                        $msg=$e->getMessage();
                        $stmt=null;
                    }
                }else{
                    $msg="La información enviada esta incompleta.";
                }
            }else{
                $msg="No hay productos en la cotización.";
            }
        }else{
            $msg="La información enviada esta incompleta.";
        }
    }catch(Exception $e){
        $stmt=null;
        $msg=$e;
    }
}else{
    $msg="El usuario no puede realizar esta acción.";
}

$data['res']=$res;
$data['msg']=$msg;
$data['cot']=$Id;

echo json_encode($data);
?>

                    