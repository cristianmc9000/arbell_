<?php
//Comentario para ver en git
//aplicando cambios desde sublime

//PUEDES VER ESTO DOLZ
//SI VEO CHINO

require('recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT a.imei, b.modelo, a.descripcion FROM prodime a, productos b where a.id=b.id and a.estado=0 and a.estadov=0"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('modelo'=>$arr['modelo'], 'imei'=>$arr['imei'], 'descripcion'=>$arr['descripcion']); 
        array_push($_SESSION['filas'],$fila); 
    } 


?>

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

<span class="fuente"><h3>PRODUCTOS ELIMINADOS</h3></span>


<!-- TABLA -->
<table id="tabla1" name="tabla1" class="highlight">
  <thead>
    <tr>

        <th data-field="id">Modelo</th>
        <th data-field="name">IMEI</th>
        <th data-field="price">Descripción</th>
        <th data-field="price">Recuperar</th>
        <th data-field="price">Borrar permanente</th>

    </tr>
  </thead>

  <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr>
        <td><?php echo $valor["modelo"] ?></td>
        <td><?php echo $valor["imei"] ?></td>
        <td><?php echo $valor["descripcion"] ?></td>
        <td><a href="#!" onclick="borrar_producto('<?php echo $valor['modelo'] ?>', '<?php echo $valor['imei'] ?>');"><i class="material-icons">unarchive</i></a></td>
        <td><a href="#!" onclick="borrar_permanente('<?php echo $valor['imei'] ?>');"><i class="material-icons">delete_forever</i></a></td>
        
      </tr>
    <?php } ?>  

    

  </tbody>
</table>
<!--MODAL PARA ELIMINAR PERMANENTE-->
<div class="row">
  <div id="modal4" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">Se eliminará de forma permanente el pruducto : </h4>
    <p id="parrafo2"></p>
      <div class="row">
        <form class="col s12" id="borrar_perm">
          <div class="row">
            <div class="input-field col s12" id="contenido_bp2">

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
<!--MODAL PARA RECUPERAR ARTICULOS-->
<div class="row">
  <div id="modal3" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">Se recuperará el pruducto : </h4><br> Será agregado a la pestaña de productos disponibles para la venta "Ventas / PD".
    <p id="parrafo"></p>
      <div class="row">
        <form class="col s12" id="borrar_art">
          <div class="row">
            <div class="input-field col s12" id="contenido_bp">

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
function borrar_permanente(imei){
  document.getElementById("parrafo2").innerHTML = "<br>imei: "+imei ; 
  document.getElementById("contenido_bp2").innerHTML= "<input id='descripcionbp' name='descripcionbp' type='text' value='permanente' class='validate' hidden><input type='text' id='imeibp' name='imeibp' value='"+imei+"' hidden/>";
      $('#modal4').openModal();
}
$("#borrar_perm").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_perm"));
    $.ajax({
      url: "recursos/recupart.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("art_eliminados.php");
      }
    });
});

function borrar_producto(modelo, imei){
//PARA ESO TENGO QUE VERLO EN PERSONA
document.getElementById("parrafo").innerHTML = "<br>modelo: "+modelo+"<br>imei: "+imei ;
document.getElementById("contenido_bp").innerHTML= "<input id='descripcionbp' name='descripcionbp' type='text' value='recuperado' class='validate' hidden><input type='text' id='imeibp' name='imeibp' value='"+imei+"' hidden/>";
      $('#modal3').openModal();
}

$("#borrar_art").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_art"));
    $.ajax({
      url: "recursos/recupart.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("art_eliminados.php");
      }
    });
});


</script>
</body>
</html>

<!--COMPARAR LOS DATOS IMEI PARA OBTENER EL RESTO DE DATOS DE PRODUCTO-->