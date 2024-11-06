<?php
session_start();

$res='400';
$msg='No se ha podido registrar el cupón.';

if(!empty($_POST['cupon'])){
    if(AgregarCupon($_POST['cupon'])){
        $res="200";
        $msg="Ok.";
    }
}

$data[]=array('res'=>$res);
$data[]=array('msg'=>$msg);

echo json_encode($data);

function AgregarCupon($cupon_id){
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

    $respuesta=false;
    $cupon='';
    $producto=0;
    $valor=0;

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare('select idcupon, idproducto, valor from tblcupones where idcupon=:IdCupon and estado=2 and vencimiento>now()');
        $stmt->execute(array('IdCupon'=>$cupon_id));
        $row=$stmt->fetch();
        $cupon=$row['idcupon'];
        $producto=$row['idproducto'];
        $valor=$row['valor'];

        if($producto>0){
            $stmt=$conmy->prepare("update tblcupones set estado=3 where idcupon=:IdCupon and estado=2");
            $stmt->execute(array('IdCupon'=>$cupon));
            if($stmt->rowCount()==1){
                foreach($_SESSION['car'][1] as $key=>$value){ 
                    if($key==$producto){
                        $respuesta=true;
                        $_SESSION['car'][1][$producto]['cupon']=$cupon;
                        $_SESSION['car'][1][$producto]['desc']=$valor;                    
                    }
                }
            }
        }
        
        $stmt=null;
    }catch(PDOException $e){
        $stmt=null;
    }
    return $respuesta;
};

?>                    