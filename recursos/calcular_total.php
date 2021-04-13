<?php
//Conectamos a la base de datos
require('conexion.php');

//Obtenemos los datos del formulario de registro
session_start();
$sucursal = $_SESSION['sucursal'];
$fechaini = $_POST["fecha_ini"];
$fechafin = $_POST["fecha_fin"];

if ($fechafin == "") {
	$consulta = "SELECT SUM(a.total) as total, SUM(b.cantidad) as cantidad, COUNT(a.id) as ventas FROM venta a, detalle b WHERE a.id = b.id_venta and a.sucursal = '".$sucursal."' and a.fecha LIKE '".$fechaini."%'";
	$resultado = mysqli_query($conexion, $consulta) or die(mysql_error());
	$datos = mysqli_fetch_array($resultado);

	die('<h5><span>Ventas realizadas: <span style="color:red">'.$datos['ventas'].'</span></span><br><span>Productos vendidos: <span style="color:red">'.$datos['cantidad'].'</span></span><br><span>Total: <span style="color:red">'.round($datos['total'], 2).' Bs.</span></span></h5>');
}else{
	$consulta = "SELECT SUM(a.total) as total, SUM(b.cantidad) as cantidad, COUNT(a.id) as ventas FROM venta a, detalle b WHERE a.id = b.id_venta and a.sucursal = '".$sucursal."' and a.fecha >='".$fechaini."' AND a.fecha <= '".$fechafin."' ";
	$resultado = mysqli_query($conexion, $consulta) or die(mysql_error());
	$datos = mysqli_fetch_array($resultado);
	die('<h5><span>Ventas realizadas: <span style="color:red">'.$datos['ventas'].'</span></span><br><span>Productos vendidos: <span style="color:red">'.$datos['cantidad'].'</span></span><br><span>Total: <span style="color:red">'.round($datos['total'], 2).' Bs.</span></span></h5>');
}
?>