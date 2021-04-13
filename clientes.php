<?php
require('recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM clientes WHERE estado=1"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'telefono'=>$arr['telefono']); 
        array_push($_SESSION['filas'],$fila); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>Clientes</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }


  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
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
<div class="row">
<div class="col s11">

<span class="fuente"><h3>Clientes 
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a></h3> 
</span>

<!-- TABLA -->

  <table id="tabla1" class="highlight">

        <thead>

          <tr>
              <th data-field="id">CI</th>
              <th data-field="name">Nombre</th>
              <th data-field="apellidos">Apellidos</th>
              <th data-field="telefono">Teléfono</th>
              <th data-field="price">Modificar</th>
              <th data-field="price">Borrar</th>
              <!--<th data-field="price">Ver Cliente</th>-->
          </tr>
        </thead>

        <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
          <tr>
            <td><?php echo $valor["ci"] ?></td>
            <td><?php echo $valor["nombre"] ?></td>
            <td><?php echo $valor["apellidos"] ?></td>
            <td><?php echo $valor["telefono"] ?></td>
            <td><a href="#!" onclick="mod_cliente('<?php echo $valor['ci'] ?>','<?php echo $valor['nombre'] ?>','<?php echo $valor['apellidos'] ?>', '<?php echo $valor['telefono'] ?>', '<?php echo $valor['id'] ?>');"><i class="material-icons">build</i></a></td>
            <td><a href="#!" onclick="borrar_cliente('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a></td>
            <!--<td><a href="#"><i class="material-icons">search</i></a></td>-->
          </tr>
    <?php } ?>  



        </tbody>
    </table>

<!--MODAL AGREGAR CLIENTE-->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Agregar cliente</h4>  
    <div class="row">
      <form class="col s12" id="agregar_cliente">
          <div class="row">
            <div class="input-field col s6">
              <input name="ci" type="number" class="validate">
              <label for="ci">CI: (OPCIONAL)</label>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s6">
              <input name="nombre" type="text" class="validate" required>
              <label for="nombre">Nombre: </label>
            </div>
            <div class="input-field col s6">
              <input name="apellidos" type="text" class="validate" required>
              <label for="apellidos">Apellidos:</label>
            </div>
          </div>
          <div class="row">
          <div class="input-field col s6">
            <input name="telefono" type="number">
            <label for="telefono">Teléfono (OPCIONAL): </label>
          </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<!--MODAL MODIFICAR CLIENTE-->
<div class="row">
<div id="modal3" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Modificar cliente</h4>  
    <div class="row">
      <form class="col s12" id="modificar_cliente">
          <div class="row">
            <div class="input-field col s6" id="ci">
              <input name="ci"  type="number" class="validate">
              <label for="ci">CI: (OPCIONAL)</label>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s6" id="nombre">
              <input name="nombre"  type="text" class="validate" required>
              <label for="nombre">Nombre: </label>
            </div>
            <div class="input-field col s6" id="apellidos">
              <input name="apellidos"  type="text" class="validate" required>
              <label for="apellidos">Apellidos:</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6" id="telefono">
              <input name="telefono"  type="number">
              <label for="telefono">Teléfono (OPCIONAL): </label>
            </div>

            <div class="input-field col s6" id="datos_anteriores">

            </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal4" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar cliente</b></h4>  
    <p>¿Esta seguro que desea eliminar a este cliente?</p>
    <div class="row">
      <form class="col s12" id="borrar_cliente">
          <div class="row">
            <div class="input-field col s6" id="datos_borrar">
              
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
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
$(document).ready(function() {
    $('#tabla1').dataTable();
    $('#modal').leanModal();
});
var mensaje = $("#mensaje");
mensaje.hide();

function mod_cliente(ci, nombre, apellidos, telefono, id){
  document.getElementById("ci").innerHTML ='<input name="ci" type="number" class="validate" value="'+ci+'"><label for="ci" class="active">CI: (OPCIONAL)</label>';
  document.getElementById("nombre").innerHTML ='<input name="nombre" type="text" class="validate" value="'+nombre+'"><label for="nombre" class="active">Nombres: </label>';
  document.getElementById("apellidos").innerHTML ='<input name="apellidos" type="text" class="validate" value="'+apellidos+'"><label for="apellidos" class="active">Apellidos: </label>';
  document.getElementById("telefono").innerHTML ='<input name="telefono" type="number" class="validate" value="'+telefono+'"><label for="telefono" class="active">Teléfono: </label>';
  document.getElementById("datos_anteriores").innerHTML ='<input name="nombre_ant" type="text" class="validate" value="'+nombre+'" hidden><input name="apellidos_ant" type="text" class="validate" value="'+apellidos+'" hidden><input type="text" name="id" value="'+id+'" hidden/><input type="text" name="ci_ant" value="'+ci+'" hidden/>';
  $('#modal3').openModal();
}
$("#modificar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_cliente"));
    $.ajax({
      url: "recursos/modcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("clientes.php");
      }
    });
});

function borrar_cliente(id){

  document.getElementById("datos_borrar").innerHTML ='<input type="text" name="id" value="'+id+'" hidden/>';
  $('#modal4').openModal();
}
$("#borrar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_cliente"));
    $.ajax({
      url: "recursos/borrarcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("clientes.php");      }
    });
});

$("#agregar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_cliente"));
    $.ajax({
      url: "recursos/clientes.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        mensaje.show();
      }
    });
});
</script>

</div>
</div>
</body>
</html>