<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	$result = $conexion->query("SELECT a.codpro as id, a.cant as cantidad,(SELECT d.cantidad FROM  invcant d WHERE d.codp = a.codpro) AS stock, b.descripcion FROM detalle_pedido a, productos b WHERE a.estado = 1 AND a.codpro = b.id AND a.codped = ".$id);
	$res = $result->fetch_all(MYSQLI_ASSOC);

	$item = array();
	foreach ($res as $key => $value) {
		if ($res[$key]['cantidad'] > $res[$key]['stock']) {
			$item = array("codpro" => $res[$key]['id'], "desc" => $res[$key]['descripcion'], "stock" => $res[$key]['stock']);
			die(json_encode($item));
		}
	}

	echo '1';

?>