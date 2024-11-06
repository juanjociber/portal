<?php
session_start();
date_default_timezone_set("America/Lima");

$bandera=true;
if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera=false;
}

$res='400';
$msg='Error general.';
$data=[];

try{
    if($bandera==true && !empty($_POST['cotmoneda']) && !empty($_POST['cottasa']) && !empty($_POST['cottprecio'])){
        $bandera2=true;
        $CotDescuento = 0;
        $CotPago = "";
        $CotTiempo = 0;
        $ChkCodigo = "true";
        $ChkCuentas = "true";
        $CotMoneda=$_POST['cotmoneda'];
        $CotTasa=$_POST['cottasa'];
        $CotTipoPrecio=$_POST['cottprecio'];

        if(isset($_SESSION['car']['productos'])){
            if(count($_SESSION['car']['productos'])>0){
                if($_SESSION['car']['condiciones']['moneda'] != $CotMoneda || $_SESSION['car']['condiciones']['tasa'] != $CotTasa || $_SESSION['car']['condiciones']['tprecio'] != $CotTipoPrecio){
                    $bandera2=false;
                    $msg="No se puede cambiar la moneda, tasa de cambio o tipo de precios.";
                }
            }
        }

        if(!empty($_POST['cotdescuento'])){
            $CotDescuento=$_POST['cotdescuento'];
        }

        if(!empty($_POST['cotpago'])){
            $CotPago=$_POST['cotpago'];
        }

        if(!empty($_POST['cottiempo'])){
            $CotTiempo=$_POST['cottiempo'];
        }

        if(!empty($_POST['chkcodigo'])){
            $ChkCodigo=$_POST['chkcodigo'];
        }

        if(!empty($_POST['chkcuentas'])){
            $ChkCuentas=$_POST['chkcuentas'];
        }

        if($CotDescuento>3){
            $msg="El descuento no debe superar el 3%";
            $bandera2=false;
        }

        if(strlen($CotPago)>50){
            $msg="El campo plazo de entrega no debe superar los 50 carácteres.";
            $bandera2=false;
        }
        
        if($bandera2){
            $_SESSION['car']['condiciones']=array(
                'tprecio' => $CotTipoPrecio,
                'moneda' => $CotMoneda,
                'tasa' => $CotTasa,
                'descuento' => $CotDescuento,
                'pago' => $CotPago,
                'tiempo' => $CotTiempo,
                'chkcodigo' => $ChkCodigo,
                'chkcuentas' => $ChkCuentas
            );
            if(!isset($_SESSION['car']['notas'])){
                $_SESSION['car']['notas'][]=array('nota' => 'Plazo de entrega Inmediato. Previo envío de voucher de pago y Orden de Compra.');
                $_SESSION['car']['notas'][]=array('nota' => 'Lugar de entrega: Instalaciones de GPEM SAC. o previa coordinación con el Cliente para envío a sus instalaciones.');
                $_SESSION['car']['notas'][]=array('nota' => 'Para transferencias desde otras plazas, el Banco realizará un cobro del 0,5% sobre el monto total, el cual deberá ser asumido por el cliente.');
                $_SESSION['car']['notas'][]=array('nota' => 'Envío a provincias por SHALOM o MARVISUR.');
            }
            $res='200';
            $msg='se agregó las condiciones.';
        }
    }else{
        $msg="El usuario no puede ejecutar esta acción.";
    }
}catch(Exception $e){
    $stmt=null;
    $msg=$e;
}

$data['res']=$res;
$data['msg']=$msg;

echo json_encode($data);
?>