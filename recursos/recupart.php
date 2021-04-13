<?php
//Conectamos a la base de datos
require('conexion.php');


$imeiPOST = $_POST["imeibp"];
$descripcionPOST = $_POST["descripcionbp"];

if($descripcionPOST == "permanente"){
	$consultaBPM = "DELETE FROM prodime WHERE imei = '".$imeiPOST."'";
	mysqli_query($conexion, $consultaBPM) or die(mysql_error());
	die('<script> $("#modal4").closeModal(); Materialize.toast("El producto se eliminó de forma permanente.", 4000); </script>');
}


	$consultaBP ="UPDATE prodime SET estado=1, descripcion='".$descripcionPOST."' WHERE imei=".$imeiPOST.";";
	mysqli_query($conexion, $consultaBP) or die(mysql_error());

	$consultaObtenerID ="SELECT id FROM prodime WHERE imei = ".$imeiPOST.";";
	$resultadoConsultaOID = mysqli_query($conexion, $consultaObtenerID) or die(mysql_error());
	$datosConsultaObtenerID = mysqli_fetch_array($resultadoConsultaOID);


	//CONSULTA PARA REVISAR LA CANTIDAD (OBTENER LA CANTIDAD CORRECTA DE LA BASE DE DATOS)
	$consultaObtenerCantidadCorrecta = 'SELECT COUNT(id) FROM prodime where id= '.$datosConsultaObtenerID['id'].' and estado=1 and estadov=0';
	$resultadoConsultaOCC = mysqli_query($conexion, $consultaObtenerCantidadCorrecta) or die(mysql_error());
	$datosConsultaOCC = mysqli_fetch_array($resultadoConsultaOCC);
	//CONSULTA CORREGIR CANTIDAD FINAL
	$consultaCorregirCantidad ='UPDATE productos SET cantidad='.$datosConsultaOCC["COUNT(id)"].' , estado = 1 WHERE id='.$datosConsultaObtenerID['id'].'';
	mysqli_query($conexion, $consultaCorregirCantidad) or die(mysql_error());

	
	die('<script>$("#modal3").closeModal(); Materialize.toast("El producto ha sido restaurado." , 4000);</script>');

?>