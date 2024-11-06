<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";
    if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['id']) and !empty($_POST['producto']) and !empty($_POST['codigo']) and !empty($_POST['marca']) and !empty($_POST['medida'])){
        if($_SESSION['vgrole']=='admin'){
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            try{
                $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("update tblproductos set producto=:Producto, codigo=:Codigo, serie=:Serie, marca=:Marca, medida=:Medida, destacado=:Destacado, prioridad=:Prioridad, estado=:Estado, actualizacion=:Actualizacion where idproducto=:IdProducto;");
                $stmt->execute(array(
                    'IdProducto'=>$_POST['id'],
                    'Producto'=>$_POST['producto'],
                    'Codigo'=>$_POST['codigo'],
                    'Serie'=>$_POST['serie'],
                    'Marca'=>$_POST['marca'],
                    'Medida'=>$_POST['medida'],
                    'Destacado'=>$_POST['destacado'],
                    'Prioridad'=>$_POST['prioridad'],
                    'Estado'=>$_POST['estado'],
                    'Actualizacion'=>$usuario
                ));
                
                if($stmt->rowCount()>0){
                    $res='200';
                    $msg="BD: Se modificó correctamente el producto."; 
                }else{
                    $msg="BD: No se encontro cambios en la información.";
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
                $msg="BD: Problemas modificando el producto.";
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