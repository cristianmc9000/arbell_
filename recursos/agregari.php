<?php
//Conectamos a la base de datos
require('conexion.php');


$cantidadPOST = $_POST["cantidadi"];
$idPOST = $_POST["ida"];


//Definimos la cantidad máxima de caracteres
//Esta comprobación se tiene en cuenta por si se llegase a modificar el "maxlength" del formulario
//Los valores deben coincidir con el tamaño máximo de la fila de la base de datos

$maxCaracteresImei = "17";
$minCaracteresImei = "14";


//Si los input son de mayor tamaño, se "muere" el resto del código y muestra la respuesta correspondiente


//CONSULTA PARA REVISAR LA CANTIDAD (OBTENER LA CANTIDAD CORRECTA DE LA BASE DE DATOS)
$consultaObtenerCantidadCorrecta = 'SELECT COUNT(id) FROM prodime where id= '.$idPOST.' and estado=1 and estadov=0';


$arr=array();
$iii = 0;
$ii = 0;
while ( $ii < $cantidadPOST) {
    
    if($_POST[$ii] == '0'){

    }else{
	    $arr[$iii]="".$_POST[$ii];

	    if(strlen($arr[$iii]) > $maxCaracteresImei || strlen($arr[$iii]) < $minCaracteresImei || !(ctype_digit($arr[$iii]))) {
			die('<script>Materialize.toast("Los códigos imei deben ser numéricos y contener al menos 15 dígitos." , 6000);</script>');
		}
		$iii++;
	}
	$ii++;

}
if(count($arr) == 0){
	die('<script>Materialize.toast("Debes agregar datos válidos." , 4000);</script>');
}

for ($i=0; $i < count($arr); $i++) { 
	$contador = 0;
	for ($a=0; $a < count($arr); $a++) { 
		if ($arr[$i] == $arr[$a]) {
			$contador++;
		}
		if ($contador == 2){
			die('<script>Materialize.toast("Tiene datos repetidos." , 4000);</script>');
		}
	}
		
}


//consulta para comprobar si el imei ya existe
$consultaModelo = "SELECT imei FROM prodime";
$resultadoConsultaImei = mysqli_query($conexion, $consultaModelo) or die(mysql_error());




$variable=false;
$hayResultados = true;
while ($hayResultados==true){
	$datosConsultaImei = mysqli_fetch_array($resultadoConsultaImei);
	if ($datosConsultaImei) { 
		$modeloBD = $datosConsultaImei['imei'];
		
		for ($i = 0; $i < count($arr); $i++) {
		    if ($arr[$i] == $modeloBD){
				$variable=true;
				$existe=$modeloBD;
			}
		}
	} else {$hayResultados = false;}
}


if ($variable) {
	die('<script>Materialize.toast("Ya existe un producto con el imei: <b>'.$existe.'</b>" , 7000);</script>');
}
else {

//Lectura recomendada: https://mimentevuela.wordpress.com/2015/10/08/establecer-blowfish-como-salt-en-crypt-2/
	
	//Armamos la consulta para introducir los datos
	for ($i = 0; $i < count($arr); $i++) {

		$consulta = "INSERT INTO `prodime` (imei, id) 
		VALUES ('".$arr[$i]."', '".$idPOST."')";
		
		//Si los datos se introducen correctamente, mostramos los datos
		//Sino, mostramos un mensaje de error
		if(mysqli_query($conexion, $consulta) && ($i == (count($arr)-1) )) {

			$resultadoConsultaOCC = mysqli_query($conexion, $consultaObtenerCantidadCorrecta) or die(mysql_error());
			$datosConsultaOCC = mysqli_fetch_array($resultadoConsultaOCC);
			//CONSULTA CORREGIR CANTIDAD FINAL
			$consultaCorregirCantidad ='UPDATE productos SET cantidad='.$datosConsultaOCC["COUNT(id)"].' WHERE id='.$idPOST.'';
			mysqli_query($conexion, $consultaCorregirCantidad) or die(mysql_error());

			die('exito');
		} else if($i == (count($arr)-1)){
			die('<script>$("#modal4").closeModal();  Materialize.toast("ERROR #103" , 4000);</script>');
		};
	}
};
?>