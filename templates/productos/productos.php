<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');

$per = $_GET["mes"];
$anio = $_GET["anio"];

session_start();
$_SESSION['periodo'] = $per;
$_SESSION['anio'] = $anio;

$Sql = "SELECT id, foto, linea, descripcion, pupesos, pubs, cantidad, fechav FROM productos WHERE estado = 1 and fechareg LIKE '".$anio."-%-%' and periodo = ".$per; 
$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
  while($arr = $Busq->fetch_array()){ 

        $fila[] = array('id'=>$arr['id'], 'foto'=>$arr['foto'], 'linea'=>$arr['linea'], 'descripcion'=>$arr['descripcion'], 'pupesos'=>$arr['pupesos'], 'pubs'=>$arr['pubs'], 'cantidad'=>$arr['cantidad'], 'fechav'=>$arr['fechav']); 

  }
}else{
        $fila[] = array('id'=>'--','foto'=>'--','linea'=>'--','descripcion'=>'--','pupesos'=>'--','pubs'=>'--','cantidad'=>'--','fechav'=>'--');
}
  
$Sql2 = "SELECT codli, nombre FROM lineas WHERE estado = 1";
$Busq2 = $conexion->query($Sql2);
if((mysqli_num_rows($Busq2))>0){
  while($arr2 = $Busq2->fetch_array()){ 

        $fila2[] = array('codli'=>$arr2['codli'], 'nombre'=>$arr2['nombre']); 

  }
}


?>


<html>
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    color: red;

  }
  .fuente_azul{
    color: black;
  }

  </style>
</head>
<body>
<div class="row">
<div class="col s11">

<div class="col s6">
  <span class="fuente">
    <h3>
      Productos
      <!-- Modal Trigger -->
      <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a>
    </h3>
  </span>
</div>

<!-- TABLA -->
<table id="tabla1" class="highlight">
  <thead>
    <tr>
        <th>Ver</th>
        <th>Código<br>(Producto)</th>
        <th>Linea</th>
        <th>Descripción</th>
        <th>P.U.<br>(pesos arg.)</th>
        <th>P.U.<br>(Bs.)</th>
        <th>Cantidad</th>
        <th>Fecha de venc.</th>

        <th>Modificar</th>
        <th>Borrar</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach($fila as $a  => $valor){ ?>
    <tr>

      <td><?php echo $valor["id"] ?></td>
      <td><img src="<?php echo $valor["foto"]?>" alt=""></td>
      <td><?php echo $valor["linea"]?></td>
      <td><?php echo $valor["descripcion"]?></td>
      <td><?php echo $valor["pupesos"]?>$</td>
      <td><?php echo $valor["pubs"] ?>Bs.</td>
      <td><?php echo $valor["cantidad"] ?></td>
      <td><?php echo $valor["fechav"] ?></td>

      <td>
        <!-- <a href="#!" onclick="mod_registro('<?php echo $valor['fecha']?>','<?php echo $valor['nombrec'] ?>','<?php echo $valor['apellidoc'] ?>','<?php echo $valor['id']?>','<?php echo $valor['total']?>')"><i class="material-icons">build</i></a> -->
        <a href="#!"><i class="material-icons">build</i></a>
      </td>
      <td>
        <a href="#!" onclick="borrar_registro(<?php echo $valor['id'] ?>);"><i class="material-icons">delete</i></a>
      </td>

    </tr>
  <?php } ?>  
  </tbody>
</table>


<!--MODAL AGREGAR PRODUCTO-->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Nuevo producto</h4>  
    <div class="row">
      <form class="col s12" id="agregar_producto">
          <div class="row">
            <div class="input-field file-field col s6">
              <div class="btn">
                <span>Foto</span>
                <input type="file">
              </div>
              <div class="file-path-wrapper">
                <input id="foto" class="file-path validate" type="text">
              </div>
              <input id="pic" name="fotoz" type="text" value="" hidden>
            </div>
            <div class="input-field col s6">
              <input name="codigo" type="text" required>
              <label for="codigo">Código:</label>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s6">
              <select id = "linea" name = "linea" class="browser-default">
                <option value="" disabled selected>Seleccionar linea</option>
                <?php foreach($fila2 as $a  => $valor){ ?>
                  <option value="<?php echo $valor["codli"] ?>"><?php echo $valor["nombre"] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="input-field col s6">
              <input name="descripcion" type="text" required>
              <label for="descripcion">Descripción:</label>
            </div>
          </div>
          <div class="row">
            <div  class="input-field col s6">
              <input name="pupesos" id="pupesos" type="text" onkeypress="convertir()" required>
              <label for="pupesos">P.U. (pesos arg.):</label>
            </div>
            <div class="input-field col s6">
              <input name="pubs" id="pubs" type="text" required>
              <label class="active" for="pubs">P.U. (Bs.):</label>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s6">
              <input name="cantidad" type="number" required>
              <label for="cantidad">Cantidad: </label>
            </div>
            <div class="input-field col s6">
                <input name = "fechav" type="date">
                <label class="active" for="first_name">Fecha de vencimiento</label>
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


<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
    <div id="mensaje" class="modal-content">

<script>

var mensaje = $("#mensaje");
$(document).ready(function() {
    $('#tabla1').dataTable( {
        "order": [[ 0, "desc" ]]
    } );
    $('#modal').leanModal();

});

$("#agregar_producto").on("submit", function(e){
    e.preventDefault();
    $("#pic").val($("#foto").val());
    var val = new FormData(document.getElementById("agregar_producto"));
    $.ajax({
      url: "recursos/productos/agregar_producto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        console.log("volviendo");
        mensaje.html(echo);
        mensaje.show();
        console.log(echo);
        $("#modal1").closeModal(); 
        Materialize.toast("PRODUCTO AGREGADO." , 4000);

        $("#cuerpo").load("templates/productos/productos.php"+echo);
      }
    });
});

function convertir() {

  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
 
  $("#pubs").val(bs.toFixed(2));
}

$("#pupesos").on("keydown input", function(){
  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pubs").val(bs.toFixed(2));
})

</script>

</div>
</div>
</body>
</html>