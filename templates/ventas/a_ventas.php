<?php

require('../../recursos/conexion.php');
session_start();
$suc = $_SESSION['sucursal'];


$Sql = "SELECT id, codigo, modelo, precio_ref, cantidad FROM productos where estado=1 and sucursal=".$suc.""; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'modelo'=>$arr['modelo'], 'codigo'=>$arr['codigo'], 'precio_ref'=>$arr['precio_ref'], 'cantidad'=>$arr['cantidad']); 

    } 

 
$Sql2 = "SELECT * FROM clientes where estado=1"; 
$Busq2 = $conexion->query($Sql2); 
while($arr = $Busq2->fetch_array()) 
    { 
        $fila2[] = array('id'=>$arr['id'], 'ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos']); 

    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>VENDER PRODUCTOS</title>

<style>
.fuente{
  font-family: 'Segoe UI light';
  color: red;
}

@media only screen and (max-width: 767px) {

/* NO MOSTRAR ELEMENTOS MENORES A ESTA RESOLUCION*/

}

table.highlight > tbody > tr:hover {
  background-color: #a0aaf0 !important;
}
#modal1{
  font-size: 13px;
}
#tabla1{
  border-collapse: separate;
  border-radius: 5px;
  border-spacing: 1px;
  border: solid;
  border-color: #1f1f1f;
}


</style>

</head>
<body>

<span class="fuente"><h3>Ventas</h3></span>


<!-- TABLA -->
<div class="col s10">
<table id="tabla1" name="tabla1" class="highlight">
  <thead>
    <tr>
        
        <th data-field="id">Código</th>
        <th data-field="id">Nombre</th>
        <th data-field="name">Apellidos</th>
        <th data-field="C.I.">C.I.</th>
        <th data-field="telefono">Teléfono</th>
        <th data-field="rango">Rango</th>
        <th>Seleccionar</th>

    </tr>
  </thead>

 <!-- <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr <?php if(($valor['cantidad']) =='0') echo 'style="background-color: #FA5858"'; if(($valor['cantidad'])<71){ echo 'style="background-color: #F4FA58"';}?>>
        
        <td><?php echo $valor["codigo"] ?></td>
        <td><?php echo $valor["modelo"] ?></td>
        <td><?php echo $valor["cantidad"] ?></td> 
        <td><?php echo $valor["precio_ref"]." Bs." ?></td>
        

        <td><center><input type="checkbox" id="<?php echo $valor['codigo'] ?>" onclick="contarSeleccionados('<?php echo $valor['id']?>')" ><label for="<?php echo $valor['codigo']?>"/></center></td>
        
      </tr>
    <?php } ?>  

    

  </tbody>-->

    <tbody>
      <tr>
        <td>123</td>
        <td>Rocio</td>
        <td>Torrejon</td>
        <td>7210040</td>
        <td>77198751</td>
        <td>Experta</td>
        <td><a href="#!" onclick="ventas()"><i class="material-icons">forward</i></a></td>
      </tr>

      <tr>
        <td>124</td>
        <td>Carmen</td>
        <td>Guzman</td>
        <td>7210992</td>
        <td>76158245</td>
        <td>Lider</td>
        <td><a href="#!" onclick="ventas()"><i class="material-icons">forward</i></a></td>
      </tr>
      <tr>
        <td>125</td>
        <td>Alejandra</td>
        <td>Santos</td>
        <td>4458875</td>
        <td>77174288</td>
        <td>Experta</td>
        <td><a href="#!" onclick="ventas()"><i class="material-icons">forward</i></a></td>
      </tr>
      <tr>
        <td>127</td>
        <td>Gabriela</td>
        <td>Flores</td>
        <td>5412558</td>
        <td>62158745</td>
        <td>Lider</td>
        <td><a href="#!" onclick="ventas()"><i class="material-icons">forward</i></a></td>
      </tr>
    </tbody>
</table>
</div>







<!--MODAL PARA RECIBIR MENSAJES DESDE PHP-->  
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div id="mensaje" class="modal-content">

    </div>
    <div class="modal-footer row">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>




<script>
var mensaje = $("#mensaje");
mensaje.hide();

$(document).ready(function() {

    $('#tabla1').dataTable();
    $('#tabla2').dataTable( {
      bInfo: false,
      "lengthMenu": [[5, 10], [5, 10]]
    });

    $('#modal_trigger_1').leanModal();
    $('select').material_select();
});
function ventas (){
  $("#cuerpo").load("templates/ventas/realizar_venta.php");
}


</script>
</body>
</html>
