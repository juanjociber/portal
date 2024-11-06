<?php
session_start();
date_default_timezone_set("America/Lima");

$res='400';
$msg='Error anulando la cotización.';

try{
    if(!empty($_POST['cotizacion']) && !empty($_POST['nota']) && !empty($_SESSION['vgid']) && !empty($_SESSION['vgusuario'])){
        include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

        if(strlen($_POST['nota'])<101){
            $USUARIO=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("update tblcotizaciones set nota=:Nota, estado=1, actualizacion=:Actualizacion where id=:IdCotizacion and idvendedor=:IdVendedor and estado=2;");
                $stmt->execute(array(
                    'Nota'=>$_POST['nota'],                       
                    'Actualizacion'=>$USUARIO,
                    'IdCotizacion'=>$_POST['cotizacion'],
                    'IdVendedor'=>$_SESSION['vgid']                        
                ));
                $res='200';
                $msg='Se anuló la Cotización.';
            }catch(PDOException $e){
                $msg=$e->getMessage();
                $stmt=null;
            }
            }else{
                $msg="El campo nota no puede tener mas 100 carácteres.";
            }        
    }else{
        $msg="El usuario no puede realizar esta acción.";
    }
}catch(Exception $e){
    $stmt=null;
    $msg=$e;
}

$data['res']=$res;
$data['msg']=$msg;

echo json_encode($data);


?>

                    