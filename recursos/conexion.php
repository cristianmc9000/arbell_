<?php 

$conexion = new mysqli('localhost','root','','base_arbell');
$conexion->query("SET NAMES 'utf8'");
if($conexion->connect_error) { 
	die( 'Error: ('. $conexion->connect_errno .' )'. $conexion->connect_error); 
}
?>