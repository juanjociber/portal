<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $items=[];
    $data=[];
    $res='400';
    $msg='APP: Problemas para obtener los datos.';
    if(!empty($_SESSION['vgrole']) and !empty($_POST['id'])){
        if($_SESSION['vgrole']=='admin'){
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conmy->prepare('select idusuario, nombre, usuario, role, estado from tblusuarios where idusuario=:IdUsuario;');
                $stmt->execute(array('IdUsuario'=>$_POST['id']));
                $row=$stmt->fetch();
                if($row){
                    $items[]=array('id'=>$row['idusuario'], 'nombre'=>$row['nombre'], 'usuario'=>$row['usuario'], 'role'=>$row['role'], 'estado'=>$row['estado']);
                    $msg='BD: Ok.';
                    $res='200';
                }else{
                    $msg='BD: No se encontro el Usuario seleccionado.';
                }
            }catch(PDOException $e){
                $msg='BD: Error consultando.';
            }
        }else{
            $msg='APP: El usuario no puede modificar el registro.';
        }
    }else{
        $msg='APP: Faltan parámetros.';
    }

    $data[]=array('res'=>$res);
    $data[]=array('msg'=>$msg);
    $data[]=$items;

    echo json_encode($data);
?>