<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgid']) || empty($_POST)){
		$bandera=false;
    };

	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$items=array();
	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';
    $page=0;
	$npage=0;

	if($bandera){
		$query="";

		if(!empty($_POST['cotizacion'])){
			$query=" and cotizacion ='".$_POST['cotizacion']."'";
		}else{
			if(!empty($_POST['fechainicial']) && !empty($_POST['fechafinal'])){
				$query.=" and fecha between '".$_POST['fechainicial']."' and '".$_POST['fechafinal']."'";
			}
		}
			
		if(isset($_POST['pagina'])){
            $page=(int)$_POST['pagina'];
        }

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select id, cotizacion, fecha, cliruc, clinombre, vendnombre, tot_precioventa, estado from tblcotizaciones where idvendedor=:Vendedor and estado>0".$query." limit :Page, 20;");
			$stmt->bindParam(':Vendedor', $_SESSION['vgid'], PDO::PARAM_INT);
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			$npage=$stmt->rowCount();
			if($npage>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id'=>$row['id'],
						'cotizacion'=>$row['cotizacion'],
                        'fecha'=>$row['fecha'],
                        'cliruc'=>$row['cliruc'],
						'clinombre'=>$row['clinombre'],
						'vendedor'=>$row['vendnombre'],
						'total'=>$row['tot_precioventa'],
						'estado'=>(int)$row['estado']
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
			$msg=$e;
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