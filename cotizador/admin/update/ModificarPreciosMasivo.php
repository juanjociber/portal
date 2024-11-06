<?php
    session_start();
    date_default_timezone_set("America/Lima");

    $bandera=true;
    if(empty($_SESSION['vgrole'])){
        $bandera=false;
    }else{
        if($_SESSION['vgrole']!='admin'){
            $bandera=false;
        }
    }

    $res='400';
    $msg='Error general en el proceso.';
    $data=array();

    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
    
    try {
        if($bandera){
            if(!empty($_FILES['archivo'])){
                $seguimiento=date('YmdHis');
                $nombre_temporal=$_FILES['archivo']['tmp_name'];
                $extension=pathinfo($_FILES["archivo"]["name"],PATHINFO_EXTENSION);
                if($extension=='xlsx'){
                    $Usuario=date('Ymd-His').' ('.$_SESSION['vgusuario'].')';
                    if (move_uploaded_file($nombre_temporal, $_SERVER['DOCUMENT_ROOT'].'/mycloud/portal/cotizador/temporales/'.$seguimiento.'.'.$extension)) {
                        include($_SERVER['DOCUMENT_ROOT'].'/mycloud/library/simplexlsx-0.8.19/src/SimpleXLSX.php');
                        $xlsx = new SimpleXLSX($_SERVER['DOCUMENT_ROOT'].'/mycloud/portal/cotizador/temporales/'.$seguimiento.'.'.$extension);
                        try{
                            $conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt=$conmy->prepare("update tblcatalogo set stock=?, moneda=?, pvpublico=?, pvmayor=?, pvflota=?, fecha=?, actualizacion=? where id=?");
                            $stmt->bindParam(1, $Stock);
                            $stmt->bindParam(2, $Moneda);
                            $stmt->bindParam(3, $PvPublico);
                            $stmt->bindParam(4, $PvMayor);
                            $stmt->bindParam(5, $PvFlota);
                            $stmt->bindParam(6, $Fecha);
                            $stmt->bindParam(7, $Actualizacion);
                            $stmt->bindParam(8, $Id);
                            $x=0;
                            foreach ($xlsx->rows() as $i=>$fields){
                                if($i==0){ continue; }#evitar la cabecera del archivo
                                $Stock = $fields[1];
                                $Moneda = $fields[2];
                                $PvPublico = $fields[3];
                                $PvMayor = $fields[4];
                                $PvFlota = $fields[5];
                                $Fecha = $fields[6];
                                $Actualizacion = $Usuario;
                                $Id = $fields[0];                            
                                $stmt->execute();
                                $x+=1;
                                if($x>1000){
                                    break;
                                }
                            }
                            $res='200';
                            $msg='Se actualizaron los Productos.';
                            $stmt=null;
                        }catch(PDOException $e){
                            $msg=$e;
                            $stmt=null;
                        }
                    }else{
                        $msg="Error moviendo el archivo.";
                    }
                }else{
                    $msg="Solo se permiten archivos con extensión *.xlsx";
                }
            }else{
                $msg='La información esta incompleta.';
            }
        }else{
            $msg='El usuario no puede ejecutar esta acción.';
        }        
    } catch (Exception $e) {
        $msg=$e->getMessage();
    }    

    $data['res']=$res;
    $data['msg']=$msg;
    echo json_encode($data);
?>