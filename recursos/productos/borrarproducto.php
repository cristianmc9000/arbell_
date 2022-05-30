<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$idPOST = $_POST["id"];
$periodo = $_SESSION["periodo"];
$year = $_SESSION['anio'];

	$res = $conexion->query("SELECT cantidad FROM invcant WHERE codp = '".$idPOST."'");
	$res = $res->fetch_all();

	if ($res[0][0] < 1) {
		$consultaBorrar = "UPDATE productos SET estado=0 WHERE id= '".$idPOST."'";
		if(mysqli_query($conexion, $consultaBorrar) or die(mysqli_error($conexion))){
			if ($periodo == 'total') {
				die('');
			}else{
				die('?mes='.$periodo);
			}
			
		}
	}else{
		die('2');
	}



?>