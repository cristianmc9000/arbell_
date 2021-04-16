<?php
//Conectamos a la base de datos
require('../conexion.php');


$ciPOST = $_POST["ci"];
$nombrePOST = $_POST["nombre"];
$apellidosPOST = $_POST["apellidos"];
$telefonoPOST = $_POST["telefono"];
$passwordPOST = $_POST["password"];
$password1POST = $_POST["password1"];

/* die('<script>Materialize.toast('.$ciPOST.')</script> '); */

if($passwordPOST != $password1POST){
	die('<script> Materialize.toast("Passwords no coinciden") </script>'); 
}

	$consultaBuscarCi = "SELECT * FROM usuarios WHERE CI= '".$ciPOST."'";
	$resultadoConsultaBCI = mysqli_query($conexion, $consultaBuscarCi) or die(mysql_error());


	$datosConsultaBCI = mysqli_fetch_array($resultadoConsultaBCI);

	if($datosConsultaBCI["CI"] != "" ){
		die('<script> Materialize.toast("Ya existe usuario con el CI:'.$ciPOST.'") </script> ');
	}

	/* $consultaBuscarNyA = "SELECT * FROM clientes WHERE nombre='".$nombrePOST."' and apellidos = '".$apellidosPOST."'";
	$resultadoConsultaBNA = mysqli_query($conexion, $consultaBuscarNyA) or die(mysql_error());
	$datosConsultaBNA = mysqli_fetch_array($resultadoConsultaBNA);
	if($datosConsultaBNA['nombre'] != ""){
		die('<script>$("#modal2").openModal(); </script> Ya existe un cliente con el nombre y apellido: '.$nombrePOST.' '.$apellidosPOST);
	} */

	$consultaAC ="INSERT INTO `usuarios`(`CI`, `nombre`, `apellidos`, `telefono`,`password`) VALUES ('".$ciPOST."','".$nombrePOST."','".$apellidosPOST."','".$telefonoPOST."', '".$passwordPOST."')";
	if(mysqli_query($conexion, $consultaAC) or die(mysql_error())){
		die('<script>Materialize.toast("<b>Usuario agregado a la base de datos.</b>",5000); $("#modal1").closeModal();</script> ');
	}


?>