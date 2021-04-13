<?php
//Conectamos a la base de datos
require('conexion.php');


$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
	if($nombrePOST=="" || $apellidosPOST==""){
		die('<script>$("#modal2").openModal(); </script> Debe llenar los campos correctamente.');
	}

	$consultaBuscarCi = "SELECT * FROM clientes WHERE CI= '".$ciPOST."'";
	$resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());
	$datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);
	if($datosConsultaBCI['CI'] != ""){
		die('<script>$("#modal2").openModal(); </script> Ya existe un cliente con el CI: '.$ciPOST);
	}

	$consultaBuscarNyA = "SELECT * FROM clientes WHERE nombre='".$nombrePOST."' and apellidos = '".$apellidosPOST."'";
	$resultadoConsultaBNA = mysqli_query($conexion, $consultaBuscarNyA) or die(mysql_error());
	$datosConsultaBNA = mysqli_fetch_array($resultadoConsultaBNA);
	if($datosConsultaBNA['nombre'] != ""){
		die('<script>$("#modal2").openModal(); </script> Ya existe un cliente con el nombre y apellido: '.$nombrePOST.' '.$apellidosPOST);
	}

	$consultaAC ="INSERT INTO `clientes`(`CI`, `nombre`, `apellidos`, `telefono`) VALUES ('".$ciPOST."','".$nombrePOST."','".$apellidosPOST."','".$telefonoPOST."')";
	if(mysqli_query($conexion, $consultaAC) or die(mysql_error())){
		die('<script>$("#modal2").openModal(); $("#modal1").closeModal();</script> <b>Cliente agregado a la base de datos.</b> <br> Nombres: '.$nombrePOST.' '.$apellidosPOST.'<br>CI: '.$ciPOST);
	}else{
		die('<script>$("#modal2").openModal();</script> ERROR #103');
	}


?>