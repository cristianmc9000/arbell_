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

// die(var_dump($array));
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
	// $cad = mysqli_stmt_error($sql);
}
mysqli_stmt_close($sql);


//CONSULTA PARA REDUCIR CANTIDAD DE PRODUCTOS INDIVIDUALES DE INVENTARIO Y DE PRODUCTOS tablas: inventario, invcant
//DEVOLVER AL ULTIMO REGISTRO DE INVENTARIO  LOS PRODUCTOS DE DEVOLUCIONES Y DE ERRORES EN VENTAS.
foreach ($array as $arr){ 
	$cant = $arr->{'cantidad'};
	$conexion->query("UPDATE invcant SET cantidad = cantidad - ".$cant." WHERE codp = '".$arr->{'id'}."'");
	while($cant>0){
		$consultaobtenercantidad = "SELECT id, cantidad, MIN(fecha_reg) FROM inventario WHERE codp = '".$arr->{'id'}."' AND estado = 1 LIMIT 1";
		$result = mysqli_query($conexion, $consultaobtenercantidad);
		$datos = mysqli_fetch_array($result);
		$cant_inv = $datos['cantidad'];
		$id_inv = $datos['id'];

		if($cant_inv <= $cant){
			$conexion->query("UPDATE inventario SET cantidad = 0, estado = 0 WHERE id = ".$id_inv);
			$cant = $cant - $cant_inv;
		}else{
			$conexion->query("UPDATE inventario SET cantidad = cantidad - ".$cant." WHERE id = ".$id_inv);
			$cant = $cant - $cant_inv;
		}
	}
}



echo $ultimoid;

?>
