<!-- FALTA CONTROLAR QUE NO PUEDA PAGAR SOBRE EL TOTAL -->

<?php 
require("../conexion.php");
date_default_timezone_set("America/La_Paz");
$codv = $_GET['codv'];
$monto = $_GET['monto'];
$fecha = date("Y-m-d h:i:s");

$result = $conexion->query("INSERT INTO pagos (codv, monto, fecha_pago) VALUES(".$codv.", ".$monto.", '".$fecha."')");

$sql = $conexion->query("SELECT SUM(monto) as monto FROM pagos WHERE codv = ".$codv);
$monto = $sql->fetch_array(MYSQLI_ASSOC);

$sql2 = $conexion->query("SELECT total FROM ventas WHERE codv = ".$codv);
$total = $sql2->fetch_array(MYSQLI_ASSOC);

if ((float)$monto <= (float)$total) {
	$conexion->query("UPDATE ventas SET credito = 2 WHERE codv = ".$codv);
}

echo $result;
?>