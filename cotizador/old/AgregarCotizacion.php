<?php
session_start();
date_default_timezone_set("America/Lima");

//####-####-#-###
//AñoMes-NroCotizacion-Version-NroCliente

$Id=0;
$res='400';
$msg='Error registrando la cotización.';
$data=[];

try{
    if(!empty($_SESSION['car']['cliente']) && !empty($_SESSION['car']['productos']) && !empty($_SESSION['car']['condiciones']) && !empty($_SESSION['vgid'])){
        if(count($_SESSION['car']['productos'])>0){
            $CliId=0;
            $CliNumero=0;
            $CliRuc="";
            $CliNombre="";
            $CliDireccion="";
            $CliContacto="";
            $CliTelefono="";
            $CliCorreo="";
    
            $CotMoneda="USD";
            $CotDescuento=0;
            $CotTiempo=0;
            $CotPago="";
            $CotEntrega="";
            $CotLugar="";
            $CotObs="";
            $VerCodigo=0;
    
            $CliId=$_SESSION['car']['cliente']['id'];
            $CliNumero=$_SESSION['car']['cliente']['numero'];
            $CliRuc=$_SESSION['car']['cliente']['ruc'];
            $CliNombre=$_SESSION['car']['cliente']['nombre'];
            $CliDireccion=$_SESSION['car']['cliente']['direccion'];
            $CliContacto=$_SESSION['car']['cliente']['contacto'];
            $CliTelefono=$_SESSION['car']['cliente']['telefono'];
            $CliCorreo=$_SESSION['car']['cliente']['correo'];

            if(!empty($_SESSION['car']['condiciones'])){
                $CotTiempo=$_SESSION['car']['condiciones']['tiempo'];
                $CotDescuento=$_SESSION['car']['condiciones']['descuento'];
                $CotPago=$_SESSION['car']['condiciones']['pago'];
                $CotEntrega=$_SESSION['car']['condiciones']['entrega'];
                $CotLugar=$_SESSION['car']['condiciones']['lugar'];
                $CotObs=$_SESSION['car']['condiciones']['obs'];
                if($_SESSION['car']['condiciones']['chkcodigo']=="false"){
                    $VerCodigo=0;
                }
            }
    
            if($CliId>0 && !empty($CliRuc) && !empty($CliNombre)){
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
    
                foreach($_SESSION['car']['productos'] as $clave=>$valor){
                    $TotValorVenta+=$valor['cantidad']*$valor['precio'];
                }
    
                $TotDescuentos = $TotValorVenta * ($CotDescuento/100);
                $BaseImponible = $TotValorVenta - $TotDescuentos;
                $TotImpuestos = $BaseImponible * ($IGV/100);
                $TotPrecioVenta = $BaseImponible + $TotImpuestos;
    
                try{
                    /*
                    $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare('CALL sp_agregarcotizacion(:CliRuc, :CliNombre, :CliDireccion, :VendId, :VendNombre, :SubTotal, :Usuario, :Observacion, @_retorno)');
                    $stmt->execute(array(
                        'CliRuc'=>$CliRuc,
                        'CliNombre'=>$_POST['clinombre'],
                        'CliDireccion'=>$_POST['clidireccion'],
                        'VendId'=>$_SESSION['vgid'],                
                        'VendNombre'=>$_SESSION['vgnombre'],
                        'SubTotal'=>$SubTotal,
                        'Usuario'=>$_SESSION['vgusuario'],
                    ));
                    $stmt->closeCursor(); //permite limpiar y ejecutar la segunda query
                    $row=$conmy->query("select @_retorno as retorno")->fetch(PDO::FETCH_ASSOC);
                    $Id=(int)$row['retorno'];*/
            
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conmy->beginTransaction();
            
                    $stmt=$conmy->prepare("select (ifnull((max(numero)+1),1)) as v_numero from tblcotizaciones;");
                    $stmt->execute();
                    $row=$stmt->fetch();
                    if($row){
                        $NUMERO=$row['v_numero'];
                    };
            
                    $COTIZACION=date('ym').'-'.str_pad($NUMERO,4,"0",STR_PAD_LEFT).'-1-'.str_pad($CliId,3,"0",STR_PAD_LEFT);
            
                    $stmt=$conmy->prepare("insert into tblcotizaciones(idcliente, idvendedor, numero, cotizacion, fecha, clinumero, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, vendnombre, tiempo, pago, entrega, lugar, moneda, igv, descuento, tot_valorventa, tot_descuentos, base_imponible, tot_impuestos, tot_precioventa, vercodigo, obs, estado, creacion, actualizacion) values 
                                        (:IdCliente, :IdVendedor, :Numero, :Cotizacion, :Fecha, :CliNumero, :CliRuc, :CliNombre, :CliDireccion, :CliContacto, :CliTelefono, :CliCorreo, :VendNombre, :Tiempo, :Pago, :Entrega, :Lugar, :Moneda, :Igv, :Descuento, :TotValorVenta, :TotDescuentos, :BaseImponible, :TotImpuestos, :TotPrecioVenta, :VerCodigo, :Obs, :Estado, :Creacion, :Actualizacion)");
                    $stmt->execute(array(
                        'IdCliente'=>$CliId,
                        'IdVendedor'=>$_SESSION['vgid'],
                        'Numero'=>$NUMERO,
                        'Cotizacion'=>$COTIZACION,
                        'Fecha'=>date('Y-m-d'),
                        'CliNumero'=>$CliNumero,
                        'CliRuc'=>$CliRuc,
                        'CliNombre'=>$CliNombre,
                        'CliDireccion'=>$CliDireccion,
                        'CliContacto'=>$CliContacto,
                        'CliTelefono'=>$CliTelefono,
                        'CliCorreo'=>$CliCorreo,
                        'VendNombre'=>$_SESSION['vgnombre'],
                        'Tiempo'=>$CotTiempo,
                        'Pago'=>$CotPago,
                        'Entrega'=>$CotEntrega,
                        'Lugar'=>$CotLugar,
                        'Moneda'=>$CotMoneda,
                        'Igv'=>$IGV,
                        'Descuento'=>$CotDescuento,
                        'TotValorVenta'=>$TotValorVenta,
                        'TotDescuentos'=>$TotDescuentos,
                        'BaseImponible'=>$BaseImponible,
                        'TotImpuestos'=>$TotImpuestos,
                        'TotPrecioVenta'=>$TotPrecioVenta,
                        'VerCodigo'=>$VerCodigo,
                        'Obs'=>$CotObs,
                        'Estado'=>2,
                        'Creacion'=>$USUARIO,
                        'Actualizacion'=>$USUARIO
                    ));
                    $Id=$conmy->lastInsertId();
                        
                    $stmt=$conmy->prepare("insert into tbldetallecotizacion(idcotizacion, idproducto, codigo, producto, cantidad, medida, precio) 
                    values(?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $IdCotizacion);
                    $stmt->bindParam(2, $ProId);
                    $stmt->bindParam(3, $ProCodigo);
                    $stmt->bindParam(4, $ProNombre);
                    $stmt->bindParam(5, $ProCantidad);
                    $stmt->bindParam(6, $Medida);
                    $stmt->bindParam(7, $ProPrecio);            
                        
                    foreach($_SESSION['car']['productos'] as $clave=>$valor){
                        $IdCotizacion=$Id;
                        $ProId=$clave;
                        $ProCodigo=$valor['codigo'];
                        $ProNombre=$valor['nombre'];
                        $ProCantidad=$valor['cantidad'];
                        $Medida=$valor['medida'];
                        $ProPrecio=$valor['precio'];                
                        $stmt->execute();
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
                $msg="Los datos del cliente no son válidos.";
            }
        }else{
            $msg="No hay productos en la cotización.";
        }
    }else{
        $msg="El usuario no puede realizar esta acción.";
    }
}catch(Exception $e){
    $stmt=null;
    $msg=$e;
}

$data['res']=$res;
$data['msg']=$msg;
$data['cot']=$Id;

echo json_encode($data);


?>

                    