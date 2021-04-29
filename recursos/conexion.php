<?php 

// $conexion = new mysqli('br6vrwqejcpdav29tluj-mysql.services.clever-cloud.com','usz8khcb6vchmslt','1DjIm6ncGfmq6N81hRtt','br6vrwqejcpdav29tluj');

$conexion = new mysqli('localhost','root','','base_arbell');
$conexion->query("SET NAMES 'utf8'");
if($conexion->connect_error) { 
	die( 'Error: ('. $conexion->connect_errno .' )'. $conexion->connect_error); 
}
?>