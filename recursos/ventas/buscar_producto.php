<?php
//fetch_data.php

include('../conexion.php');



if(isset($_GET["term"]))
{
    //modificar consulta para que salga nombre de la linea ...
  //llamar al ultimo precio de inventarios al maximo si es posible.......

    $result = $conexion->query("SELECT a.id, (SELECT max(d.pubs) FROM inventario d WHERE d.codp = a.id AND codp LIKE '%".$_GET["term"]."%') AS maxpubs,c.cantidad AS stock, a.linea, a.descripcion, a.foto, a.pupesos, a.pubs, b.nombre FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.linea = b.codli AND id LIKE '%".$_GET["term"]."%' ORDER BY id ASC");
    // $result = $conexion->query("SELECT a.id, c.cantidad AS stock, a.linea, a.descripcion, a.foto, a.pupesos, a.pubs, b.nombre FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.linea = b.codli AND id LIKE '%".$_GET["term"]."%' ORDER BY id ASC");
    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
        $temp_array = array();
        $temp_array['id'] = $row['id'];
        $temp_array['stock'] = $row['stock'];
        $temp_array['linea'] = $row['nombre'];
        $temp_array['value'] = $row['descripcion'];
        $temp_array['label'] = '<img class="zoom" src="'.$row['foto'].'" width="85" />   '.$row['descripcion'].'';
        $temp_array['pupesos'] = $row['pupesos'];
        $temp_array['pubs'] = $row['maxpubs'];
       
       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}

?>