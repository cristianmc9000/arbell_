<?php
//Conectamos a la base de datos
require('conexion.php');


$idPOST = $_POST["eid"];
$totalPOST = $_POST["etotal"];
$fechaPOST = $_POST["efecha"];
$cantidadPOST = $_POST["ecantidad"];

	for ($i = 0; $i < $cantidadPOST; $i++) {
		$consultaVerificar = "SELECT cantidad FROM detalle WHERE id_venta = ".$idPOST." AND idpro = ".$_POST[$i];
		$resultadoVerificar = mysqli_query($conexion, $consultaVerificar) or die(mysql_error());
		$datosVerificar = mysqli_fetch_array($resultadoVerificar);
		if($datosVerificar['cantidad'] < $_POST[$i."c"]){
			die('<script>Materialize.toast("No puede aumentar las cantidades vendidas." , 5000);</script>');
		}
	}

	$consultaMV ="UPDATE venta SET total='".$totalPOST."', fecha='".$fechaPOST."' WHERE id=".$idPOST.";";
	mysqli_query($conexion, $consultaMV) or die(mysql_error());

	for ($i = 0; $i < $cantidadPOST; $i++) {
			$consultaDevolver = "UPDATE productos SET cantidad = cantidad+((SELECT cantidad FROM detalle WHERE id_venta = ".$idPOST." AND idpro = ".$_POST[$i].")-".$_POST[$i."c"]." ) WHERE id = ".$_POST[$i];
			mysqli_query($conexion, $consultaDevolver) or die(mysql_error());
			$consultaModDetalle = "UPDATE detalle SET cantidad = ".$_POST[$i."c"]." WHERE id_venta=".$idPOST." AND idpro = ".$_POST[$i];
			mysqli_query($conexion, $consultaModDetalle  ) or die(mysql_error());
		if ($_POST[$i."c"] == 0) {
			$consultaBorrarDetalle = "DELETE FROM detalle WHERE id_venta='".$idPOST."' AND idpro =".$_POST[$i];
			mysqli_query($conexion, $consultaBorrarDetalle) or die(mysql_error());
		}
	}
	$c = 0;
	for ($i = 0; $i < $cantidadPOST; $i++) {
		if ($_POST[$i."c"] == 0 ) {
			$c = $c+1;
		}
	}

	if ($c == $cantidadPOST) {
		$consultaBorrarVenta = "DELETE FROM venta WHERE id=".$idPOST;
		mysqli_query($conexion, $consultaBorrarVenta) or die(mysql_error());
	}

	die('<script>$("#modal4").closeModal(); Materialize.toast("Registro de venta modificado." , 5000);</script>');

?>