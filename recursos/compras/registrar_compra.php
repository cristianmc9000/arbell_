<?php 
	
//FALTA RECUEPRAR USUARIO CI: DE LA SESSION
require("../conexion.php");
require("../sesiones.php");
session_start();
$userci = $_SESSION['userCI'];
$array = json_decode($_POST["json"]);
//atributos de la compra
$total_cd = array_pop($array);
$total_sd = array_pop($array);
$descuento = array_pop($array);
$valor = array_pop($array);
die(var_dump($array));

//insertar un nuevo registro de compra en tabla: compras
$insertarCompra = "INSERT INTO `compras`(`ci_usu`,`totalsd`, `totalcd`,`descuento`,`valor_pesos`) VALUES ('".$userci."', ".$total_sd->{'_totalsd'}.", ".$total_cd->{'_totalcd'}.", ".$descuento->{'_descuento'}.", ".$valor->{'_valor'}." )";

mysqli_query($conexion, $insertarCompra);
//obtener el último id autogenerado tabla: compras
$ultimoid = var_export(mysqli_insert_id($conexion), true);

//insertar nuevo detalle de compra tabla: detalle_compra
$sql = mysqli_prepare($conexion, "INSERT INTO detalle_compra (codc, codp, cantidad) VALUES (?,?,?);");
$respuesta = false;

foreach ($array as $arr) {
	mysqli_stmt_bind_param($sql, 'isi', $ultimoid, $arr->{'id'}, $arr->{'cantidad'});
	$respuesta = mysqli_stmt_execute($sql);
}

echo $ultimoid;

mysqli_stmt_close($sql);


?>
