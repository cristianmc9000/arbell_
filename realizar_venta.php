<?php

require('recursos/conexion.php');
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
  color: black;
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
.fijo{
  position: fixed !important;
  right: 10px;
  bottom: 30%;
  max-width: 200px;

  z-index: 10 !important;
  width: 230px;

}
.fijo:hover{
  background: #ffffff;

  max-width: 230px;
  bottom: 29%;
}

</style>

</head>
<body>

<span class="fuente"><h4>Código:123 <br> Lider/Experta: Rocio Torrejon</h4></span>
<br><br>
<div class="row">
  <div class="col s3">
    <input placeholder="Buscar producto" id="first_name" type="text" class="validate">
  </div>
  <div class="col s2"><a class="waves-effect waves-light btn">Agregar</a>
</div>
</div>

<!-- TABLA -->
<div class="col s10">
<table id="tabla1" name="tabla1" class="highlight">
  <thead>
    <tr>
        
        <th data-field="codigo">Código<br>(Producto)</th>
        <th data-field="linea">Linea</th>
        <th data-field="descripcion">Descripción</th>
        <th data-field="stock">Stock</th>
        <th data-field="cantidad">Cantidad</th>
        <th data-field="pupesos">P.U.<br>Pesos</th>
        <th data-field="pubob">P.U.<br>Bolivianos</th>
        <th data-field="psd">PSD</th>
        <th data-field="subtotal">Subtotal</th>
      
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
        <td>7008</td>
        <td>ESPECIAL NAVIDAD</td>
        <td>Fragancia femenina Diva deo 150ml</td>
        <td>50</td>
        <td><input type="number" value="1"></td>
        <td>1000 $</td>
        <td>75 Bs.</td>
        <td>30 Bs.</td>
        <td>300 Bs.</td>
      </tr>



    </tbody>
</table>
</div>


<!-- Modal Trigger -->
<div class="fijo" id="imprimir" >
  <a id="modal_trigger_1" onclick="realizarVenta();" href="#modal1"  style="color: red;">
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover3.playclip();">
      <img src="img/shopping_cart2.png" >
    </div>
    <div class="card-action">
      REALIZAR VENTA
    </div>
  </div>
  </a>
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
  $("#cuerpo").load("ventas.php");
}


</script>
</body>
</html>
