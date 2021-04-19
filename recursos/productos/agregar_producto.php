<?php

require('../conexion.php');
require('../sesiones.php');
session_start();


$cod = $_POST["codigo"];

$foto = $_POST["fotoz"];
$linea = $_POST["linea"];
$descripcion = $_POST["descripcion"];
$pupesos = $_POST["pupesos"];
$pubs = $_POST["pubs"];
$cantidad = $_POST["cantidad"];
$fechav = $_POST["fechav"];

$periodo = $_SESSION["periodo"];
$year = $_SESSION['anio'];


$maxCaracteres = "250";

if(strlen($descripcion) > $maxCaracteres) {
	die('<script>Materialize.toast("La descripción del producto no puede superar los 30 caracteres." , 4000);</script>');
};
if(strlen($foto) > $maxCaracteres) {
	die('<script>Materialize.toast("Ruta de imagen demasiado larga." , 4000);</script>');
};




	$consultaBuscarID = "SELECT * FROM productos WHERE id = '".$cod."'";
	$resultadoConsultaBID = mysqli_query($conexion, $consultaBuscarID) or die(mysql_error());
	$datosConsultaBID = mysqli_fetch_array($resultadoConsultaBID);

	if(isset($datosConsultaBID['id'])){
		die('<script>Materialize.toast("Ya existe un producto con el código: '.$cod.'" ,5000)</script>');

	}


	$consulta = "INSERT INTO productos (id, foto, linea, descripcion, pupesos, pubs, cantidad, fechav, periodo) VALUES ('".$cod."','".$foto."','".$linea."','".$descripcion."','".$pupesos."','".$pubs."','".$cantidad."','".$fechav."','".$periodo."')";
	
	if(mysqli_query($conexion, $consulta) or die(mysql_error())) {
		die('?anio='.$year.'&mes='.$periodo);
	}

?>