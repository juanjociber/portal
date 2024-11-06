<?php
session_start();
date_default_timezone_set("America/Lima");
$bandera=true;

if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera=false;
}

require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

$data['data'] = array();
$data['res'] = '400';
$data['msg'] = 'Error actualizando la Cotización.';

if($bandera==true && isset($_POST['action']) && !empty($_POST['cotid'])){
    try{
        $CotId=0;

        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->prepare("select id from tblcotizaciones where id=:Id and idvendedor=:IdVendedor and estado=2;");
            $stmt->execute(array('Id'=>$_POST['cotid'], 'IdVendedor'=>$_SESSION['vgid']));
            $row=$stmt->fetch();
            if($row){
                $CotId = $row['id'];
            }
            $stmt = null;
        }catch(PDOException $e){
            $stmt=null;
        }

        if($CotId>0){
            if($_POST['action'] == "del"){
                if(!empty($_POST['indice'])){
                    try{
                        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt=$conmy->prepare("delete from tblnotascotizacion where id=:Id and cotid=:CotId;");
                        $stmt->execute(array('Id'=>$_POST['indice'], 'CotId'=>$CotId));
                        $stmt = null;
                        $data['res'] = "200";
                        $data['msg'] = 'Se eliminó la Nota.';
                    }catch(PDOException $e){
                        $stmt = null;
                        $data['msg'] = $e->getMessage();
                    }                        
                }else{
                    $data['msg'] = 'No se reconoce el Nota.';
                }
            }else{
                if(!empty($_POST['nota'])){
                    if(strlen($_POST['nota'])<301){
                        $USUARIO=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
                        try{
                            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt=$conmy->prepare("insert into tblnotascotizacion(cotid, descripcion, creacion) values (:CotId, :Descripcion, :Creacion)");
                            $stmt->execute(array('CotId'=>$CotId, 'Descripcion'=>$_POST['nota'], 'Creacion'=>$USUARIO));
                            $stmt = null;
                            $data['res'] = "200";
                            $data['msg'] = 'Se agregó la Nota.';
                        }catch(PDOException $e){
                            $stmt = null;
                            $data['msg'] = $e->getMessage();
                        } 
                    }else{
                        $data['msg'] = 'El campo Nota no debe superar los 300 caracteres.';
                    }
                }else{
                    $data['msg'] = 'El campo Nota esta vacío.';
                }
            }
        }else{
            $data['msg'] = "La Cotización no esta disponible.";
        }   
    }catch(Exception $e){
        $data['msg'] = $e->getMessage();
    }
}else{
    $data['msg'] = "El usuario no puede realizar esta acción.";
}

echo json_encode($data);
?>