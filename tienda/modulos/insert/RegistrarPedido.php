<?php
session_start();

$res='400';
$msg='No se ha podido completar la Orden de Pedido.';

$LastId=0;
$factura_fecha=date('Y-m-d H:i:s');
$factura_tipo="BOLETA";
$factura_ruc="";
$factura_empresa="";
$factura_nombres="";
$factura_apellidos="";
$factura_telefono="";
$factura_correo="";
$factura_direccion="";
$factura_nota="";

if(!empty($_POST)){
    if(!empty($_POST['fac_tipo']) and !empty($_POST['fac_nomb']) and !empty($_POST['fac_apel']) and !empty($_POST['fac_tele']) and !empty($_POST['fac_mail']) and !empty($_POST['fac_dire'])){
        $bandera=true;
        if($_POST['fac_tipo']=='factura'){
            $factura_tipo='FACTURA';
            if(!empty($_POST['fac_ruc']) and !empty($_POST['fac_empr'])){
                $factura_ruc=$_POST['fac_ruc'];
                $factura_empresa=$_POST['fac_empr'];
            }else{
                $bandera=false;
                $msg="El número de RUC o Razon Social estan vacíos.";
            }
        }

        if($bandera){
            $factura_nombres=$_POST['fac_nomb'];
            $factura_apellidos=$_POST['fac_apel'];
            $factura_telefono=$_POST['fac_tele'];
            $factura_correo=$_POST['fac_mail'];
            $factura_direccion=$_POST['fac_dire'];

            if(!empty($_POST['fac_nota'])){
                $factura_nota=$_POST['fac_nota'];
            }

            if(GuardarPedido()){
                $msg="Se genero correctamente tu pedido ".$LastId;
                if(EnviarCorreo($LastId)){
                    $msg.="Se envió correctamente el correo de confirmación.";
                }else{
                    $msg.="No se pudo enviar el correo.";
                }
                $res="200";
            }else{
                $msg="Estimado Cliente, no pudimos procesar tu pedido.";
            }
        }else{
            $msg='Estimado Cliente, debe llenar los campos obligatorios.';
        }
    }else{
        $msg='Estimado Cliente, debe llenar los campos obligatorios.';
    }

    $data[]=array('res'=>$res);
    $data[]=array('msg'=>$msg);

    echo json_encode($data);
}else{
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

function GuardarPedido(){
    $id=0;
    $res1=false;
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conmy->beginTransaction();
        $stmt1=$conmy->prepare("insert into tblpedidos(factura_fecha, factura_tipo, factura_ruc, factura_empresa, factura_nombres, factura_apellidos, factura_telefono, factura_correo, factura_direccion, factura_nota) values 
        (:FacturaFecha, :FacturaTipo, :FacturaRuc, :FacturaEmpresa, :FacturaNombres, :FacturaApellidos, :FacturaTelefono, :FacturaCorreo, :FacturaDireccion, :FacturaNota)");
        $stmt1->execute(array(
            'FacturaFecha'=>$GLOBALS['factura_fecha'],
            'FacturaTipo'=>$GLOBALS['factura_tipo'],
            'FacturaRuc'=>$GLOBALS['factura_ruc'],
            'FacturaEmpresa'=>$GLOBALS['factura_empresa'],
            'FacturaNombres'=>$GLOBALS['factura_nombres'],
            'FacturaApellidos'=>$GLOBALS['factura_apellidos'],
            'FacturaTelefono'=>$GLOBALS['factura_telefono'],
            'FacturaCorreo'=>$GLOBALS['factura_correo'],
            'FacturaDireccion'=>$GLOBALS['factura_direccion'],
            'FacturaNota'=>$GLOBALS['factura_nota'],
        ));
        
        $id=$conmy->lastInsertId();
    
        $stmt1=$conmy->prepare("insert into tbldetallepedido(idpedido, idproducto, producto, cantidad, medida) 
        values (?, ?, ?, ?, ?)");
        $stmt1->bindParam(1, $idpedido);
        $stmt1->bindParam(2, $idproducto);
        $stmt1->bindParam(3, $producto);
        $stmt1->bindParam(4, $cantidad);
        $stmt1->bindParam(5, $medida);
    
        foreach($_SESSION['car'][1] as $clave=>$valor){
            $idpedido=$id;
            $idproducto=$clave;
            $producto=$valor['producto'];
            $cantidad=$valor['cantidad'];
            $medida=$valor['medida'];
            $stmt1->execute();
        }
        $conmy->commit();
        $GLOBALS['LastId']=$id;

        $_SESSION['car'][0]['pedido']=$id;
        $res1=true;
    }catch(PDOException $e){
        //$res1=$e;
        $conmy->rollBack();
        $stmt1=null;
    }

    return $res1;
};

function EnviarCorreo($id){
    $res2=false;
    include($_SERVER['DOCUMENT_ROOT']."/portal/tienda/modulos/email/MailConfirmacionPedido.php");
    if(fnEnviarCorreos($id)){
        $res2=true;
    }
    return $res2;
};

?>

                    