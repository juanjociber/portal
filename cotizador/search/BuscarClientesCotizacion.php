<?php
    session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";


	$data['data'] = array();
	$data['res'] = '400';
	$data['msg'] = 'Error general de la consulta.';

	if(!empty($_SESSION) && !empty($_POST)){
		$query="";
		if(!empty($_POST['cliente'])){
			$query=" and concat(ruc, nombre) like '%".$_POST['cliente']."%'";
		}
		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select id, numero, ruc, nombre, direccion, contacto, telefono, correo from tblclientes where estado=2".$query." limit 20;");
			$stmt->execute();
			if($stmt->rowCount()>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$data['data'][] = array(
						'id' => $row['id'],
						'numero' => $row['numero'],
						'ruc' => $row['ruc'],
						'nombre' => $row['nombre'],
						'direccion' => $row['direccion'],						
						'contacto' => $row['contacto'],
						'telefono' => $row['telefono'],
						'correo' => $row['correo']
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