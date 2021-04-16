<?php 

$conexion = mysqli_connect('localhost','root','','base_arbell');

if($conexion === false) { 
echo 'Ha habido un error <br>'.mysqli_connect_error(); 
}
?>