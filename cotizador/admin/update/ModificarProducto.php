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

include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

$res='400';
$msg='Error modificando el Producto.';
$data=[];

if($bandera1){
    try{
        if(!empty($_POST['id']) && !empty($_POST['codexterno']) && !empty($_POST['nombre']) && !empty($_POST['medida']) && !empty($_POST['moneda']) && !empty($_POST['ppublico']) && !empty($_POST['pmayor']) && !empty($_POST['pflota']) && !empty($_POST['fecha']) && !empty($_POST['estado'])){
            $Marca="";
            $Stock=0;
            $Observacion="";
            $Usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            $bandera2=true;
    
            if(!empty($_POST['marca'])){
                $Marca=$_POST['marca'];
            }

            if(!empty($_POST['stock'])){
                $Stock=$_POST['stock'];
            }

            if(!empty($_POST['observacion'])){
                $Observacion=$_POST['observacion'];
            }
            
            if(strlen($_POST['codexterno'])>30){
                $msg="El campo Código no debe tener mas de 30 carácteres.";
                $bandera2=false;
            }
            
            if(strlen($_POST['nombre'])>100){
                $msg="El campo Nombre no debe tener mas de 100 carácteres.";
                $bandera2=false;
            }
    
            if(strlen($Marca)>30){
                $msg="El campo Marca no debe tener mas de 30 carácteres.";
                $bandera2=false;
            }
    
            if(strlen($_POST['medida'])>30){
                $msg="El campo Medida no debe tener mas de 30 carácteres.";
                $bandera2=false;
            }
    
            if($bandera2){
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("update tblcatalogo set codexterno=:CodExterno, nombre=:Nombre, marca=:Marca, medida=:Medida, stock=:Stock, pvpublico=:PPublico, pvmayor=:PMayor, pvflota=:PFlota, moneda=:Moneda, fecha=:Fecha, observacion=:Observacion, estado=:Estado, actualizacion=:Actualizacion where id=:Id;");
                    $stmt->execute(array(
                        'CodExterno'=>$_POST['codexterno'],
                        'Nombre'=>$_POST['nombre'],
                        'Marca'=>$Marca,
                        'Medida'=>$_POST['medida'],
                        'Stock'=>$Stock,
                        'PPublico'=>$_POST['ppublico'],
                        'PMayor'=>$_POST['pmayor'],
                        'PFlota'=>$_POST['pflota'],
                        'Moneda'=>$_POST['moneda'],
                        'Fecha'=>$_POST['fecha'],
                        'Observacion' => $Observacion,
                        'Estado' => $_POST['estado'],
                        'Actualizacion'=>$Usuario,
                        'Id'=>$_POST['id']
                    ));                
                    $stmt=null;
                    $res='200';
                    $msg='Se modificó el Producto.';
                }catch(PDOException $e){
                    $msg=$e->getMessage();
                    $stmt=null;
                }
            }
        }else{
            $msg="Verifique los datos del Producto.";
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

                    