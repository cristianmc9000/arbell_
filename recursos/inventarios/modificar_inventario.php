<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$id = $_POST["id"];
$pupesos = $_POST["pupesos"];
$pubs = $_POST["pubs"];
$cantidad = $_POST["cantidad"];
$fecha_v = $_POST["fechav"];
$year = $_SESSION['anio'];
$periodo = $_SESSION["periodo"];

	$consulta ="UPDATE inventario SET pupesos='".$pupesos."', pubs='".$pubs."', cantidad='".$cantidad."', fecha_venc='".$fecha_v."' WHERE id= '".$id."' ";

	if(mysqli_query($conexion, $consulta) or die(mysql_error())) {
		die('?mes='.$periodo);
	}

?>