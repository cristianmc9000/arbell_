<?php
//Conectamos a la base de datos
require('conexion.php');


$idregPOST = $_POST["idreg"];
$cantPOST = $_POST["cantidad"];

	// $consultaBD ="DELETE FROM `detalle` WHERE id_venta=".$idregPOST.";";
	$consultaBR ="UPDATE venta SET estado=0 WHERE id=".$idregPOST.";";
	// && (mysqli_query($conexion, $consultaBD) or die(mysql_error()))

	if((mysqli_query($conexion, $consultaBR) or die(mysql_error()))){
		
	}else{
		die('<script>$("#modal2").openModal(); $("#modal3").closeModal();</script> ERROR #100');
	}

	
 

	//Armamos la consulta para introducir los datos
	for ($i = 0; $i < $cantPOST; $i++) {
		// $consultaBD ="DELETE FROM `detalle` WHERE id_venta=".$idregPOST.";";

		$consultaObtenerCantidad = 'SELECT cantidad FROM detalle WHERE id_venta = "'.$idregPOST.'" and idpro="'.$_POST[$i].'"';
		$resultadoCOC = mysqli_query($conexion, $consultaObtenerCantidad) or die(mysql_error());
		$datosConsultaOC = mysqli_fetch_array($resultadoCOC);

		$consultaObCantRestante = 'SELECT cantidad FROM productos WHERE id = "'.$_POST[$i].'"';
		$resultadoCOCR = mysqli_query($conexion, $consultaObCantRestante)  or die(mysql_error());
		$datosConsultaOCR = mysqli_fetch_array($resultadoCOCR);

		$CantFinal = $datosConsultaOCR["cantidad"] + $datosConsultaOC["cantidad"];
		$consultaSumarCantidad = 'UPDATE productos SET cantidad='.$CantFinal.' WHERE id='.$_POST[$i].'';
		$resultadoSC = mysqli_query($conexion, $consultaSumarCantidad)  or die(mysql_error());
	}
	die("<script>$('#modal3').closeModal(); Materialize.toast('VENTA ELIMINADA CORRECTAMENTE, PRODUCTOS DEVUELTOS A VENTAS.', 5000);</script>");
?>