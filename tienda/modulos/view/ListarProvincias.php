<?php
	include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

	//$array_provincias[]=array('id'=>'0', 'provincia'=>'Seleccionar');
	$array_provincias=array();
	$data=array();
	$res='400';
	$msg='Se ha producido un error mostrando las Provincias.';
	
	if (!empty($_POST["region"])){
		try{
			$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt1=$conmy->prepare("select p.provincia from tblregiones r inner join tblprovincias p on r.idregion=p.idregion where r.region=? and p.estado=2;");
			$stmt1->execute(array($_POST['region']));
			while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
				$array_provincias[]=$row1['provincia'];
			}
			$stmt1=null;	
			$res='200';
			$msg='Ok.';	
		}catch(PDOException $e){
			$stmt1=null;
			$msg='Tenemos problemas para mostrar las Provincias.';
		}
	}else{
		$msg='No se ha seleccionado un Departamento.';
	}

	$data[]=array('res'=>$res);
	$data[]=array('msg'=>$msg);
	$data[]=$array_provincias;

	echo json_encode($data);
?>