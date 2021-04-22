<?php
//fetch_data.php

include('../conexion.php');
if(isset($_GET["term"]))
{
    $result = $conn->query("SELECT * FROM productos WHERE id LIKE '%".$_GET["term"]."%' ORDER BY id ASC");
    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
       $temp_array = array();
       $temp_array['value'] = $row['nombre'];
       $temp_array['label'] = '<img src="images/fotos_prod/'.$row['foto'].'" width="70" />   '.$row['nombre'].'';
       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }
 echo json_encode($output);
}
?>