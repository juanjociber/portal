<?php
    session_start();

    $data['res'] = '400';
    $data['msg'] = 'Error general.';

    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $bandera1 = false;
    if(!empty($_SESSION['vgrole'])){
        if($_SESSION['vgrole'] == 'admin'){
            $bandera1 = true;
        }
    }

    //https://www.youtube.com/watch?v=FSIhVQ7PMfk
    if($bandera1){
        if(!empty(file_get_contents('php://input')) && !empty($_SESSION['car']['condiciones']['tprecio'])){

            $json = file_get_contents('php://input');
            $datos = json_decode($json, true); // Indicamos que NO deseamos una array como resultado

            /*
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
            */

            unset($_SESSION['car']['productos']);

            foreach ($datos as $key=>$valor) {
                $_SESSION['car']['productos'][]=array(
                    'id' => $valor['id'],
                    'codigo' => $valor['codigo'],
                    'nombre' => $valor['producto'],
                    'medida' => $valor['medida'],
                    'precio' => $valor['precio'],
                    'cantidad' => $valor['cantidad'],
                    'estado' => $valor['estado']                    
                );
            }    
            $data['res'] = '200';
            $data['msg'] = 'Ok.';                
          
            /*
            $bandera2 = true;
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                foreach ($datos as $key=>$valor) {
                    $stmt = $conmy->query("select id, codinterno, nombre, medida, ".$query_precio." as precio from tblcatalogo where id=".$valor['id']." and estado=2;");
                    $row = $stmt->fetch();
                    if($row){
                        $_SESSION['car']['productos'][]=array(
                            'id' => $row['id'],
                            'codigo' => $row['codinterno'],
                            'nombre' => $row['nombre'],
                            'medida' => $row['medida'],
                            'precio' => $row['precio'],
                            'cantidad' => $valor['cantidad']
                        );
                    }else{
                        $bandera2 = false;
                        $data['msg'] = 'No se reconoce el producto con Id: '.$key;
                        break;
                    }
                }
                $stmt = null;
    
                if($bandera2){
                    $data['res'] = '200';
                    $data['msg'] = 'Ok.';
                }
            }catch(PDOException $e){
                $stmt = null;
                $data['msg'] = $e->getMessage();
            }*/

        }else{
            $data['msg'] = 'La información esta incompleta.';
        }
    }else{
        $data['msg'] = 'El usuario no puede realizar esta acción.';
    }

    echo json_encode($data);
?>