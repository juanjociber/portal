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

try{
    if($bandera1){
        if(!empty($_POST['ruc']) && !empty($_POST['nombre']) && !empty($_POST['direccion'])){
            $Numero=0;
            $Contacto="";        
            $Telefono="";
            $Correo="";
            $Obs="";
    
            $Usuario = date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            $bandera = true;
    
            if(!empty($_POST['contacto'])){
                $Contacto = $_POST['contacto'];
            }
    
            if(!empty($_POST['telefono'])){
                $Telefono = $_POST['telefono'];
            }

            if(!empty($_POST['obs'])){
                $Obs = $_POST['obs'];
            }
    
            if(!empty($_POST['correo'])){
                $Correo = $_POST['correo'];
            }
    
            if(strlen($_POST['ruc'])>11){
                $msg = "El campo RUC no debe tener mas de 11 carácteres.";
                $bandera = false;
            }
            
            if(strlen($_POST['nombre'])>100){
                $msg = "El campo nombre no debe tener mas de 100 carácteres.";
                $bandera = false;
            }
            
            if(strlen($_POST['direccion'])>300){
                $msg = "El campo dirección no debe tener mas de 300 carácteres.";
                $bandera = false;
            }
            
            if(strlen($Contacto)>50){
                $msg = "El campo contacto no debe tener mas de 50 carácteres.";
                $bandera = false;
            }
            
            if(strlen($Telefono)>50){
                $msg = "El campo teléfono no debe tener mas de 50 carácteres.";
                $bandera = false;
            }
            
            if(strlen($Correo)>50){
                $msg = "El campo correo no debe tener mas de 50 carácteres.";
                $bandera = false;
            }

            if(strlen($Obs)>200){
                $msg = "El campo observaciones no debe tener mas de 200 caracteres.";
                $bandera = false;
            }
    
            if($bandera){
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conmy->beginTransaction();
    
                    $stmt=$conmy->prepare("select count(ruc) as v_cantidad from tblclientes where ruc='".$_POST['ruc']."';");
                    $stmt->execute();
                    $row=$stmt->fetch();
                    $Cantidad=$row['v_cantidad'];
    
                    $stmt=$conmy->prepare("select (ifnull((max(numero)+1),1)) as v_numero from tblclientes;");
                    $stmt->execute();
                    $row=$stmt->fetch();
                    $Numero=$row['v_numero'];
                    
                    if($Cantidad==0 && $Numero>0){
                        $stmt=$conmy->prepare("insert into tblclientes(numero, ruc, nombre, direccion, contacto, telefono, correo, observaciones, fecha, usuario, estado, creacion, actualizacion) values 
                                        (:Numero, :Ruc, :Nombre, :Direccion, :Contacto, :Telefono, :Correo, :Obs, :Fecha, :Usuario, :Estado, :Creacion, :Actualizacion)");
                        $stmt->execute(array(
                            'Numero' => $Numero,
                            'Ruc' => $_POST['ruc'],
                            'Nombre' => $_POST['nombre'],
                            'Direccion' => $_POST['direccion'],
                            'Contacto' => $Contacto,
                            'Telefono' => $Telefono,
                            'Correo' => $Correo,
                            'Obs' => $Obs,
                            'Fecha' => date('Y-m-d-'),
                            'Usuario' => $_SESSION['vgnombre'],                     
                            'Estado' => 2,
                            'Creacion' => $Usuario,
                            'Actualizacion' => $Usuario
                        ));
                        $conmy->commit();
                        $stmt=null;
    
                        $res='200';
                        $msg='Se registró el Cliente.';
    
                    }else{
                        $conmy->rollBack();
                        $stmt=null;
                        $msg="El RUC ya existe o no se generó un número válido.";
                    }
                }catch(PDOException $e){
                    $conmy->rollBack();
                    $msg=$e->getMessage();
                    $stmt=null;
                }
            }
        }else{
            $msg="Verifique los datos del Cliente.";
        }
    }else{
        $msg="El usuario no puede realizar esta acción.";
    }
}catch(Exception $e){
    $msg=$e;
}

$data['res']=$res;
$data['msg']=$msg;
echo json_encode($data);
?>

                    