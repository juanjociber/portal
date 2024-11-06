<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

$items=array();
$res='400';
$msg='APP: Error al procesar los datos.';
$data=array();

if(!empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario']) and !empty($_POST['producto']) and !empty($_POST['marca']) and !empty($_POST['medida'])){
	if($_SESSION['vgrole']=='admin'){
		$usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';
		$codigo="-";
		if(!empty($_POST['codigo'])){
			$codigo=$_POST['codigo'];
		}

		$serie="-";
		if(!empty($_POST['serie'])){
			$serie=$_POST['serie'];
		}

		try{
			$conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$conmy->prepare("insert into tblproductos(producto, codigo, serie, marca, medida, seogoogle, seourl, creacion, actualizacion) values(:Producto, :Codigo, :Serie, :Marca, :Medida, :SeoGoogle, :SeoUrl, :Creacion, :Actualizacion);");
			$stmt->execute(array(
				'Producto'=>$_POST['producto'],
				'Codigo'=>$codigo,
				'Serie'=>$serie,
				'Marca'=>$_POST['marca'],
				'Medida'=>$_POST['medida'],
				'SeoGoogle'=>$_POST['producto'],
				'SeoUrl'=>$_POST['seourl'],
				'Creacion'=>$usuario,
				'Actualizacion'=>$usuario
			));
			if($stmt->rowCount()>0){
				$res='200';
				$msg="BD: Se agregó correctamente el producto."; 
			}
			$stmt=null;
		}catch(PDOException $e){
			$msg='BD: Error al guardar la información.'.$e;
			$stmt=null;
		}
	}else{
		$msg="APP: El usuario no puede realizar esta operación.";
	}	
}else{
	$msg='APP: Parámetros incompletos.';
}

$data[]=array('res'=>$res);
$data[]=array('msg'=>$msg);

echo json_encode($data)
?>