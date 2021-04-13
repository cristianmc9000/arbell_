<?php
//Conectamos a la base de datos
require('conexion.php');


$imeiPOST = $_POST["imeibp"];
$descripcionPOST = $_POST["descripcionbp"];



	$consultaBP ="UPDATE prodime SET estado=0, descripcion='".$descripcionPOST."' WHERE imei=".$imeiPOST.";";
	mysqli_query($conexion, $consultaBP) or die(mysql_error());

	$consultaObtenerID ="SELECT id FROM prodime WHERE imei = ".$imeiPOST.";";
	$resultadoConsultaOID = mysqli_query($conexion, $consultaObtenerID) or die(mysql_error());
	$datosConsultaObtenerID = mysqli_fetch_array($resultadoConsultaOID);

	$consultaRestarCantidad ="UPDATE productos SET cantidad = cantidad -1 WHERE id='".$datosConsultaObtenerID['id']."';";
	mysqli_query($conexion, $consultaRestarCantidad) or die(mysql_error());
	
	die('<script>$("#modal3").closeModal(); Materialize.toast("PRODUCTO ELIMINADO.", 5000);</script>');

?>