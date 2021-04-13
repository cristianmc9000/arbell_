<?php
//Conectamos a la base de datos
require('conexion.php');


$idPOST = $_POST["idbp"];

	$consultaBP = "UPDATE productos SET estado=0 WHERE id=".$idPOST.";";	
	mysqli_query($conexion, $consultaBP) or die(mysql_error());
	die('<script>$("#modal6").closeModal(); Materialize.toast("PRODUCTO ELIMINADO", 4000);</script>');

?>