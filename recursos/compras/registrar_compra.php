<?php 
	
//FALTA RECUEPRAR USUARIO CI: DE LA SESSION
require("../conexion.php");
require("../sesiones.php");
session_start();
$userci = $_SESSION['userCI'];
$array = json_decode($_POST["json"]);

//atributos de la compra
$valor = array_pop($array);
$descuento = array_pop($array);
$total_sd = array_pop($array);
$total_cd = array_pop($array);

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
mysqli_stmt_close($sql);

//Insertar datos a tabla: inventario
$res = false;
// $cad ="";
$insertarinv = mysqli_prepare($conexion, "INSERT INTO inventario (codp, pupesos, pubs, cantidad) VALUES(?,?,?,?);");
foreach ($array as $arr) {
	mysqli_stmt_bind_param($insertarinv, 'sddi', $arr->{'id'}, $arr->{'pupesos'}, $arr->{'pubs'}, $arr->{'cantidad'});
	$res = mysqli_stmt_execute($insertarinv);
	// $cad = mysqli_stmt_error();
}
mysqli_stmt_close($insertarinv);

//insertar datos a tabla: invcant$cad = "";
$insertarinvcant = mysqli_prepare($conexion, "UPDATE invcant SET cantidad = cantidad+? WHERE codp = ?;");
foreach ($array as $arr) {
	mysqli_stmt_bind_param($insertarinvcant, 'is', $arr->{'cantidad'}, $arr->{'id'});
	mysqli_stmt_execute($insertarinvcant);
}
mysqli_stmt_close($insertarinvcant);

echo $ultimoid;




?>
