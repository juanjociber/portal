<?php
session_start();

include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
include($_SERVER['DOCUMENT_ROOT']."/portal/config/config.php");

$res='400';
$msg='Error actualizando el producto.';
$total=0;
$data=array();
$array_producto=array();

$idproducto=0;
$cantidad=0;
$producto="";
$medida="";

if(isset($_POST['action']) and !empty($_POST['id'])){
    $idproducto=openssl_decrypt($_POST['id'], COD, KEY);
    if(!empty($_POST['cantidad'])){
        $cantidad=$_POST['cantidad'];
    }
    switch($_POST['action']){
        case 'add':
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt1=$conmy->prepare("select codigo, producto, marca, medida, imagen from tblproductos where idproducto=:IdProducto;");
                $stmt1->execute(array('IdProducto'=>$idproducto));
                $row1=$stmt1->fetch();
                if($row1){
                    $array_producto=array(
                        'codigo'=>$row1['codigo'],
                        'producto'=>$row1['producto'],
                        'marca'=>$row1['marca'],
                        'cantidad'=>$cantidad,
                        'medida'=>$row1['medida'],
                        'imagen'=>$row1['imagen']
                    );
                }
            }catch(PDOException $e){
                $stmt1=null;
            }

            if(!isset($_SESSION['car'])){
                $_SESSION['car'][0]=array('pedido'=>0, 'ruc'=>'', 'cliente'=>'');
                $_SESSION['car'][1][$idproducto]=$array_producto;
            }else{
                $_SESSION['car'][1][$idproducto]=$array_producto;
            }

            $res='200';
            $msg='se agrego el producto.';
            break;
        case 'update':
                $_SESSION['car'][1][$idproducto]['cantidad']=$cantidad;
                $res='200';
                $msg='Se actualizo el producto.';
            break;
        case 'del':
                unset($_SESSION['car'][1][$idproducto]);
                $res='200';
                $msg='Se elimino el producto.';
            break;
        default:
            $msg='No se reconoce el comando.';
    }

    $total=count($_SESSION['car'][1]);
}else{
    $msg='Comando o producto invalido.';
}

$data[]=array('res'=>$res);
$data[]=array('msg'=>$msg);
$data[]=array('tot'=>$total);
$data[]=array('last'=>$array_producto);

echo json_encode($data);
?>

                    