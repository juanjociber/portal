<?php
session_start();
date_default_timezone_set("America/Lima");

$bandera1=true;
if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera1=false;
}

include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

$res='400';
$msg='Error registrando la cotización.';
$data=[];

if($bandera1){
    try{
        if(!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['direccion']) && !empty($_POST['estado'])){
            $Contacto = "";        
            $Telefono = "";
            $Correo = "";
            $Obs = "";
    
            $Usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            $bandera2=true;
    
            if(!empty($_POST['contacto'])){
                $Contacto=$_POST['contacto'];
            }
    
            if(!empty($_POST['telefono'])){
                $Telefono=$_POST['telefono'];
            }
    
            if(!empty($_POST['correo'])){
                $Correo=$_POST['correo'];
            }

            if(!empty($_POST['obs'])){
                $Obs=$_POST['obs'];
            }
    
            if(strlen($_POST['nombre'])>100){
                $msg="El campo nombre no debe tener mas de 100 carácteres.";
                $bandera2=false;
            }
            
            if(strlen($_POST['direccion'])>300){
                $msg="El campo dirección no debe tener mas de 300 carácteres.";
                $bandera2=false;
            }
            
            if(strlen($Contacto)>50){
                $msg="El campo contacto no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }
            
            if(strlen($Telefono)>50){
                $msg="El campo teléfono no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }
            
            if(strlen($Correo)>50){
                $msg="El campo correo no debe tener mas de 50 carácteres.";
                $bandera2=false;
            }

            if(strlen($Obs)>200){
                $msg = "El campo observaciones no debe tener mas de 200 caracteres.";
                $bandera2 = false;
            }
    
            if($bandera2){
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("update tblclientes set nombre=:Nombre, direccion=:Direccion, contacto=:Contacto, telefono=:Telefono, correo=:Correo, observaciones=:Obs, estado=:Estado, actualizacion=:Actualizacion where id=:Id;");
                    $stmt->execute(array(
                        'Nombre' => $_POST['nombre'],
                        'Direccion' => $_POST['direccion'],
                        'Contacto' => $Contacto,
                        'Telefono' => $Telefono,
                        'Correo' => $Correo,
                        'Obs' => $Obs,                       
                        'Estado' => $_POST['estado'],
                        'Actualizacion' => $Usuario,
                        'Id' => $_POST['id']
                    ));                
                    $stmt=null;
                    $res='200';
                    $msg='Se modificó el Cliente.';
                }catch(PDOException $e){
                    $msg=$e->getMessage();
                    $stmt=null;
                }
            }
        }else{
            $msg="Verifique los datos del Cliente.";
        }
    }catch(Exception $e){
        $msg=$e;
    }
}else{
    $msg="El Usuario no puede realizar esta acción.";
}

$data['res']=$res;
$data['msg']=$msg;
echo json_encode($data);
?>

                    