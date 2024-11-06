<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgrole']) || empty($_POST)){
		$bandera=false;
    }else{
		if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
			$bandera=false;
		}
	}

	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';

	if(!empty($_POST['producto'])){
		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare('select id, codinterno, codexterno, nombre, marca, medida, stock, moneda, pvpublico, pvmayor, pvflota, fecha, observacion, estado from tblcatalogo where id=:Id;');
			$stmt->execute(array('Id'=>$_POST['producto']));
			$row=$stmt->fetch();
			if($row){
				$data['data']['id']=$row['id']; 
				$data['data']['codinterno']=$row['codinterno']; 
				$data['data']['codexterno']=$row['codexterno']; 
				$data['data']['nombre']=$row['nombre']; 
				$data['data']['marca']=$row['marca']; 
				$data['data']['medida']=$row['medida']; 
				$data['data']['stock']=$row['stock'];
				$data['data']['moneda']=$row['moneda'];
				$data['data']['ppublico']=$row['pvpublico'];
				$data['data']['pmayor']=$row['pvmayor'];
				$data['data']['pflota']=$row['pvflota'];
				$data['data']['fecha']=$row['fecha'];
				$data['data']['observacion']=$row['observacion'];
				$data['data']['estado']=(int)$row['estado'];
				$msg='Ok.';
				$res='200';
			}else{
				$msg='No se encontro los datos del Producto.';
			}
			$stmt=null;
		}catch(PDOException $e){
			$msg=$e->getMessage();
			$stmt=null;
		}
	}else{
		$msg="El usuario no puede ejecutar esta consulta.";
	}

	$data['res']=$res;
	$data['msg']=$msg;
	
	echo json_encode($data);
?>