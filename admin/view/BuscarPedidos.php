<?php
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$items=array();
	$data=array();
	$res='400';
	$msg='APP: Error general procesando la consulta.';
	$npg=0;

	if(!empty($_SESSION['vgrole'])){
		$query="";
		if(!empty($_POST['fechainicial']) and !empty($_POST['fechafinal'])){
			$query=" where date_format(factura_fecha, '%Y-%m-%d') between '".$_POST['fechainicial']."' and '".$_POST['fechafinal']."'";
		}
			
		$page=(($_POST['pagina'])-1)*15;

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->query("select count(*) as total from tblpedidos".$query.";");
            $stmt->execute();
            $row=$stmt->fetch();
            $npg=ceil($row['total']/15);

			$stmt=$conmy->prepare("select idpedido, factura_fecha, factura_ruc, factura_empresa, concat(factura_nombres, ' ', factura_apellidos) as contacto, factura_telefono, factura_correo, factura_estado from tblpedidos".$query." limit :Page, 15;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount()){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id'=>$row['idpedido'],
						'fecha'=>$row['factura_fecha'],
						'ruc'=>$row['factura_ruc'],
						'empresa'=>$row['factura_empresa'],
						'contacto'=>$row['contacto'],
						'telefono'=>$row['factura_telefono'],
						'correo'=>$row['factura_correo'],
						'estado'=>(int)$row['factura_estado']
					);
				}
				$res='200';
				$msg='BD: Ok.';
			}else{
				$msg='BD: No se ha encontrado resultados para esta consulta.';
			}
			$stmt=null;
		}catch(PDOException $e){
			$stmt=null;
			$msg='BD: Ha ocurrido un error en la BD.'.$e;
		}
	}else{
		$msg="El usuario no puede ejecutar esta acción.";
	}

	$data[]=array('res'=>$res);
	$data[]=array('npg'=>$npg);
	$data[]=array('msg'=>$msg);
	$data[]=$items;

	echo json_encode($data);
?>