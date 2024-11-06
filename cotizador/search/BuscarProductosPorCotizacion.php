<?php
    session_start();
	$bandera=true;

	if(empty($_SESSION['vgid']) || empty($_SESSION['vgrole']) || empty($_POST)){
		$bandera=false;
    };

	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$items=array();
	$data=array();
	$res='400';
	$msg='Error general procesando la consulta.';
	$npage=0;

	if($bandera==true && !empty($_POST['codigo'])){
		$page=0;
		if(isset($_POST['pagina'])){
			$page=(int)$_POST['pagina'];
		}

		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("select c.id, c.cotizacion, c.fecha, c.cliruc, c.clinombre, c.vendnombre, c.moneda, c.tot_precioventa, c.nota, c.estado, p.codigo, p.producto, p.cantidad, p.precio, p.medida from tblcotizaciones c inner join tbldetallecotizacion p on c.id=p.idcotizacion where p.codigo='".$_POST['codigo']."' order by c.fecha desc limit :Page, 20;");
			$stmt->bindParam(':Page', $page, PDO::PARAM_INT);
			$stmt->execute();
			$npage=$stmt->rowCount();
			if($npage>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$items[]=array(
						'cotid' => $row['id'],
						'cotnombre' => $row['cotizacion'],
						'cotfecha' => $row['fecha'],
						'cliruc' => $row['cliruc'],
						'clinombre' => $row['clinombre'],
						'vendnombre' => $row['vendnombre'],
						'cotmoneda' => $row['moneda'],						
						'cottotal' => $row['tot_precioventa'],
						'cotnota'=>$row['nota'],
						'cotestado' => (int)$row['estado'],
						'procodigo'=>$row['codigo'],
						'pronombre'=>$row['producto'],
						'procantidad'=>$row['cantidad'],
						'proprecio'=>$row['precio'],
						'promedida'=>$row['medida']
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