<?php
session_start();

$res='400';
$msg='No se ha podido registrar el cupón.';

if(!empty($_POST['cupon'])){
    $pedido=89;
    //$pedido=$_POST['pedido'];
    //$id=GuardarPedido($pedido, $_POST['cupon']);
    if(GuardarPedido($pedido, $_POST['cupon'])){
        $res="200";
        $msg="Ok.";
    }
}

$data[]=array('res'=>$res);
$data[]=array('msg'=>$msg);

echo json_encode($data);

function GuardarPedido($pedido_id, $cupon_id){
    $respuesta=false;
    $cupon_monto=0;
    $actualizacion=date('Ymd-His').' (cliente)';
    include($_SERVER['DOCUMENT_ROOT']."/tienda/config/fnconexmysql.php");
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conmy->beginTransaction();

        $stmt=$conmy->prepare('select monto from tblcupones where idcupon=:Cupon and estado=2 and vencimiento>now()');
        $stmt->execute(array('Cupon'=>$cupon_id));
        $row=$stmt->fetch();
        $cupon_monto=$row['monto'];

        if($cupon_monto>0){
            $stmt=$conmy->prepare("update tblcupones set estado=:Estado, actualizacion=:Actualizacion where idcupon=:IdCupon");
            $stmt->execute(array(
                'Estado'=>3,
                'Actualizacion'=>$actualizacion,
                'IdCupon'=>$cupon_id
            ));
            
            if($stmt->rowCount()>0){
                $stmt=$conmy->prepare("update tblpedidos set cupon_id=:IdCupon, cupon_monto=:MontoCupon where idpedido=:IdPedido");
                $stmt->execute(array(
                    'IdCupon'=>$cupon_id,
                    'MontoCupon'=>$cupon_monto,
                    'IdPedido'=>$pedido_id
                ));
                if($stmt->rowCount()>0){
                    //$respuesta='se guardo correctamente';
                    $respuesta=true;
                    $conmy->commit();                  
                }else{
                    //$respuesta="se hizo roolback porque no se pudo actualizar el cupon_id y cupon_monto en el pedido";
                    $conmy->rollBack();
                }
            }else{
                //$respuesta="se hizo roolback porque no se actualizo el estado del cupon";
                $conmy->rollBack();
            }       
        }else{
            //$respuesta="se hizo roolback porque el monto no es mayor a cero";
            $conmy->rollBack();
        }

        $stmt=null;
    }catch(PDOException $e){
        //$respuesta="se hizo rollback porque hubo un error en todo";
        $conmy->rollBack();
        $stmt=null;
    }
    return $respuesta;
};
?>                    