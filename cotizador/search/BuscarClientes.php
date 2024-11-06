<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgrole']) || empty($_POST)){
		$bandera=false;
    }

	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$items=array();
	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';
    $page=0;
	$npage=0;

	if($bandera==true && !empty($_POST['fechainicial']) && !empty($_POST['fechafinal']) && isset($_POST['pagina'])){

		$query="";
		if(!empty($_POST['cliente'])){
			$query = " where concat(ruc, nombre) like '%".$_POST['cliente']."%'";
		}else{
			$query = " where fecha between '".$_POST['fechainicial']."' and '".$_POST['fechafinal']."'";
		}

		if(!empty($_POST['pagina'])){
			$page=(int)$_POST['pagina'];
		}

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select id, numero, ruc, nombre, direccion, contacto, telefono, correo, observaciones, fecha, usuario, estado from tblclientes".$query." order by id desc limit :Page, 20;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			$npage=$stmt->rowCount();
			if($npage>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id'=>$row['id'],
                        'numero' => $row['numero'],
                        'ruc' => $row['ruc'],
						'nombre' => $row['nombre'],
						'direccion' => $row['direccion'],						
						'contacto' => $row['contacto'],
                        'telefono' => $row['telefono'],
						'correo' => $row['correo'],
						'obs' => $row['observaciones'],
						'fecha' => $row['fecha'],
						'usuario' => $row['usuario'],
						'estado'=>(int)$row['estado']
					);
				}
				$res='200';
				$msg='Ok.';
			}else{
				$msg='No se encontró resultados.';
			}
			$stmt=null;
		}catch(PDOException $e){
			$stmt = null;
			$msg = $e->getMessage();
		}
	}else{
		$msg="El usuario no puede realizar esta operación.";
	}

	$data['res'] = $res;
	$data['msg'] = $msg;
	$data['page'] = $npage;
	$data['data'] = $items;

	echo json_encode($data);
?>