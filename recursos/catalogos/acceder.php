<?php
	
//Conectamos a la base de datos
require('../conexion.php');
date_default_timezone_set("America/La_Paz");
//Obtenemos los datos del formulario de acceso
$ca = $_POST["codigo"]; 

//Escribimos la consulta necesaria
$consulta = "SELECT * FROM `clientes` WHERE CA='".$ca."'";

//Obtenemos los resultados
$resultado = mysqli_query($conexion, $consulta);
$datos = mysqli_fetch_array($resultado);

//Guardamos los resultados del nombre de usuario en minúsculas
//y de la contraseña de la base de datos
$caBD = $datos['CA'];

//Comprobamos si los datos son correctos
if($caBD == $ca){
	session_start();
	$_SESSION['usuario'] = $datos['nombre'];
	$_SESSION['apellidos'] = $datos['apellidos'];
	$_SESSION['estado'] = 'Autenticado';
	$_SESSION['userCI'] = $datos['CI'];
	$_SESSION['ca'] = $caBD;
	$_SESSION['telf'] = $datos['telefono'];

	die('1');
	/* Sesión iniciada, si se desea, se puede redireccionar desde el servidor */
//Si los datos no son correctos, o están vacíos, muestra un error
//Además, hay un script que vacía los campos con la clase "acceso" (formulario)
} else if ( $caBD != $ca || $ca == "" )  {
	die ('0');
} else {
	die('Error');
};
?>