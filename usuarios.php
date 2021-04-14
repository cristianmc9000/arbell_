<?php
require('recursos/conexion.php');

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
          <th>Dirección</th>
          <th>Rol</th>
          <th>Modificar</th>
          <th>Borrar</th>
          <th>Ver Usuario</th>
      </tr>
    </thead>

    <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr>
        <td><?php echo $valor["ci"] ?></td>
        <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
        <td><?php echo $valor["telefono"] ?></td>
        <td>B\ Las Panosas\...</td>
        <td>Administrador</td>
        <td><a href="#"><i class="material-icons">build</i></a></td>
        <td><a href="#"><i class="material-icons">delete</i></a></td>
        <td><a href="#"><i class="material-icons">search</i></a></td>
      </tr>
    <?php } ?>	
    </tbody>
  </table>


<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Agregar usuario</h4>  
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s6">
            <input id="ci" type="text" class="validate">
            <label for="ci">Cédula de Identidad:</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="nombre" type="text" class="validate">
            <label for="nombre">Nombre:</label>
          </div>
          <div class="input-field col s6">
            <input id="apellidos" type="text" class="validate">
            <label for="apellidos">Apellidos:</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="telefono" type="number" class="validate">
            <label for="telefono">Teléfono:</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="password" class="validate" type="password">
            <label for="password">Contraseña:</label>
          </div>
          <div class="input-field col s6">
            <input id="password1" class="validate" type="password">
            <label for="password1">Repita la contraseña:</label>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
  </div>
</div>
</div>

<!--
<div class="fijo" id="imprimir" >
  <a href="#" style="color: red;">
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover3.playclip();">
      <img src="img/print.png" >
    </div>
    <div class="card-action">
      IMPRIMIR TABLA
    </div>
  </div>
  </a>
</div>-->

<script>
$(document).ready(function() {
    $('#tabla1').dataTable();
    $('#modal').leanModal();
});

</script>


</body>
</html>