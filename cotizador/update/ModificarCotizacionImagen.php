<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $bandera=true;
    $data = array();
    $data['res'] = '400';
    $data['msg'] = 'Error general.';

    if($bandera){
        if($_POST['action'] == "del"){
            if(!empty($_POST['id'] && !empty($_POST['cotid']))){
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("delete from tblcotizacionimagenes where id=:Id and cotid=:CotId;");
                    $stmt->execute(array('Id'=>$_POST['id'], 'CotId'=>$_POST['cotid']));
                    $stmt = null;
                    $data['res'] = "200";
                    $data['msg'] = 'Se eliminó la Imágen.';
                }catch(PDOException $e){
                    $stmt = null;
                    $data['msg'] = $e->getMessage();
                }                        
            }else{
                $data['msg'] = 'No se reconoce el registro.';
            }
        }else{
            if(!empty($_POST['cotid']) && !empty($_POST['imagen'])){
                $ImagenNombre = $_POST['cotid'].'_'.uniqid().".jpeg";
                $ImagenCodificada = $_POST["imagen"];
                $ImagenCodificadaLimpia = str_replace("data:image/jpeg;base64,", "", $ImagenCodificada);
                $ImagenDecodificada = base64_decode($ImagenCodificadaLimpia);
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/mycloud/portal/cotizador/anexos/".$ImagenNombre, $ImagenDecodificada);
                    
                $Usuario = date('Ymd-His').'('.$_SESSION['vgusuario'].')';
                $Descripcion = '';

                if(!empty($_POST['descripcion'])){$Descripcion = substr($_POST['descripcion'], 0, 100);}                    

                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("insert into tblcotizacionimagenes(cotid, nombre, descripcion, creacion) values (:CotId, :Nombre, :Descripcion, :Creacion)");
                    $stmt->execute(array('CotId'=>$_POST['cotid'], 'Nombre'=>$ImagenNombre, 'Descripcion'=>$Descripcion, 'Creacion'=>$Usuario));
                    $stmt = null;
                    $data['res'] = "200";
                    $data['msg'] = 'Se agregó la Imágen.';
                }catch(PDOException $e){
                    $stmt = null;
                    $data['msg'] = $e->getMessage();
                }
            }else{
                $data['msg'] = 'No se esta enviando la imágen.';
            }
        }         
    }else{
        $data['msg'] = 'El usuario no puede realizar esta acción.';
    }

    echo json_encode($data);
?>