<?php
//fetch_data.php

include('../conexion.php');



if(isset($_GET["term"]))
{
    //modificar consulta para que salga nombre de la linea ...
    $result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, a.pupesos, a.pubs, b.nombre FROM productos a, lineas b WHERE a.linea = b.codli AND id LIKE '%".$_GET["term"]."%' ORDER BY id ASC");
    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
       $temp_array = array();
       $temp_array['id'] = $row['id'];
       $temp_array['linea'] = $row['nombre'];
       $temp_array['value'] = $row['descripcion'];
       $temp_array['label'] = '<img class="zoom" src="'.$row['foto'].'" width="85" />   '.$row['descripcion'].'';
       $temp_array['pupesos'] = $row['pupesos'];
       $temp_array['pubs'] = $row['pubs'];
       
       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}

?>