<?php 
	require("sesiones.php");
	require("../conexion.php");
	session_start();
	$ca = $_SESSION['ca'];
	$per = $_SESSION['periodox'];

	$result = $conexion->query("SELECT * FROM pedidos WHERE ca = '".$ca."' AND estado = 1");
	$result = mysqli_num_rows($result);
	if ($result > 0) {
		die('2');
	}
	$total = $_GET['total'];
	$total_cd = $_GET['total_cd'];
	$a = json_decode($_GET['a']);
	$cred = $_GET['cred'];

	$desc = ((float)$_SESSION['desc'])*100;
	$result = $conexion->query("INSERT INTO pedidos (ca, total, total_cd, descuento, valor_peso, credito, periodo) VALUES('".$ca."', ".$total.", ".$total_cd.", ".$desc.", 0.05, ".$cred.", ".$per.")");

	$lastid = mysqli_insert_id($conexion);

	if($cred == "true"){
		$cred = 1;
	}else{
		$cred = 0;
	}
	$dato = "";

				// cp, np, cantp, pp, pub, pup, codli
	$pubs_cd = 0;
	foreach($a as $x){
		// $dato = $dato."--".$x[0];
		if ($x[6] == 16 || ($x[6] >= 32 && $x[6] <= 37)) {
			$pubs_cd = $x[4];
		}else{
			$pubs_cd = (((float)($x[4]))-(((float)($x[4]))*((float)$_SESSION['desc'])));
		}

		$result = $conexion->query("INSERT INTO `detalle_pedido`(`codped`, `codpro`, `cant`, `pubs`, `pubs_cd`) VALUES (".$lastid.",'".$x[0]."',".$x[2].",'".$x[4]."','".$pubs_cd."')");
	}

	
	echo $result;
?>