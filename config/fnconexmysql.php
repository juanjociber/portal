<?php
//MySQL PDO
//require_once 'mysqllogin.php';
$hostname = 'localhost';
//$database = 'gpemsac_tienda';
//$username = 'gpemsac_shop';
$database = 'gpemsac_tienda';
$username = 'root';
$password='mysql';
//$password = 'Gp3M$2023';

try {
	$conmy = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//echo 'Conectado a '.$con->getAttribute(PDO::ATTR_CONNECTION_STATUS);
}
catch (PDOException $ex) {
	echo 'Error de conexión. '.$ex->getMessage();
}
?>