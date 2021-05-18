<?php
require("../conexion.php"); 
$codv=$_GET["codv"];
$result= $conexion->query("SELECT a.codv, a.codp, (SELECT c.nombre FROM lineas c WHERE b.linea = c.codli) as linea, b.descripcion, a.cantidad, a.pubs, a.pubs_cd FROM detalle_venta a, productos b WHERE a.codp = b.id AND a.codv = ".$codv);

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}

// echo $rows[0]['codv']; //reading a single element of array
echo json_encode($rows);


?>