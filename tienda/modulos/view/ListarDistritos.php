<?php
	include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
	//$array_distritos[]=array();
	$array_distritos=array();
	$data=array();
	$res='400';
	$msg='Se ha producido un error mostrando los Distritos.';
	
	if (!empty($_POST["prov"])){
		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt1=$conmy->prepare("select d.distrito from tblprovincias p inner join tbldistritos d on p.idprovincia=d.idprovincia where p.provincia=? and d.estado=2;");
			$stmt1->execute(array($_POST['prov']));
			$stmt1->execute();
			while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
				$array_distritos[]=$row1['distrito'];
			}
			$stmt1=null;	
			$res='200';
			$msg='Ok.';
	
		}catch(PDOException $e){
			$stmt1=null;
			$msg='Tenemos problemas para mostrar los Distritos.';
		}
	}else{
		$msg='No se ha seleccionado una Provincia.';
	}

	$data[]=array('res'=>$res);
	$data[]=array('msg'=>$msg);
	$data[]=$array_distritos;

	echo json_encode($data);
?>