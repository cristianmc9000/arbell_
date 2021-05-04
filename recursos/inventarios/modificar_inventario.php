<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$id = $_POST["id"];
$pupesos = $_POST["pupesos"];
$pubs = $_POST["pubs"];
$cantidad = $_POST["cantidad"];
$fecha_v = $_POST["fechav"];
$cant_ant = $_POST["cant_ant"];
if($fecha_v == ""){
	$fecha_v = '0000-00-00';
}

$cant = $cantidad - $cant_ant;

// $year = $_SESSION['anio'];
$periodo = $_SESSION["periodo"];
	

	//consulta modificar inventario
	$consulta ="UPDATE inventario SET pupesos='".$pupesos."', pubs='".$pubs."', cantidad='".$cantidad."', fecha_venc='".$fecha_v."' WHERE id= '".$id."' ";
	mysqli_query($conexion, $consulta) or die(mysql_error()); 
		
	//consulta actualizar cantidad de inventario
	$sql = "UPDATE `invcant` SET cantidad = cantidad + (".$cant.") WHERE codp = (SELECT codp FROM inventario WHERE id = ".$id.") ";
		if (mysqli_query($conexion, $sql) or die(mysql_error())) {
			die('?mes='.$periodo);
		}else{
			die(mysql_error());
		}
		
?>

<!-- LA TABLA INVENTARIO NO DEBERIA TENER CANTIDADES INDIVIDUALES, PORQUE AL MOMENTO DE LA VENTA NO SE PUEDE ESCOGER CUAL VENDER POR LO TANTO NO SE SABE CUAL REDUCIR.... 
ENTONCES LA UNICA CANTIDAD QUE DEBE MANEJARSE ES LA DE LA TABLA 'invcant' 
SI QUEREMOS MANTENER LA CANTIDAD EN LA TABLA 'inventario' SERIA COMO CANTIDAD INICIAL ADQUIRIDA...-->
