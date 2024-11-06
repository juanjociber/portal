<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";

    if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['id']) and !empty($_POST['seogoogle']) and !empty($_POST['seourl'])){
        if($_SESSION['vgrole']=='admin'){
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            try{
                $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("update tblproductos set seogoogle=:Seogoogle, seourl=:Seourl, actualizacion=:Actualizacion where idproducto=:IdProducto;");
                $stmt->execute(array(
                    'IdProducto'=>$_POST['id'],
                    'Seogoogle'=>$_POST['seogoogle'],
                    'Seourl'=>$_POST['seourl'],
                    'Actualizacion'=>$usuario
                ));
                
                if($stmt->rowCount()>0){
                    $res='200';
                    $msg="BD: Se modificó correctamente el producto."; 
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
                $msg="BD: Problemas modificando el producto.".$e;
            }
        }else{
            $msg="APP: El usuario no puede realizar esta operación.";
        }
    }else{
        $msg="APP: La información enviada está incompleta.";
    }

    $data[]=array('res' =>$res);
    $data[]=array('msg'=>$msg);
    echo json_encode($data);
?>