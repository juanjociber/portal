<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";

    if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['id'])){
        if($_SESSION['vgrole']=='admin'){
            $usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
            try{
                $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("update tblproductos set etiquetas=:Etiquetas, actualizacion=:Actualizacion where idproducto=:Id;");
                $stmt->execute(array(
                    'Id'=>$_POST['id'],
                    'Etiquetas'=>$_POST['filtros'],
                    'Actualizacion'=>$usuario
                ));
                
                if($stmt->rowCount()>0){
                    $res='200';
                    $msg="BD: Se modificó correctamente los filtros."; 
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
                $msg="BD: Problemas modificando los filtros.".$e;
            }
        }else{
            $msg="APP: El usuario no puede realizar esta operación.";
        }
    }else{
        $msg="APP: La información enviada está incompleta.";
    }

    $data['res']=$res;
    $data['msg']=$msg;
    echo json_encode($data);
?>