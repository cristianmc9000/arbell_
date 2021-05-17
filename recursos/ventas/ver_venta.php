<?php
require("../conexion.php"); 
$codv=$_GET["codv"];
$result= $conexion->query("SELECT a.codv, a.codp, b.linea, b.descripcion, a.cantidad, a.pubs_cd FROM detalle_venta a, productos b WHERE a.codv = ".$codv);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo var_dump($row);


?>