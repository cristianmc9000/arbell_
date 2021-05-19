<?php 
require("../conexion.php");
date_default_timezone_set("America/La_Paz");
$codv = $_GET['codv'];
$monto = $_GET['monto'];
$fecha = date("Y-m-d h:i:s");

$result = $conexion->query("INSERT INTO pagos (codv, monto, fecha_pago) VALUES(".$codv.", ".$monto.", '".$fecha."')");

echo $result;
?>