<?php
session_start();

$res='400';
$msg='Error general.';
$data=[];

try{
    if(!empty($_SESSION) && !empty($_POST['action'])){
        if($_POST['action'] == "del"){
            if(isset($_POST['indice'])){
                unset($_SESSION['car']['notas'][$_POST['indice']]);
                $res = '200';
                $msg = 'Se eliminó la Nota.';
            }else{
                $msg = 'No se reconoce la Nota.';
            }
        }else{
            if(!empty($_POST['nota'])){
                if(strlen($_POST['nota'])<301){
                    $_SESSION['car']['notas'][]=array('nota' => $_POST['nota']);
                    $res='200';
                    $msg='Se agregó la Nota.';
                }else{
                    $msg = "El campo Nota no debe superar los 200 caracteres.";
                }
            }else{
                $msg = "No se envio la información requerida.";
            }            
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