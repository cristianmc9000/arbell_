<?php
//Conectamos a la base de datos
require('conexion.php');


$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
$nomant = $_POST["nombre_ant"];
$apeant = $_POST["apellidos_ant"];
$ciant = $_POST["ci_ant"];
$idPOST = $_POST["id"];

	if($nombrePOST=="" || $apellidosPOST==""){
		die('<script>$("#modal2").openModal(); </script> Debe llenar los campos correctamente.');
	}
	if($ciPOST != $ciant){
		$consultaBuscarCi = "SELECT * FROM clientes WHERE CI= '".$ciPOST."'";
		$resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());
		$datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);
		if($datosConsultaBCI['CI'] != ""){
			die('<script>$("#modal2").openModal(); </script> Ya existe un cliente con el CI: '.$ciPOST);
		}
	}

	if(strtoupper($nombrePOST) != strtoupper($nomant) || strtoupper($apellidosPOST) != strtoupper($apeant)) {
		$consultaBuscarNyA = "SELECT * FROM clientes WHERE nombre='".$nombrePOST."' and apellidos = '".$apellidosPOST."'";
		$resultadoConsultaBNA = mysqli_query($conexion, $consultaBuscarNyA) or die(mysql_error());
		$datosConsultaBNA = mysqli_fetch_array($resultadoConsultaBNA);
		if($datosConsultaBNA['nombre'] != ""){
			die('<script>$("#modal2").openModal(); </script> Ya existe un cliente con el nombre y apellido: '.$nombrePOST.' '.$apellidosPOST);
		}
	}

	$consultaAC ="UPDATE clientes SET ci='".$ciPOST."', nombre ='".$nombrePOST."', apellidos= '".$apellidosPOST."', telefono = '".$telefonoPOST."' WHERE id='".$idPOST."'";
	if(mysqli_query($conexion, $consultaAC) or die(mysql_error())){
		die('<script>$("#modal3").closeModal(); Materialize.toast("Datos de cliente modificados.", 5000);</script>');
	}else{
		die('<script>$("#modal2").openModal();</script> ERROR #103');
	}


?>