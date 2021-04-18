<?php
require('../../recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM usuarios"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'telefono'=>$arr['telefono']); 
        array_push($_SESSION['filas'],$fila); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

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
  .fijo{
    position: fixed !important;
    right: 10px;
    bottom: 5%;
    max-width: 230px;
    z-index: 10 !important;
    width: 230px;

  }
  .fijo:hover{
    background: #ffffff;
    margin-right:40px;
  }
</style>

</head>
<body>

<span class="fuente"><h3>Usuarios	
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a></h3> 
</span>

  <!-- TABLA -->

  <table id="tabla1" class="highlight">
    <thead>
      <tr>
          <th>CI</th>
          <th>Nombres y apellidos</th>
          <th>Telefono</th>
          <th>Rol</th>
          <th>Modificar</th>
          <th>Borrar</th>
      </tr>
    </thead>

    <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr>
        <td><?php echo $valor["ci"] ?></td>
        <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
        <td><?php echo $valor["telefono"] ?></td>
        <td>Administrador</td>
        <td><a href="#"><i class="material-icons">build</i></a></td>
        <td><a href="#"><i class="material-icons">delete</i></a></td>        
      </tr>
    <?php } ?>	
    </tbody>
  </table>



<!-- MODAL DATOS -->
<div class="row">
  <div id="modal1" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h4>Agregar usuario</h4>
        <div class="row">
          <form id="agregar_usuario" class="col s12">
            <div class="row">
              <div class="input-field col s6">
              <input name="ci" type="text" class="validate">
              <label for="ci">Cédula de Identidad:</label>
              </div>
            </div>
              <div class="row">
                <div class="input-field col s6">
                  <input name="nombre" type="text" class="validate">
                  <label for="nombre">Nombre:</label>
              </div>
              
              <div class="input-field col s6">
                  <input name="apellidos" type="text" class="validate">
                  <label for="apellidos">Apellidos:</label>
                </div>
              </div>
              
              <div class="row">
                <div class="input-field col s6">
                  <input name="telefono" type="tel" class="validate">
                  <label for="telefono">Teléfono:</label>
                </div>
              </div>
              
              <div class="row">
                <div class="input-field col s6">
                  <input name="password" class="validate" type="password">
                  <label for="password">Contraseña:</label>
              </div>
              
              <div class="input-field col s6">
                  <input name="password1" class="validate" type="password">
                  <label for="password1">Repita la contraseña:</label>
              </div>
            </div>

            <div class="modal-footer">
            <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
              </div>

          </form>
        </div>
    </div>
              
  </div>
</div>


<div id="mensaje"></div>


<!-- -----------------CRUD DE USUARIOS------------------------ -->
<script>
$(document).ready(function() {
    $('#tabla1').dataTable();
    $('#modal').leanModal();
});
var mensaje = $("#mensaje");
mensaje.hide();


/* agregar usuario */
$("#agregar_usuario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_usuario"));
    $.ajax({
      url: "recursos/usuarios/agregar_usuario.php",
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

        $("#cuerpo").load("templates/usuarios/a_usuarios.php");

      }
    });
});

/* modificar usuario */
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

/* borrar usuario */
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


</script>


</body>
</html>