<?php 
	
//FALTA RECUEPRAR USUARIO CI: DE LA SESSION
require("../conexion.php");
require("../sesiones.php");
session_start();
//OBTENER FECHA Y HORA ACTUALES DE BOLIVIA
date_default_timezone_set("America/La_Paz");
$fecha = date("Y-m-d h:i:s");
$userci = $_SESSION['userCI'];
$array = json_decode($_POST["json"]);

//atributos de la compra
$ca = array_pop($array);
$valor = array_pop($array);
$descuento = array_pop($array);
$totalcd = array_pop($array);

//insertar un nuevo registro de compra en tabla: ventas
$insertarCompra = "INSERT INTO `ventas`(`ci_usu`,`ca`,`fecha`,`total`,`descuento`,`valor_peso`) VALUES (".$userci.", ".$ca->{'_ca'}.", '".$fecha."', ".$totalcd->{'total_cd'}.", ".$descuento->{'_descuento'}.",".$valor->{'_valor'}." )";
mysqli_query($conexion, $insertarCompra);

//obtener el último id autogenerado tabla: ventas
$ultimoid = var_export(mysqli_insert_id($conexion), true);

//insertar nuevo detalle de compra tabla: detalle_venta
$sql = mysqli_prepare($conexion, "INSERT INTO detalle_venta (codv, codp, cantidad, pubs, pubs_cd) VALUES (?,?,?,?,?);");
$respuesta = false;
foreach ($array as $arr) {
	mysqli_stmt_bind_param($sql, 'isidd', $ultimoid, $arr->{'id'}, $arr->{'cantidad'}, $arr->{'pubs'}, $arr->{'pubs_desc'});
	$respuesta = mysqli_stmt_execute($sql);
}
mysqli_stmt_close($sql);

//Reducir cantidad total del producto tabla: invcant
$res = false;
$reducirinv = mysqli_prepare($conexion, "UPDATE invcant SET cantidad = cantidad - ? WHERE codp = ?;");
foreach ($array as $arr) {
	mysqli_stmt_bind_param($reducirinv, 'is', $arr->{'cantidad'}, $arr->{'id'});
	$res = mysqli_stmt_execute($reducirinv); //devuelve un booleano 1: success, 0: error
	$cad = mysqli_stmt_error($reducirinv); //devuelve el error de mysql
}
mysqli_stmt_close($reducirinv);

echo $ultimoid;

?>
