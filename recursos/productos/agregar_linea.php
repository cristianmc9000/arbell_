<?php
require('../conexion.php');
require('../sesiones.php');
session_start();
$periodo = $_SESSION["periodo"];
$nombre = $_POST["linea_"];
// UPDATE productos a SET foto = CONCAT("images/fotos_prod/",id,".jpg") PARA COPIAR DATOS DE UNA CELDA A OTRA concatenando
$sql = $conexion->query("INSERT INTO  lineas (nombre, periodo) VALUES ('".$nombre."', ".$periodo.")");

echo "?mes=".$periodo;


?>