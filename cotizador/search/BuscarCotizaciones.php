<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgid']) || empty($_SESSION['vgrole']) || empty($_POST)){
		$bandera=false;
    };

	$items=array();
	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';
    $page=0;
	$npage=0;

	if($bandera){
		require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

		$query=" and idvendedor=".$_SESSION['vgid'];

		if($_SESSION['vgrole']=='admin'){
			$query="";
		}		

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
			$stmt=$conmy->prepare("select id, cotizacion, fecha, cliruc, clinombre, vendnombre, moneda, tot_precioventa, estado from tblcotizaciones where estado>0".$query." order by id desc limit :Page, 20;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			$npage=$stmt->rowCount();
			if($npage>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'id' => $row['id'],
						'cotizacion' => $row['cotizacion'],
                        'fecha' => $row['fecha'],
                        'cliruc' => $row['cliruc'],
						'clinombre' => $row['clinombre'],
						'moneda' => $row['moneda'],
						'vendedor' => $row['vendnombre'],
						'total' => $row['tot_precioventa'],
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