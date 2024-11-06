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

		if(!empty($_POST['producto'])){
			$query=" where concat(producto, codigo) like '%".$_POST['producto']."%'";
		}else{
			if(!empty($_POST['etiqueta'])){
				$query=" where etiquetas like '%".$_POST['etiqueta']."%'";
			};

			if(!empty($_POST['estado'])){
				if($query==""){
					$query=" where estado=".$_POST['estado'];
				}else {
					$query.=" and estado=".$_POST['estado'];
				};				
			};
		};
			
		$page=(($_POST['pagina'])-1)*15;

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->query("select count(*) as total from tblproductos".$query.";");
            $stmt->execute();
            $row=$stmt->fetch();
            $npg=ceil($row['total']/15);

			$stmt=$conmy->prepare("select idproducto, producto, codigo, marca, prioridad, estado from tblproductos".$query." limit :Page, 15;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount()){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id'=>$row['idproducto'],
						'producto'=>$row['producto'],
						'codigo'=>$row['codigo'],
						'marca'=>$row['marca'],
						'prioridad'=>$row['prioridad'],
						'estado'=>(int)$row['estado']
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

	$data['res']=$res;
	$data['npg']=$npg;
	$data['msg']=$msg;
	$data['data']=$items;

	echo json_encode($data);
?>