<?php
    session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$data['data'] = array();
	$data['res'] = '400';
	$data['msg'] = 'Error general de la consulta.';

	if(!empty($_SESSION) && !empty($_POST['tprecio'])){
		$query = "";
		$precio = "pvpublico";
		switch ($_POST['tprecio']) {
			case 'flota':
				$precio = "pvflota";
				break;
			case 'mayor':
				$precio = "pvmayor";
				break;
			default:
				$precio = "pvpublico";
				break;
		}

		if(!empty($_POST['producto'])){
			$query = " and concat(codinterno, nombre) like '%".$_POST['producto']."%'";
		}

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select id, codinterno, nombre, medida, stock, moneda, ".$precio." as precio from tblcatalogo where estado=2".$query." limit 20;");
			$stmt->execute();
			if($stmt->rowCount()>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$data['data'][] = array(
						'id' => $row['id'],
                        'codigo' => $row['codinterno'],
                        'nombre' => $row['nombre'],
						'medida' => $row['medida'],
						'stock' => $row['stock'],
						'moneda' => $row['moneda'],
						'precio' => $row['precio']
					);
				}
				$data['res'] = '200';
				$data['msg'] = 'Ok.';
			}else{
				$data['msg'] = 'No se encontró resultados.';
			}
			$stmt = null;
		}catch(PDOException $e){
			$stmt = null;
			$data['msg'] = $e->getMessage();
		}
	}else{
		$data['msg'] = 'El usuario no puede realizar esta consulta.';
	}

	echo json_encode($data);
?>