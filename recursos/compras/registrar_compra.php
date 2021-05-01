<?php 
	
//FALTA RECUEPRAR USUARIO CI: DE LA SESSION
require("../conexion.php");
require("../sesiones.php");
session_start();
$userci = $_SESSION['userCI'];
$array = json_decode($_POST["json"]);
<<<<<<< HEAD

//atributos de la compra
$valor = array_pop($array);
$descuento = array_pop($array);
$total_sd = array_pop($array);
$total_cd = array_pop($array);
=======
$total = array_pop($array);
>>>>>>> 55bff938e663f63986ab1079615c796f2fcb2aa1

//insertar un nuevo registro de compra en tabla: compras
$insertarCompra = "INSERT INTO `compras`(`ci_usu`,`totalsd`, `totalcd`,`descuento`,`valor_pesos`) VALUES ('".$userci."', ".$total_sd->{'_totalsd'}.", ".$total_cd->{'_totalcd'}.", ".$descuento->{'_descuento'}.", ".$valor->{'_valor'}." )";

mysqli_query($conexion, $insertarCompra);
//obtener el último id autogenerado tabla: compras
$ultimoid = var_export(mysqli_insert_id($conexion), true);

//insertar nuevo detalle de compra tabla: detalle_compra
$sql = mysqli_prepare($conexion, "INSERT INTO detalle_compra (codc, codp, cantidad, pupesos, pubs, pupesos_cd, pubs_cd) VALUES (?,?,?,?,?,?,?);");
$respuesta = false;

foreach ($array as $arr) {
	mysqli_stmt_bind_param($sql, 'isidddd', $ultimoid, $arr->{'id'}, $arr->{'cantidad'}, $arr->{'pupesos'}, $arr->{'pubs'}, $arr->{'pupesos_desc'}, $arr->{'pubs_desc'});
	$respuesta = mysqli_stmt_execute($sql);
}

echo $ultimoid;

mysqli_stmt_close($sql);


?>
