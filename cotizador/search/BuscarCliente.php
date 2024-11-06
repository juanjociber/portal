<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgrole']) || empty($_POST)){
		$bandera=false;
    }

	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';

	if($bandera==true && !empty($_POST['cliente'])){
		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare('select id, numero, ruc, nombre, direccion, contacto, telefono, correo, observaciones, estado from tblclientes where id=:Id;');
			$stmt->execute(array('Id'=>$_POST['cliente']));
			$row=$stmt->fetch();
			if($row){
				$data['data']['id'] = $row['id']; 
				$data['data']['numero'] = $row['numero']; 
				$data['data']['ruc'] = $row['ruc']; 
				$data['data']['nombre'] = $row['nombre']; 
				$data['data']['direccion'] = $row['direccion']; 
				$data['data']['contacto'] = $row['contacto']; 
				$data['data']['telefono'] = $row['telefono'];
				$data['data']['correo'] = $row['correo'];
				$data['data']['obs'] = $row['observaciones'];
				$data['data']['estado'] = (int)$row['estado'];
				$msg='Ok.';
				$res='200';
			}else{
				$msg='No se encontro los datos del Cliente.';
			}
			$stmt=null;
		}catch(PDOException $e){
			$msg=$e->getMessage();
			$stmt=null;
		}
	}else{
		$msg="El usuario no puede realizar esta accion.";
	}

	$data['res']=$res;
	$data['msg']=$msg;
	
	echo json_encode($data);
?>