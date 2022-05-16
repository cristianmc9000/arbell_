<?php 
	require('../conexion.php');
	$id = $_GET['id'];
	$result = $conexion->query("SELECT a.monto, a.fecha_pago FROM pagos a WHERE codv = (SELECT b.codv FROM ventas b WHERE b.codp = ".$id.")");
	$result = $result->fetch_all(MYSQLI_ASSOC);
	echo json_encode($result);
?>