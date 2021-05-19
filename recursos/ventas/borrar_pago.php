<?php 
require("../conexion.php");
$id=$_GET["id"];

$result = $conexion->query("UPDATE pagos SET estado = 0 WHERE id = ".$id);

echo $result;

?>