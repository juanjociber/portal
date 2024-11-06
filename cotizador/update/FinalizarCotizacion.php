<?php
session_start();
date_default_timezone_set("America/Lima");

$res='400';
$msg='Error finalizando la cotización.';

try{
    if(!empty($_POST['cotizacion']) && !empty($_SESSION['vgid']) && !empty($_SESSION['vgusuario'])){
        include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        $USUARIO=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->prepare("update tblcotizaciones set estado=3, actualizacion=:Actualizacion where id=:IdCotizacion and idvendedor=:IdVendedor and estado=2;");
            $stmt->execute(array(                        
                'Actualizacion'=>$USUARIO,
                'IdCotizacion'=>$_POST['cotizacion'],
                'IdVendedor'=>$_SESSION['vgid']                        
            ));
            $res='200';
            $msg='Se finalizó la Cotización.';
        }catch(PDOException $e){
            $msg=$e->getMessage();
            $stmt=null;
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

                    