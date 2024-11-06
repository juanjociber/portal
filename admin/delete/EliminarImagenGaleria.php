<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    $data=array();
    $res='400';
    $msg="APP: Ha ocurrido un error en el proceso.";

    if(!empty($_SESSION['vgrole']) and  !empty($_POST['idgaleria'])){
        if($_SESSION['vgrole']=='admin'){
            try{
                $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt1=$conmy->prepare("delete from tblgalerias where idgaleria=:IdGaleria;");
                $stmt1->execute(array(
                    'IdGaleria'=>$_POST['idgaleria']
                ));
                if($stmt1->rowCount()>0){
                    $res='200';
                    $msg="BD: Se eliminó correctamente la imágen."; 
                }
                $stmt1=null;
            }catch(PDOException $e){
                $stmt1=null;
                $msg="BD: Problemas eliminando la imágen.";
            }
        }
    }else{
        $msg="APP: La información enviada está incompleta.";
    }

    $data[]=array('res' =>$res);
    $data[]=array('msg'=>$msg);
    echo json_encode($data);
?>