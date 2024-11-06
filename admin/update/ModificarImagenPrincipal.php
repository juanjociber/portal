<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";

    if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['idproducto']) and !empty($_FILES['imagen'])){
        if($_SESSION['vgrole']=='admin'){
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            $idproducto=$_POST['idproducto'];
            
            $descripcion="";
            if (!empty($_POST['descripcion'])){
                $descripcion=$_POST['descripcion'];
            }

            $temporal=$_FILES['imagen']['tmp_name'];
            $extension=pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
            $archivo=$idproducto.'_'.date('YmdHis').'.'.$extension;
            if($extension=='jpg'){
                if (move_uploaded_file($temporal, $_SERVER['DOCUMENT_ROOT'].'/mycloud/portal/tienda/productos/'.$archivo)) {
                    try{
                        $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conmy->beginTransaction();

                        $stmt=$conmy->prepare("update tblproductos set imagen=:Imagen, actualizacion=:Actualizacion where idproducto=:IdProducto;");
                        $stmt->execute(array(
                            'IdProducto'=>$idproducto,
                            'Imagen'=>$archivo,
                            'Actualizacion'=>$usuario
                        ));
                        if ($stmt->rowCount()>0){
                            $stmt=$conmy->prepare("insert into tblgalerias(idproducto, archivo, descripcion, creacion, actualizacion) values(:IdProducto, :Archivo, :Descripcion, :Creacion, :Actualizacion)");
                            $stmt->execute(array(
                                'IdProducto'=>$idproducto,
                                'Archivo'=>$archivo,
                                'Descripcion'=>$descripcion,
                                'Creacion'=>$usuario,
                                'Actualizacion'=>$usuario
                            ));
                            if ($stmt->rowCount()>0){
                                $conmy->commit();
                                $res='200';
                                $msg="BD: Se modificó correctamente la imágen.";
                            } else {
                                $conmy->rollBack();
                                $msg="BD: Se pudo agregar la imagen a las galerías.";
                            }
                        } else {
                            $conmy->rollBack();
                            $msg="BD: No se pudo modificas la imágen.";
                        }
                        $stmt=null;
                    }catch(PDOException $e){
                        $conmy->rollBack();
                        $stmt=null;
                        $msg="BD: Problemas modificando la imágen.";
                    }
                } else {
                    $msg="APP: No se pudo subir la imágen al servidor.";
                }
            }else{
                $msg="APP: Solo esta permitido archivos *.jpg";
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