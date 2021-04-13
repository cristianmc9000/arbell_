<?php
//Conectamos a la base de datos
require('conexion.php');

//Obtenemos los datos del formulario de registro
session_start();
$sucursal = $_SESSION['sucursal'];

$idPOST = $_POST["eid"];
$nombrePOST = $_POST["enombre"];
$apellidosPOST = $_POST["eapellidos"];
$ciPOST = $_POST["eci"];
$totalPOST =$_POST["etotal"];
$cantidadPOST =$_POST["ecantidad"];



if($nombrePOST == "" || $apellidosPOST == "" || $totalPOST == "0"){
	die('rellenar_campos');
}
//verificar cantidad
for ($v=0; $v < $cantidadPOST; $v++) { 
	//Consulta para obtener la cantidad del producto desde la base de datos
	$consultaObtenerCantidadCorrecta = 'SELECT cantidad FROM productos where id= '.$_POST[$v].' and estado=1;';
	$resultadoConsultaOCC = mysqli_query($conexion, $consultaObtenerCantidadCorrecta) or die(mysql_error());
	$datosConsultaOCC = mysqli_fetch_array($resultadoConsultaOCC);
	//Cantidad final despues de restar la cantidad vendida
	$cantFinal = $datosConsultaOCC['cantidad'] - $_POST[$v.'c'];
	if($cantFinal < 0){
		die('<script>Materialize.toast("Stock de producto agotado, revise las cantidades.", 6000);</script>stock_productos');
	}
}


//verificar si el cliente existe
if ($idPOST == "control") {
		$consultaVerifClient = 'SELECT id FROM clientes WHERE nombre = "'.$nombrePOST.'" AND apellidos = "'.$apellidosPOST.'" ORDER BY id DESC LIMIT 1';
		$resultadoVC = mysqli_query($conexion, $consultaVerifClient) or die(mysql_error());
		$datosVC = mysqli_fetch_array($resultadoVC);
		if ($datosVC != "" ) {
			$idPOST = $datosVC['id'];
		}else{
			$consultaAgregarCliente = 'INSERT INTO `clientes`(`CI`, `nombre`, `apellidos`) VALUES ("'.$ciPOST.'","'.$nombrePOST.'","'.$apellidosPOST.'")';
			if(!(mysqli_query($conexion, $consultaAgregarCliente) or die(mysql_error()))){
				die('<script>$("#modal2").openModal(); $("#modal1").closeModal(); </script> ERROR #101 ');
			}
			$consObtenerID = 'SELECT * FROM clientes ORDER BY id DESC LIMIT 1';
			$resultadoConsOID = mysqli_query($conexion, $consObtenerID) or die(mysql_error());
			$datosConsOID = mysqli_fetch_array($resultadoConsOID);
			$idPOST = $datosConsOID['id'];
		}
}

$consultaInsertarCI = 'UPDATE clientes SET CI="'.$ciPOST.'" WHERE id='.$idPOST.'';
$resultadoConsultaOCIC = mysqli_query($conexion, $consultaInsertarCI) or die(mysql_error());

$consultaInsertarVenta = 'INSERT INTO venta (id_cli, ci_cli, nombre_cli, apellidos_cli, total, sucursal) VALUES("'.$idPOST.'", "'.$ciPOST.'", "'.$nombrePOST.'", "'.$apellidosPOST.'", "'.$totalPOST.'", "'.$sucursal.'")';	
	if(!(mysqli_query($conexion, $consultaInsertarVenta) or die(mysql_error()))){
		die('<script>$("#modal2").openModal(); $("#modal1").closeModal(); </script> ERROR #101 ');
	}
	$consultaUltimoId = "SELECT * FROM venta ORDER BY id DESC LIMIT 1";
	$resultadoConsultaUI = mysqli_query($conexion, $consultaUltimoId) or die(mysql_error());
	$datosConsultaUI = mysqli_fetch_array($resultadoConsultaUI);
	$ultimoid = $datosConsultaUI['id'];

for ($i = 0; $i < $cantidadPOST; $i++) {
		$consultaAgregarDetalle = "INSERT INTO `detalle` (id_venta, idpro, cantidad) VALUES ('".$ultimoid."', '".$_POST[$i]."', '".$_POST[$i.'c']."')";
		if((mysqli_query($conexion, $consultaAgregarDetalle) or die(mysql_error())) && ($i == ($cantidadPOST-1) )) {

			for ($v=0; $v < $cantidadPOST; $v++) { 
				//Consulta para obtener la cantidad del producto desde la base de datos
				$consultaObtenerCantidadCorrecta = 'SELECT cantidad FROM productos where id= '.$_POST[$v].' and estado=1;';
				$resultadoConsultaOCC = mysqli_query($conexion, $consultaObtenerCantidadCorrecta) or die(mysql_error());
				$datosConsultaOCC = mysqli_fetch_array($resultadoConsultaOCC);
				//Cantidad final despues de restar la cantidad vendida
				$cantFinal = $datosConsultaOCC['cantidad'] - $_POST[$v.'c'];
				if($cantFinal < 0){
					die('<script>Materialize.toast("Stock de producto agotado, revise las cantidades.", 6000);</script>stock_productos');
				}

				//CONSULTA CORREGIR CANTIDAD FINAL
				$consultaCorregirCantidad ='UPDATE productos SET cantidad='.$cantFinal.' WHERE id='.$_POST[$v].'';
				mysqli_query($conexion, $consultaCorregirCantidad) or die(mysql_error());
			}		

			die('<script>hover4.playclip();  Materialize.toast("Venta realizada. <br> <b>TOTAL: '.$totalPOST.'</b>", 6000); $("#modal1").closeModal(); limpiar();</script>');
		} else if($i == ($cantidadPOST-1)){
			die('Error');
		};
	}
		


?>