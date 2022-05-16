<?php 
require("../conexion.php");

$id = $_GET['id'];

$result = $conexion->query("SELECT a.codpro as id, a.cant as cantidad, a.pubs, a.pubs_cd as pubs_desc, c.codli, c.nombre as linea, b.descripcion, a.codped FROM detalle_pedido a, productos b, lineas c WHERE b.linea = c.codli AND a.codpro = b.id AND a.estado = 1 AND a.codped = ".$id);


$res = $result->fetch_all(MYSQLI_ASSOC);

if ($result) {
	if (isset($_GET['x'])) {
		$status = $conexion->query("UPDATE `pedidos` SET `estado`='2' WHERE id = ".$id);
	}
	echo json_encode($res);
}else{
	echo mysqli_error($conexion);
}

?>

