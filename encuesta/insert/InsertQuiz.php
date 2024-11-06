<?php
    session_start();
    $idencuesta=1;
    $sesion=session_id();

    $bandera=true;
    $res="400";
    $msg="Problemas para registrar su encuesta";

    if (!isset($_POST['empresa']) || $_POST['empresa']==""){
        $bandera=false;
        $msg="Por favor, ingrese el nombre de su Empresa.";
    }

    if (!isset($_POST['nombre']) || $_POST['nombre']==""){
        $bandera=false;
        $msg="Por favor, ingrese su nombre.";
    }

    if (!isset($_POST['rpta11']) || $_POST['rpta11']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.1.";
    }

    if (!isset($_POST['rpta12']) || $_POST['rpta12']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.2.";
    }

    if (!isset($_POST['rpta13']) || $_POST['rpta13']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.3.";
    }

    if (!isset($_POST['rpta14']) || $_POST['rpta14']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.4.";
    }

    if (!isset($_POST['rpta15']) || $_POST['rpta15']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.5.";
    }

    if (!isset($_POST['rpta16']) || $_POST['rpta16']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 1.6.";
    }

    if (!isset($_POST['rpta21']) || $_POST['rpta21']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 2.1.";
    }

    if (!isset($_POST['rpta30']) || $_POST['rpta30']=="null"){
        $bandera=false;
        $msg="Por favor, responda la pregunta 3.";
    }

    if($bandera){

        $empresa=$_POST['empresa'];

        $nombre=$_POST['nombre'];

        $preg11=1;
        $rpta11=$_POST['rpta11'];

        $preg12=2;
        $rpta12=$_POST['rpta12'];
        
        $preg13=3;
        $rpta13=$_POST['rpta13'];

        $preg14=4;
        $rpta14=$_POST['rpta14'];

        $preg15=5;
        $rpta15=$_POST['rpta15'];

        $preg16=6;
        $rpta16=$_POST['rpta16'];

        $preg21=7;
        $rpta21=$_POST['rpta21'];
        
        $preg30=8;
        $rpta30=$_POST['rpta30'];

        if(AgregarEncuesta()){
            $msg="Se registro correctamente la encuesta.";
            $res="200";
        }
    }

    function AgregarEncuesta(){
        //include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        include($_SERVER['DOCUMENT_ROOT']."/config/fnconexmysql.php");
        $respuesta=false;
        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt1=$conmy->prepare("select count(idsesion) as cantidad from tblsesiones where empresa=:Empresa;");
            $stmt1->execute(array('Empresa'=>$GLOBALS['empresa']));
            $row1=$stmt1->fetch();
            if($row1['cantidad']==0){
                $conmy->beginTransaction();
                $stmt1=$conmy->prepare("insert into tblsesiones(idencuesta, fecha, empresa, nombre, sesion) values (:IdEncuesta, now(), :Empresa, :Nombre, :Sesion)");
                $stmt1->execute(array(
                    'IdEncuesta'=>$GLOBALS['idencuesta'],
                    'Empresa'=>$GLOBALS['empresa'],
                    'Nombre'=>$GLOBALS['nombre'],
                    'Sesion'=>$GLOBALS['sesion'],
                ));
            
                $LastId=$conmy->lastInsertId();
                $stmt1=$conmy->prepare(
                    "insert into tblrespuestas(idsesion, idpregunta, respuesta) values 
                    (".$LastId.", ".$GLOBALS['preg11'].", '".$GLOBALS['rpta11']."'),
                    (".$LastId.", ".$GLOBALS['preg12'].", '".$GLOBALS['rpta12']."'),
                    (".$LastId.", ".$GLOBALS['preg13'].", '".$GLOBALS['rpta13']."'),
                    (".$LastId.", ".$GLOBALS['preg14'].", '".$GLOBALS['rpta14']."'),
                    (".$LastId.", ".$GLOBALS['preg15'].", '".$GLOBALS['rpta15']."'),
                    (".$LastId.", ".$GLOBALS['preg16'].", '".$GLOBALS['rpta16']."'),
                    (".$LastId.", ".$GLOBALS['preg21'].", '".$GLOBALS['rpta21']."'),
                    (".$LastId.", ".$GLOBALS['preg30'].", '".$GLOBALS['rpta30']."');"
                );
                $stmt1->execute();
                $conmy->commit();
                $_SESSION['quiz'][0]['encuesta']=$LastId;
                $respuesta=true;
            }
        }catch(PDOException $e){
            $conmy->rollBack();
            $stmt1=null;
            $msg=$e;
        }
        return $respuesta;
    }

    $data[]=array('res'=>$res);
    $data[]=array('msg'=>$msg);
    echo json_encode($data);

?>