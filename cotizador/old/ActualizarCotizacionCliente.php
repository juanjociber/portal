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
        if(!empty($_POST['cliid']) && !empty($_POST['clinumero']) && !empty($_POST['cliruc']) && !empty($_POST['clinombre']) && !empty($_POST['clidireccion'])){
            
            $CliContacto="";
            $CliTelefono="";
            $CliCorreo="";
            $bandera2=true;
    
            if(!empty($_POST['clicontacto'])){
                $CliContacto=$_POST['clicontacto'];
            }
    
            if(!empty($_POST['clitelefono'])){
                $CliTelefono=$_POST['clitelefono'];
            }
    
            if(!empty($_POST['clicorreo'])){
                $CliCorreo=$_POST['clicorreo'];
            }

            if(strlen($_POST['cliruc'])>11){
                $msg="El campo RUC no debe tener mas de 11 carácteres.";
                $bandera2=false;
            }

            if(strlen($_POST['clinombre'])>100){
                $msg="El campo nombre no debe tener mas de 100 carácteres.";
                $bandera2=false;
            }

            if(strlen($_POST['clidireccion'])>300){
                $msg="El campo dirección no debe tener mas de 300 carácteres.";
                $bandera2=false;
            }

            if(strlen($CliContacto)>50){
                $msg="El campo contacto no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }

            if(strlen($CliTelefono)>50){
                $msg="El campo teléfono no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }

            if(strlen($CliCorreo)>50){
                $msg="El campo correo no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }
            
            if($bandera2){
                $_SESSION['car']['cliente']=array(
                    'id'=>$_POST['cliid'], 
                    'numero'=>$_POST['clinumero'],
                    'ruc'=>$_POST['cliruc'],
                    'nombre'=>$_POST['clinombre'], 
                    'direccion'=>$_POST['clidireccion'],
                    'contacto'=>$CliContacto,
                    'telefono'=>$CliTelefono,
                    'correo'=>$CliCorreo
                );
                $res='200';
                $msg='se agrego el Cliente.';
            }
        }else{
            $msg="Complete la información del Cliente.";
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