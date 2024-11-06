<?php
session_start();
date_default_timezone_set("America/Lima");
require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

$bandera1=true;
if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera1=false;
}

$res='400';
$msg='Error general.';
$data=[];

try{
    if($bandera1){
        if(!empty($_POST['cotid']) && !empty($_POST['cotmoneda']) && !empty($_POST['cottasa']) && !empty($_POST['cottprecio'])){
            $bandera2 = true;
            $CotId = 0;
            $CotDescuento = 0;
            $CotPago = "";
            $CotTiempo = 0;
            $ChkCodigo = 1;
            $ChkCuentas = 1;
    
            $CotMoneda = $_POST['cotmoneda'];
            $CotTasa = $_POST['cottasa'];
            $CotTipoPrecio = $_POST['cottprecio'];

            $CotMoneda2 = $_POST['cotmoneda'];
            $CotTasa2 = $_POST['cottasa'];
            $CotTipoPrecio2 = $_POST['cottprecio'];
    
            if(!empty($_POST['cotdescuento'])){
                $CotDescuento = $_POST['cotdescuento'];
            }
    
            if(!empty($_POST['cotpago'])){
                $CotPago = $_POST['cotpago'];
            }

            if(!empty($_POST['cottiempo'])){
                $CotTiempo = $_POST['cottiempo'];
            }
    
            if(!empty($_POST['chkcodigo'])){
                if($_POST['chkcodigo'] == "false"){
                    $ChkCodigo = 0;
                }
            }

            if(!empty($_POST['chkcuentas'])){
                if($_POST['chkcuentas'] == "false"){
                    $ChkCuentas = 0;
                }
            }
    
            if($CotDescuento>3){
                $msg = "El descuento no debe superar el 3%";
                $bandera2 = false;
            }
    
            if(strlen($CotPago) > 50){
                $msg = "El campo plazo de entrega no debe superar los 50 carácteres.";
                $bandera2 = false;
            }    
    
            if($bandera2){
                $Cantidad = 1;
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conmy->prepare("select count(*) as cantidad from tbldetallecotizacion where idcotizacion=:IdCotizacion;");
                    $stmt->execute(array('IdCotizacion'=>$_POST['cotid']));
                    $row = $stmt->fetch();
                    if($row){
                        $Cantidad = $row['cantidad'];
                    }
                    $stmt = null;
                }catch(PDOException $ex){
                    $stmt = null;
                }
    
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("select id, tipoprecio, moneda, tasa from tblcotizaciones where id=:Id and idvendedor=:IdVendedor and estado=2;");
                    $stmt->execute(array('Id'=>$_POST['cotid'], 'IdVendedor'=>$_SESSION['vgid']));
                    $row=$stmt->fetch();
                    if($row){
                        $CotId = $row['id'];
                        $CotTipoPrecio2 = $row['tipoprecio'];
                        $CotMoneda2 = $row['moneda'];
                        $CotTasa2 = $row['tasa'];
                    }
                    $stmt=null;
                }catch(PDOException $ex){
                    $stmt=null;
                }
    
                $bandera3=true;
                if($Cantidad>0){
                    if($CotMoneda!=$CotMoneda2 || $CotTasa!=$CotTasa2 || $CotTipoPrecio!=$CotTipoPrecio2){
                        $bandera3=false;
                    }
                }
    
                if($bandera3==true && $CotId>0){
                    $Usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
                    try{
                        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt=$conmy->prepare("update tblcotizaciones set tipoprecio=:TipoPrecio, pago=:Pago, tiempo=:Tiempo, moneda=:Moneda, tasa=:Tasa, descuento=:Descuento, vercodigo=:VerCodigo, vercuentas=:VerCuentas, Actualizacion=:Actualizacion where id=:Id and idvendedor=:IdVendedor and estado=2;");
                        $stmt->execute(array(
                            'Pago' => $CotPago,
                            'Tiempo' => $CotTiempo,
                            'Moneda' => $CotMoneda,
                            'Tasa' => $CotTasa,
                            'Descuento' => $CotDescuento,
                            'TipoPrecio' => $CotTipoPrecio,
                            'VerCodigo' => $ChkCodigo,
                            'VerCuentas' => $ChkCuentas,
                            'Actualizacion' => $Usuario,                            
                            'Id' => $_POST['cotid'],
                            'IdVendedor' => $_SESSION['vgid']
                        ));
                        $stmt = null;
                        $res = '200';
                        $msg = 'Se actualizó la Cotización.';
                    }catch(PDOException $e){
                        $msg = $e->getMessage();
                        $stmt = null;
                    }
                }else{
                    $msg = "El usuario no puede actualizar esta cotización.";
                }
            }
        }else{
            $msg = "La información enviada esta incompleta.";
        }
    }else{
        $msg = "La sesión no existe.";
    }
}catch(Exception $e){
    $stmt = null;
    $msg = $e;
}

$data['res']=$res;
$data['msg']=$msg;

echo json_encode($data);
?>