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
        if(!empty('cotid') && !empty($_POST['cliid']) && !empty($_POST['clinumero']) && !empty($_POST['cliruc']) && !empty($_POST['clinombre']) && !empty($_POST['clidireccion'])){
            
            $CotId=0;
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
            
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select id from tblcotizaciones where id=:Id and idvendedor=:IdVendedor and estado=2;");
                $stmt->execute(array('Id'=>$_POST['cotid'], 'IdVendedor'=>$_SESSION['vgid']));
                $row=$stmt->fetch();
                if($row){
                    $CotId = $row['id'];
                }
                $stmt=null;
            }catch(PDOException $ex){
                $stmt=null;
            }


            if($bandera2==true && $CotId>0){
                $Usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("update tblcotizaciones set clinumero=:CliNumero, cliruc=:CliRuc, clinombre=:CliNombre, clidireccion=:CliDireccion, clicontacto=:CliContacto, clitelefono=:CliTelefono, clicorreo=:Clicorreo, Actualizacion=:Actualizacion where id=:Id;");
                        $stmt->execute(array(
                            'CliNumero'=>$_POST['clinumero'],
                            'CliRuc'=>$_POST['cliruc'],
                            'CliNombre'=>$_POST['clinombre'],
                            'CliDireccion'=>$_POST['clidireccion'],
                            'CliContacto'=>$_POST['clicontacto'],
                            'CliTelefono'=>$_POST['clitelefono'],
                            'Clicorreo'=>$_POST['clicorreo'],
                            'Actualizacion'=>$Usuario,                            
                            'Id'=>$CotId
                        ));
                        $stmt=null;
                        $res='200';
                        $msg='Se actualizó la Cotización.';
                }catch(PDOException $e){
                    $msg=$e->getMessage();
                    $stmt=null;
                }
            }else{
                $msg="El usuario no puede actualizar esta Cotización.";
            }
        }else{
            $msg="Complete la información del Cliente.";
        }
    }else{
        $msg="La sesión no existe.";
    }
}catch(Exception $e){
    $stmt=null;
    $msg=$e;
}

$data['res']=$res;
$data['msg']=$msg;

echo json_encode($data);
?>