<?php 
	require("../sesiones.php");
	require("../conexion.php");
	session_start();
	$ca = $_SESSION['ca'];
	$per = $_SESSION['periodox'];

	// die($ca."---".$per);

	$total = $_GET['total'];
	$a = json_decode($_GET['a']);
	$cred = $_GET['cred'];

	$result = $conexion->query("INSERT INTO pedidos (ca, total, descuento, valor_peso, credito, periodo) VALUES(".$ca.", ".$total.", 30, 0.05, ".$cred.", ".$per.")");

	$lastid = mysqli_insert_id($conexion);

	if($cred == "true"){
		$cred = 1;
	}else{
		$cred = 0;
	}
	$dato = "";

				// cp, np, cantp, pp, pub, pup
	foreach($a as $x){
		// $dato = $dato."--".$x[0];
		$result = $conexion->query("INSERT INTO `detalle_pedido`(`codped`, `codpro`, `cant`, `pubs`, `pubs_cd`) VALUES (".$lastid.",'".$x[0]."',".$x[2].",'".$x[4]."','".((int)($x[4]))*0.3."')");
	}

	
	echo $result;
?>