<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$idPOST = $_POST["id"];
$periodo = $_SESSION["periodo"];
// $year = $_SESSION['anio'];

// die($periodo."<<<");
	$consultaBorrar = "UPDATE inventario SET estado=0 WHERE id= '".$idPOST."'";
	mysqli_query($conexion, $consultaBorrar) or die(mysqli_error($conexion));
	
	
	$res = $conexion->query("UPDATE invcant a SET a.cantidad = (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = (SELECT c.codp FROM inventario c WHERE c.id = ".$idPOST.")) WHERE a.codp = (SELECT d.codp FROM inventario d WHERE d.id = ".$idPOST.")");

	if ($res) {
		die('1');
	}else{
		die(mysqli_error($conexion));
	}



?>