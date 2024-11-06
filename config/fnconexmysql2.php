<?php
//MySQL PDO
//require_once 'mysqllogin.php';
$hostname = 'localhost';
// $database = 'tiendagpem';
// $username = 'gpemsac';
// $password = 'gpemsac$';

$database = 'gpemsac_tienda';
$username = 'root';
$password = 'mysql';

try {
$conmy = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//echo 'Conectado a '.$con->getAttribute(PDO::ATTR_CONNECTION_STATUS);
}
catch (PDOException $ex) {
	echo 'Error conectando a la BBDD. '.$ex->getMessage(); 
	die();
	$conmy =null;
}
?>