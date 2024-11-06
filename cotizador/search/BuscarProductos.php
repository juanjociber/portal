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
	
	$items=array();
	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';
    $page=0;
	$npage=0;

	if($bandera){

		$query="";
		if(!empty($_POST['producto'])){
			$query=" and concat(codinterno, nombre) like '%".$_POST['producto']."%'";
		}
			
		if(isset($_POST['pagina'])){
            $page=(int)$_POST['pagina'];
        }

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select id, codinterno, nombre, marca, medida, stock, moneda, pvpublico, pvmayor, pvflota, fecha, observacion, estado from tblcatalogo where estado=2".$query." limit :Page, 20;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			$npage=$stmt->rowCount();
			if($npage>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id' => $row['id'],
                        'codigo' => $row['codinterno'],
                        'nombre' => $row['nombre'],
						'marca' => $row['marca'],
						'medida' => $row['medida'],
						'stock' => $row['stock'],
						'moneda' => $row['moneda'],
						'ppublico' => $row['pvpublico'],
						'pmayor' => $row['pvmayor'],
						'pflota' => $row['pvflota'],
                        'pmayor' => $row['pvmayor'],
                        'pflota' => $row['pvflota'],
                        'fecha' => $row['fecha'],
						'observacion' => $row['observacion'],
						'estado' => (int)$row['estado']
					);
				}
				$res='200';
				$msg='BD: Ok.';
			}else{
				$msg='No se encontró resultados.';
			}
			$stmt=null;
		}catch(PDOException $e){
			$stmt=null;
			$msg='Error en la BD.'.$e;
		}
	}else{
		$msg="El usuario no puede ejecutar esta consulta.";
	}

	$data['res']=$res;
	$data['msg']=$msg;
	$data['page']=$npage;
	$data['data']=$items;

	echo json_encode($data);
?>