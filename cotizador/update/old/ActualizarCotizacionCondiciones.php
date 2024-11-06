<?php
session_start();
date_default_timezone_set("America/Lima");

$bandera1=true;
if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera1=false;
}else{
    if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
        $bandera1=false;
    }
}

$res='400';
$msg='Error general.';
$data=[];

try{
    if($bandera1){
        $CotMoneda="Dólares Americanos";
        $CotDescuento=0;
        $CotTiempo=0;
        $CotPago="";
        $CotEntrega="";
        $CotLugar="";
        $CotObs="";
        $ChkCodigo="true";

        $bandera2=true;

        /*
        $CotMoneda="Dólares Americanos";
        $CotTiempo="05 días";
        $CotPago="Al Contado";
        $CotPlazo="Inmediato. Previo envío de Voucher de pago y orden de compra";
        $CotLugar="Instalaciones de GPEM SAC. o previa coordinación con el cliente para envío a sus instalaciones";
        $CotObs="";
        */

        if(!empty($_POST['cotdescuento'])){
            $CotDescuento=$_POST['cotdescuento'];
        }

        if(!empty($_POST['cottiempo'])){
            $CotTiempo=$_POST['cottiempo'];
        }

        if(!empty($_POST['cotpago'])){
            $CotPago=$_POST['cotpago'];
        }

        if(!empty($_POST['cotentrega'])){
            $CotEntrega=$_POST['cotentrega'];
        }
    
        if(!empty($_POST['cotlugar'])){
            $CotLugar=$_POST['cotlugar'];
        }

        if(!empty($_POST['cotobs'])){
            $CotObs=$_POST['cotobs'];
        }

        if(!empty($_POST['chkcodigo'])){
            $ChkCodigo=$_POST['chkcodigo'];
        }

        if($CotDescuento>3){
            $msg="El descuento no debe superar el 3%";
            $bandera2=false;
        }

        if(strlen($CotPago)>50){
            $msg="El campo plazo de entrega no debe superar los 50 carácteres.";
            $bandera2=false;
        }

        if(strlen($CotEntrega)>100){
            $msg="El campo plazo de entrega no debe superar los 100 carácteres.";
            $bandera2=false;
        }

        if(strlen($CotLugar)>200){
            $msg="El campo lugar de entrega no debe superar los 200 carácteres.";
            $bandera2=false;
        }

        if(strlen($CotObs)>300){
            $msg="Las observaciones no pueden superar los 300 carácteres.";
            $bandera2=false;
        }
        
        if($bandera2){
            $_SESSION['car']['condiciones']=array(
                'moneda'=>$CotMoneda,
                'descuento'=>$CotDescuento,
                'tiempo'=>$CotTiempo,
                'pago'=>$CotPago,
                'entrega'=>$CotEntrega, 
                'lugar'=>$CotLugar,
                'obs'=>$CotObs,
                'chkcodigo'=>$ChkCodigo
            );
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