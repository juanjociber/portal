<?php
session_start();
date_default_timezone_set("America/Lima");
$bandera1=true;
$bandera2=false;

if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera1=false;
}

require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

$res='400';
$msg='Error actualizando el producto.';
$data=[];

if($bandera1==true && isset($_POST['action']) && !empty($_POST['cotid'])){
    
    $CotId = 0;
    $CotTipoPrecio = "";
    $CotIgv = 0;
    $CotMoneda = "";
    $CotTasa = 0;
    $CotDescuento = 0;

    try{
        //Obtener los valores del igv y el descuento de la cotización.
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare("select id, tipoprecio, moneda, tasa, igv, descuento from tblcotizaciones where id=:Id and idvendedor=:IdVendedor and estado=2;");
        $stmt->execute(array('Id'=>$_POST['cotid'], 'IdVendedor'=>$_SESSION['vgid']));
        $row=$stmt->fetch();
        if($row){
            $CotId = $row['id'];
            $CotTipoPrecio = $row['tipoprecio'];      
            $CotMoneda = $row['moneda'];
            $CotTasa = $row['tasa'];
            $CotIgv = $row['igv'];
            $CotDescuento = $row['descuento'];
        }
    }catch(PDOException $e){
        $stmt=null;
    }

    if($CotId>0){
        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conmy->beginTransaction();
            
            if($_POST['action'] == "del"){
                if(!empty($_POST['indice'])){
                    $stmt=$conmy->prepare("delete from tbldetallecotizacion where id=:Id and idcotizacion=:IdCotizacion;");
                    $stmt->execute(array('Id'=>$_POST['indice'], 'IdCotizacion'=>$CotId));
                    $bandera2=true;
                }else{
                    $msg = 'No se reconoce el producto.';
                }            
            }else{
                $ProId = 0; //Obligatorio
                $ProCodigo = ""; //Opcional
                $ProNombre = ""; //Obligatorio
                $ProMedida = ""; //Obligatorio
                $ProMoneda = ""; //Opcional
                $ProPrecio = 0; //Opcional
                $ProCantidad = 0; //Opcional
                $ProEstado = 0; //0:Seleccionar, 1:STOCK, 2:IMPORTACION
                
                if(!empty($_POST['proestado'])){$ProEstado = $_POST['proestado'];}

                //Estableces los datos del producto segun el usuario: Admin se obtiene de lo que envia el usuario y seller se obtiene de la BD.
                if($_SESSION['vgrole'] == "admin"){
                    if(!empty($_POST['proid'])){$ProId = $_POST['proid'];}
                    if(!empty($_POST['procodigo'])){$ProCodigo = $_POST['procodigo'];}
                    if(!empty($_POST['pronombre'])){$ProNombre = $_POST['pronombre'];}
                    if(!empty($_POST['promedida'])){$ProMedida = $_POST['promedida'];}
                    if(!empty($_POST['promoneda'])){$ProMoneda = $_POST['promoneda'];}
                    if(!empty($_POST['proprecio'])){$ProPrecio = $_POST['proprecio'];}
                    if(!empty($_POST['procantidad'])){$ProCantidad = $_POST['procantidad'];}                    
                }else{
                    $query_precio = "pvpublico";
                    switch ($CotTipoPrecio) {
                        case 'mayor':
                            $query_precio = "pvmayor";
                            break;
                        case 'flota':
                            $query_precio = "pvflota";
                            break;                        
                        default:
                            $query_precio = "pvpublico";
                            break;
                    }
    
                    $stmt=$conmy->prepare("select id, codinterno, nombre, medida, moneda, ".$query_precio." as precio from tblcatalogo where id=:Id and estado=2;");
                    $stmt->execute(array('Id'=>$_POST['proid']));
                    $row=$stmt->fetch();
                    if($row){
                        $ProId = $row['id'];
                        $ProCodigo = $row['codinterno'];
                        $ProNombre = $row['nombre'];
                        $ProMedida = $row['medida'];
                        $ProMoneda = $row['moneda'];
                        $ProPrecio = $row['precio'];
                        if(!empty($_POST['procantidad'])){$ProCantidad=$_POST['procantidad'];}
                    }
                }                
    
                if($ProId>0 && !empty($ProNombre) && !empty($ProMedida) && !empty($ProMoneda) && $ProCantidad>0){
                    if(strlen($ProNombre)<1001){
                        if($CotMoneda == "USD"){
                            if($ProMoneda == "PEN"){
                               $ProPrecio = round(($ProPrecio / $CotTasa), 2);
                            }
                        }else{
                            if ($ProMoneda == "USD"){
                                $ProPrecio = round(($ProPrecio * $CotTasa), 2);
                            }
                        }                
                        $stmt=$conmy->prepare("insert into tbldetallecotizacion(idcotizacion, proid, codigo, producto, cantidad, precio, medida, estado) values (:IdCotizacion, :ProId, :Codigo, :Producto, :Cantidad, :Precio, :Medida, :Estado)");
                        $stmt->execute(array('IdCotizacion'=>$CotId, 'ProId'=>$ProId, 'Codigo'=>$ProCodigo, 'Producto'=>$ProNombre, 'Cantidad'=>$ProCantidad, 'Precio'=>$ProPrecio, 'Medida'=>$ProMedida, 'Estado'=>$ProEstado));
                        $bandera2=true;   
                    }else{
                        $msg = 'El campo nombre no puede superar los 1000 caracteres.';
                    }
                }else{
                    $msg = 'Información incompleta.';
                }
            }
            
            if($bandera2==true && !empty($CotIgv)){
                $TotValorVenta=0;
                $TotDescuentos=0;
                $BaseImponible=0;
                $TotImpuestos=0;
                $TotPrecioVenta=0;
    
                $stmt=$conmy->prepare("select cantidad, precio from tbldetallecotizacion where idcotizacion=:IdCotizacion;");
                $stmt->execute(array('IdCotizacion'=>$CotId));
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $TotValorVenta += $row['cantidad'] * $row['precio'];                   
                }
                $TotDescuentos = $TotValorVenta * ($CotDescuento / 100);
                $BaseImponible = $TotValorVenta - $TotDescuentos;
                $TotImpuestos = $BaseImponible * ($CotIgv / 100);
                $TotPrecioVenta = $BaseImponible + $TotImpuestos;
                    
                $stmt=$conmy->prepare("update tblcotizaciones set tot_valorventa=:TotValorVenta, tot_descuentos=:TotDescuentos, base_imponible=:BaseImponible, tot_impuestos=:TotImpuestos, tot_precioventa=:TotPrecioVenta where id=:Id and idvendedor=:VendId and estado=2;");
                $stmt->execute(array('TotValorVenta'=>$TotValorVenta,'TotDescuentos'=>$TotDescuentos,'BaseImponible'=>$BaseImponible,'TotImpuestos'=>$TotImpuestos,'TotPrecioVenta'=>$TotPrecioVenta,'Id'=>$CotId,'VendId'=>$_SESSION['vgid']));
                $conmy->commit();
                
                $res = "200";
                $msg = "Se actualizó la Cotización.";
            }else{
                $conmy->rollBack(); 
                $msg .= " No se pudo actualizar la Cotización.";
            }
        }catch(PDOException $e){
            $conmy->rollBack(); 
            $stmt=null;
            $msg=$e->getMessage();
        }
    }else{
        $msg="El usuario no puede actualizar esta Cotización.";
    }
}else{
    $msg = "El usuario no puede realizar esta acción.";
}

$data['res'] = $res;
$data['msg'] = $msg;

echo json_encode($data);
?>