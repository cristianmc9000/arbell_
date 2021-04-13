<?php
//Conectamos a la base de datos
require('conexion.php');


$imeiPOST = $_POST["imei_mod_art"];
$imeiantPOST = $_POST["imei_mod_art_ant"];

	$consultaMA = "UPDATE prodime SET imei=".$imeiPOST." WHERE imei=".$imeiantPOST.";";
	mysqli_query($conexion, $consultaMA) or die(mysql_error());

	die('<script>$("#modal4").closeModal(); Materialize.toast("El producto ha sido modificado..!", 5000);</script>');

?>