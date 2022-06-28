<?php 
	session_start();
	require('../conexion.php');
	$ca = $_SESSION['ca'];
	// $ca = $_GET['ca'];
	$result = $conexion->query('SELECT a.ca, CONCAT(c.nombre," ",c.apellidos) as experta, a.codv, SUM(b.cantidad) as cant FROM ventas a, detalle_venta b, clientes c WHERE c.CA = a.ca AND a.estado = 1 AND b.estado = 1 AND a.codv = b.codv AND c.lider = "'.$ca.'" GROUP BY a.ca ORDER BY `cant` DESC ');
	$res = $result->fetch_all(MYSQLI_ASSOC);

	$result2 = $conexion->query('SELECT a.ca, SUM(a.total) as tot FROM ventas a, clientes b WHERE b.lider = "'.$ca.'" AND b.CA = a.ca AND a.estado = 1 GROUP BY a.ca ORDER BY `tot` DESC');
	$res2 = $result2->fetch_all(MYSQLI_ASSOC);

	foreach($res as $key => $valor){
		foreach($res2 as $valor2){
			if ($valor2['ca'] == $valor['ca']) {
				$res[$key]['total'] = $valor2['tot'];
			}
		}
	}

	if ($result && $result2) {
		echo json_encode($res);
	}else{
		echo mysqli_error($conexion);
	}
	


?>