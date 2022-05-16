<?php 
	require('../conexion.php');
	$id = $_GET['id'];
	$result = $conexion->query("SELECT a.codpro, a.cant, b.descripcion, a.pubs FROM detalle_pedido a, productos b WHERE a.codpro = b.id AND a.codped = ".$id);
	$result = $result->fetch_all(MYSQLI_ASSOC);
	echo json_encode($result);
?>