<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

$res='400';
$msg='APP: Error al procesar los datos.';
$data=array();

//funcion con variable por referencia. ejm: function foo(&$var){$var++;}; $a=5; foo($a); $a es 6 aquí;
function fnValidarClave($clave,&$mensaje){
	if(strlen($clave)<5){
		$mensaje='APP: La clave debe tener al menos 5 letras.';
		return false;
	}

	if (!preg_match('/[a-z]/',$clave)){
		$mensaje='APP: La clave debe contener minúsculas [a-z].';
		return false;
	}

	if (!preg_match('/[A-Z]/',$clave)){
		$mensaje='APP: La clave debe contener mayúsculas [A-Z].';
		return false;
	}

	if (!preg_match('/[0-9]/',$clave)){
		$mensaje='APP: La clave debe contener números [0-9].';
		return false;
	}

	if (!preg_match('/[$@&]/',$clave)){
		$mensaje='APP: La clave debe contener simbolos [$,@,&].';
		return false;
	}

	$mensaje='APP: Ok';
	return true;
}

if(!empty($_POST['id']) and !empty($_POST['role']) and !empty($_POST['nombre']) and !empty($_POST['clave']) and !empty($_SESSION['vgrole']) and !empty($_SESSION['vgusuario'])){
	if($_SESSION['vgrole']=='admin'){			
		if (fnValidarClave($_POST['clave'], $mensaje)){
			$opciones=array('cost'=>10); //por defecto es 10
			$key=password_hash($_POST['clave'], PASSWORD_BCRYPT, $opciones);
			$usuario=date('Ymd-His').'('.$_SESSION['vgusuario'].')';

			try{
				$conmy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt=$conmy->prepare("update tblusuarios set nombre=:Nombre, clave=:Clave, role=:Role, estado=:Estado, actualizacion=:Actualizacion where idusuario=:IdUsuario;");
				$stmt->execute(array(
					'Nombre'=>$_POST['nombre'],
					'Clave'=>$key,
					'Role'=>$_POST['role'],
					'Estado'=>$_POST['estado'],
					'Actualizacion'=>$usuario,
					'IdUsuario'=>$_POST['id']
				));
				if($stmt->rowCount()>0){
					$res='200';
					$msg="BD: Se modificó correctamente el Usuario."; 
				}
				$stmt=null;
			}catch(PDOException $e){
				$msg='BD: Error al modificar la información.'.$e;
				$stmt=null;
			}
		}else{
			$msg=$mensaje;
		}
	}else{
		$msg='APP: El usuario no puede ejecutar esta acción.';
	}
}else{
	$msg='APP: Parámetros incompletos.';
}

$data[]=array('res'=>$res);
$data[]=array('msg'=>$msg);

echo json_encode($data)
?>