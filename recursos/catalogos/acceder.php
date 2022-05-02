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

//PARA OBTENER EL PERIODO ACTUAL
$fecha = date("Y-m-d");
$actual_y = date("Y");

$array_index = array(
	$actual_y."-01-11", 
	$actual_y."-03-08",
	$actual_y."-05-10", 
	$actual_y."-07-12", 
	$actual_y."-09-14", 
	$actual_y."-11-16", 
	$actual_y."-01-11"
);

$indice = 0;
for($i=0; $i<count($array_index)-1; $i++){
	if(check_in_range($array_index[$i], $array_index[$i+1], $fecha)){
		$indice = $i;
		$i = count($array_index)-1;
	}else{
		$indice = $i;
	}
}
//FUNCION PARA REVISAR EL INTERVALO DE LA FECHA DEL PERIODO
function check_in_range($fecha_inicio, $fecha_fin, $fecha){
     $fecha_inicio = strtotime($fecha_inicio);
     $fecha_fin = strtotime($fecha_fin);
     $fecha = strtotime($fecha);
     if(($fecha >= $fecha_inicio) && ($fecha < $fecha_fin)){
         return true;
     }
     else{
         return false;
     }
 }


//Comprobamos si los datos son correctos
if($caBD == $ca){
	session_start();
	$_SESSION['periodox'] = $indice+1;
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