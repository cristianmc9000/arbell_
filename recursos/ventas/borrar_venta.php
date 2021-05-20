<?php 
require("../conexion.php");
$codv=$_GET["codv"];

$conexion->query("UPDATE ventas SET estado = 0 WHERE codv = ".$codv);
$result = $conexion->query("SELECT codp, cantidad FROM detalle_venta WHERE estado=1 AND codv = ".$codv);
$conexion->query("UPDATE detalle_venta SET estado = 0 WHERE codv = ".$codv);


while($arr = $result->fetch_array()){
    $r = $conexion->query("UPDATE inventario a SET a.estado=1, a.cantidad = a.cantidad + ".$arr['cantidad']." WHERE a.codp = '".$arr['codp']."' AND a.id = (SELECT MAX(id) FROM (SELECT * FROM inventario WHERE codp = '".$arr['codp']."') AS maxid )");
}

echo $r;

?>