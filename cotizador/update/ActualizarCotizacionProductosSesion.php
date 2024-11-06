<?php
session_start();
date_default_timezone_set("America/Lima");
$bandera1=true;

if(empty($_SESSION['vgrole']) || empty($_POST)){
    $bandera1=false;
}

$res='400';
$msg='Error general.';
$data=[];

if($bandera1){
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    
    if(!empty($_POST['action']) && !empty($_SESSION['car']['condiciones'])){

        if($_POST['action'] == "del"){
            if(isset($_POST['indice'])){
                unset($_SESSION['car']['productos'][$_POST['indice']]);
                $res = '200';
                $msg = 'Se eliminó el Producto.';
            }else{
                $msg = 'No se reconoce el producto.';
            }            
        }else{
            $ProId = 0;
            $ProCodigo = "";
            $ProNombre = "";
            $ProMedida = "";
            $ProMoneda = "";
            $ProPrecio = 0;
            $ProCantidad = 0;
            $ProEstado = 0; // 0:Seleccionar, 1:STOCK, 2:IMPORTACION

            if(!empty($_POST['proestado'])){$ProEstado = $_POST['proestado'];} 

            if($_SESSION['vgrole'] == "admin"){
                if(!empty($_POST['proid'])){$ProId = $_POST['proid'];}
                if(!empty($_POST['procodigo'])){$ProCodigo = $_POST['procodigo'];}
                if(!empty($_POST['pronombre'])){$ProNombre = $_POST['pronombre'];}
                if(!empty($_POST['promedida'])){$ProMedida = $_POST['promedida'];}
                if(!empty($_POST['promoneda'])){$ProMoneda = $_POST['promoneda'];}
                if(!empty($_POST['proprecio'])){$ProPrecio = $_POST['proprecio'];}
                if(!empty($_POST['procantidad'])){$ProCantidad = $_POST['procantidad'];}                               
            }else{
                $query_precio = "pvpublico";
                switch ($_SESSION['car']['condiciones']['tprecio']) {
                    case 'mayor':
                        $query_precio = "pvmayor";
                        break;
                    case 'flota':
                        $query_precio = "pvflota";
                        break;                        
                    default:
                        $query_precio = "pvpublico";
                        break;
                }
                
                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("select id, codinterno, nombre, medida, moneda, ".$query_precio." as precio from tblcatalogo where id=:Id and estado=2;");
                    $stmt->execute(array('Id'=>$_POST['proid']));
                    $row=$stmt->fetch();
                    if($row){
                        $ProId = $row['id'];
                        $ProCodigo = $row['codinterno'];
                        $ProNombre = $row['nombre'];
                        $ProMedida = $row['medida'];
                        $ProMoneda = $row['moneda'];
                        $ProPrecio = $row['precio'];
                        if(!empty($_POST['procantidad'])){$ProCantidad=$_POST['procantidad'];}
                    }
                }catch(PDOException $e){
                    $stmt=null;
                    $msg=$e;
                }
            }

            if($ProId>0 && !empty($ProNombre) && !empty($ProMedida) && !empty($ProMoneda) && $ProCantidad>0){
                
                $bandera2 = true;
                if(strlen($ProCodigo)>30){
                    $bandera2 = false;
                    $msg = 'El campo código no puede superar los 30 caracteres.';
                }

                if(strlen($ProNombre)>300){
                    $bandera2 = false;
                    $msg = 'El campo nombre no puede superar los 300 caracteres.';
                }

                if(strlen($ProMedida)>30){
                    $bandera2 = false;
                    $msg = 'El campo medida no puede superar los 30 caracteres.';
                }

                if($bandera2){
                    if($_SESSION['car']['condiciones']['moneda'] == "USD"){
                        if($ProMoneda == "PEN"){
                           $ProPrecio = round(($ProPrecio / $_SESSION['car']['condiciones']['tasa']), 2);
                        }
                    }else{
                        if ($ProMoneda == "USD"){
                            $ProPrecio = round(($ProPrecio * $_SESSION['car']['condiciones']['tasa']), 2);
                        }
                    }
                    
                    $_SESSION['car']['productos'][]=array(
                        'id' => $ProId,
                        'codigo' => $ProCodigo,
                        'nombre' => $ProNombre,
                        'medida' => $ProMedida,
                        'precio' => $ProPrecio,
                        'cantidad' => $ProCantidad,
                        'estado' => $ProEstado
                    );
                    //$total=count($_SESSION['car']['productos']);
                    $res = '200';
                    $msg = 'Se agregó el producto.';
                }
            }else{
                $msg = 'Información incompleta.';
            }
        }
    }else{
        $msg = 'Comando o condiciones no establecidas.';
    }
}else{
    $msg = 'El usuario no puede realizar esta acción.';
}

$data['res']=$res;
$data['msg']=$msg;

echo json_encode($data);
?>