<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";

    if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['idgaleria']) and !empty($_POST['idproducto']) and !empty($_FILES['imagen'])){
        if($_SESSION['vgrole']=='admin'){
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            $descripcion="";
            if(!empty($_POST['descripcion'])){
                $descripcion=$_POST['descripcion'];
            }
            //$nombre2=$_FILES['archivo']['name'];
            $temporal=$_FILES['imagen']['tmp_name'];
            $extension=pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
            $archivo=$_POST['idproducto'].'_'.date('YmdHis').'.'.$extension;
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';

            if($extension=='jpg'){
                if (move_uploaded_file($temporal, $_SERVER['DOCUMENT_ROOT'].'/mycloud/portal/tienda/productos/'.$archivo)) {
                    try{
                        $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt1=$conmy->prepare("update tblgalerias set archivo=:Archivo, descripcion=:Descripcion, actualizacion=:Actualizacion where idgaleria=:IdGaleria;");
                        $stmt1->execute(array(
                            'IdGaleria'=>$_POST['idgaleria'],
                            'Archivo'=>$archivo,
                            'Descripcion'=>$descripcion,
                            'Actualizacion'=>$usuario
                        ));
                        if($stmt1->rowCount()>0){
                            $res='200';
                            $msg="BD: Se modificó correctamente la imágen."; 
                        }
                        $stmt1=null;
                    }catch(PDOException $e){
                        $stmt1=null;
                        $msg="BD: Problemas modificando la imágen.";
                    }
                } else {
                    $msg="APP: No se pudo subir la imágen al servidor.";
                }
            }else{
                $msg="APP: Solo esta permitido archivos *.jpg";
            }
        }
    }else{
        $msg="APP: La información enviada está incompleta.";
    }

    $data[]=array('res' =>$res);
    $data[]=array('msg'=>$msg);
    echo json_encode($data);
?>