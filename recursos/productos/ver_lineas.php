<?php 
	require("../conexion.php");
	require('../sesiones.php');
	session_start();
	$periodo = $_SESSION["periodo"];

	$result = $conexion->query("SELECT * FROM lineas WHERE estado = 1 AND periodo = ".$periodo);
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
   		$rows[] = $row;
	}

	echo json_encode($rows);
?>