<?php
require("../conexion.php"); 
$codv=$_GET["codv"];
$result= $conexion->query("SELECT a.codp, b.linea, b.descripcion, a.cantidad, a.pubs_cd FROM ");
$row = $result->fetch_array(MYSQLI_ASSOC);

echo $row;


?>