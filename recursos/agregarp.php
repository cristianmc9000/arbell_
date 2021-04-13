<?php
//Conectamos a la base de datos
require('conexion.php');

//Obtenemos los datos del formulario de registro
session_start();

$idPOST = $_POST["id_prod"];
$codigoPOST = $_POST["codigo"];
$cantidadPOST = $_POST["cantidad"];
$nombrePOST = $_POST["nombre"];
$precioPOST = $_POST["precio"];

$controlPOST = $_POST["control"];
$sucursal = $_SESSION['sucursal'];


if($controlPOST == "control" ) {

	$consultaMP = "UPDATE productos SET codigo='".$codigoPOST."', modelo='".$nombrePOST."', cantidad=".$cantidadPOST.", precio_ref=".$precioPOST." WHERE id='".$idPOST."';";
	mysqli_query($conexion, $consultaMP) or die(mysql_error());
	die('<script>$("#modal5").closeModal(); Materialize.toast("PRODUCTO MODIFICADO" , 4000);</script>');
}

$nombrePOST = htmlspecialchars(mysqli_real_escape_string($conexion, $nombrePOST));
$precioPOST = htmlspecialchars(mysqli_real_escape_string($conexion, $precioPOST));


$maxCaracteresNombre = "30";


if(strlen($nombrePOST) > $maxCaracteresNombre) {
	die('<script>Materialize.toast("El nombre del producto no puede superar los 30 caracteres." , 4000);</script>');
};

$consultaModelo = "SELECT codigo, modelo FROM productos WHERE sucursal='".$sucursal."'";

$resultadoConsultaModelo = mysqli_query($conexion, $consultaModelo) or die(mysql_error());

if(empty($codigoPOST) || empty($nombrePOST) || empty($precioPOST)) {
	
	die('<script>Materialize.toast("Debes introducir datos válidos." , 4000);</script> ');
}

$variableModelo=false;
$variableCodigo=false;
$hayResultados = true;
while ($hayResultados==true){
	$datosConsultaModelo = mysqli_fetch_array($resultadoConsultaModelo);
	if ($datosConsultaModelo) { 
		$modeloBD = $datosConsultaModelo['modelo'];
		$codigoBD = $datosConsultaModelo['codigo'];
		if (strtoupper($nombrePOST) == strtoupper($modeloBD)){
			$variableModelo=true;
		}
		if (strtoupper($codigoPOST) == strtoupper($codigoBD)){
			$variableCodigo=true;
		}

	} else {$hayResultados = false;}
}
if ($variableModelo) {
	die('<script>Materialize.toast("Ya existe un producto con el nombre:  <br><br>'.$nombrePOST.'" , 5000);</script> ');
}

if ($variableCodigo) {
	die('<script>Materialize.toast("Ya existe un producto con el código:  <br><br>'.$codigoPOST.'" , 5000);</script> ');
}
else {


	$consulta = "INSERT INTO `productos` (codigo, modelo, precio_ref, cantidad, sucursal) 
	VALUES ('$codigoPOST', '$nombrePOST', '$precioPOST' , '$cantidadPOST', '$sucursal')";
	

	if(mysqli_query($conexion, $consulta)) {
		die('<script>$("#modal1").closeModal(); Materialize.toast("PRODUCTO AGREGADO." , 4000);</script>');
	} else {
		die('Error');
	};
};
?>