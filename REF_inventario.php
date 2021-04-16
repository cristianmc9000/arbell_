<?php

require('recursos/conexion.php');
session_start();
$suc = $_SESSION['sucursal'];
$Sql = "SELECT * FROM productos WHERE estado=1 and sucursal=".$suc.""; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'cod'=>$arr['codigo'], 'modelo'=>$arr['modelo'], 'cantidad'=>$arr['cantidad'], 'precio_ref'=>$arr['precio_ref']); 

    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Productos</title>

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
  margin-right:40px;
}
</style>

</head>
<body>

<span class="fuente"><h5>Productos	
  <!-- Modal Trigger -->
	<a class="waves-effect waves-light btn-floating btn-large red" id="modal_trigger_1" href="#modal1"><i class="material-icons left">add</i></a></h5> 
</span>

<!-- TABLA -->
<div class="col s10">
<table id="tabla1" class="highlight">
  <thead>
    <tr>
        <th data-field="cod">Código</th>
        <th data-field="id">Modelo</th>
        <th data-field="price">Cantidad</th>
        <th data-field="price">Precio</th>
        <th data-field="price">Modificar</th>
        <th data-field="price">Borrar</th>

    </tr>
  </thead>

  <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr <?php if(($valor['cantidad']) =='0') echo 'style="background-color: #FA5858"'; if(($valor['cantidad'])<71) echo 'style="background-color: #eeee00"'?>>
        <td><?php echo $valor["cod"] ?></td>
        <td><?php echo $valor["modelo"] ?></td>
        <td><?php echo $valor["cantidad"] ?></td>
        <td><?php echo $valor["precio_ref"] ?> Bs.</td>
        
        <td><a href="#!" onclick="modificar_producto('<?php echo $valor['id'] ?>', '<?php echo $valor['cod'] ?>', '<?php echo $valor['modelo'] ?>', '<?php echo $valor['precio_ref'] ?>', '<?php echo $valor['cantidad'] ?>');"><i class="material-icons">build</i></a></td>
        <td><center><a href="#!" onclick="borrar_producto('<?php echo $valor['cod'] ?>', '<?php echo $valor['modelo'] ?>','<?php echo $valor['cantidad'] ?>','<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a></center></td>

      </tr>
    <?php } ?>	

    

  </tbody>
</table>
</div>





  <!-- Modal Structure AGREGAR PRODUCTOS -->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Agregar producto</h4>  
    <div class="row">
      <form class="col s12" id="agregar">

        <div class="row">
          <div class="input-field col s12">
            <input id="codigo" name="codigo" type="text" class="validate" required>
            <label for="codigo">Código</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="nombre" name="nombre" type="text" class="validate" required>
            <label for="nombre">Nombre (modelo)</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="cantidad" name="cantidad" type="number" class="validate" value="0">
            <label for="cantidad">Cantidad</label>
          </div>
        </div>

        <div class="row">  
          <div class="input-field col s12">
            <input id="precio" name="precio" type="text" class="validate" required>
            <label for="precio">Precio referencial (Bs.)</label>
          </div>
        </div>

<!--         <div class="row">  
          <div class="input-field col s12" id="rellenar" hidden>

          </div>
        </div> -->

        <div class="row" hidden>
          <div class="input-field col s12">
            <input id="control" name="control" type="text"  value="1">
          </div>
        </div>

        <div class="modal-footer">
            <button class="btn waves-effect waves-light" type="submit" >Agregar</button>
            <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cerrar</a>

        </div>
      </form>
    </div>
  </div>

</div>
</div>

  <!-- Modal Structure MODIFICAR PRODUCTOS-->
<div class="row">
<div id="modal5" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Modificar Producto</h4>  
    <div class="row">
      <form class="col s12" id="modificar_productos">

        <div class="row">
          <div class="input-field col s12" id="idprod">

          </div>
        </div>

        <div class="row">
          <div class="input-field col s12" id="codigo_prod">
            <input id="cod_prod" name="codigo" type="text" class="validate" value="x">
            <label for="cod_prod" class="active" >Código</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12" id="modelo_modpro">

          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="cantidadm" name="cantidad" type="number" class="validate" value="1">
            <label for="cantidad" class="active" >Cantidad</label>
          </div>
        </div>

        <div class="row">  
          <div class="input-field col s12" id="precio_modpro">

          </div>
        </div>

        <div class="row" hidden>
          <div class="input-field col s12">
            <input id="control" name="control" type="text"  value="control">
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



<!--ESTRUCTURA DEL MODAL PARA MENSAJES DESDE PHP-->
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div id="mensaje" class="modal-content">
      
    </div>
    <div class="modal-footer row">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>

  <!-- Estructura del modal para agregar CANTIDAD-->
<div class="row">
  <div id="modal4" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="tituloac"></h4>
      <div class="row">
        <form class="col s12" id="agregar_imei">
          <div class="row">
            <div class="input-field col s12" id="contenido_cant"></div>
            <div class="input-field col s12" id="contenido_boton"></div>
            <div class="input-field col s12" id="contenido_data"></div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >ACEPTAR</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div id="modal6" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">Se eliminará el producto: </h4>
      <div class="row">
        <form class="col s12" id="borrar_productos">
          <div class="row">
            <div class="input-field col s12" id="contenido_bp">
             
            </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Eliminar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
function borrar_producto(codigo, modelo, cantidad, id){

document.getElementById("titulobp").innerHTML = "Se eliminará el producto: <br><br>Código: "+codigo+"<br>Modelo: "+modelo+"<br>Cantidad: "+cantidad ;
document.getElementById("contenido_bp").innerHTML= "<input type='text' id='idbp' name='idbp' value='"+id+"' hidden/>";
      $('#modal6').openModal();
}


$("#borrar_productos").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_productos"));
    $.ajax({
      url: "recursos/borrar.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("inventario.php");
      }
    });
});



function mod_cant(id, modelo){

document.getElementById("tituloac").innerHTML = "Agregar códigos IMEI: <br>"+modelo;
  document.getElementById("contenido_data").innerHTML= "<input type='text' id='ida' name='ida' value='"+id+"' hidden/>"
  document.getElementById("contenido_boton").innerHTML= "<div class='row'><a href='#!' class='btn waves-effect waves-light' onclick='agregar_casilla();'>Agregar casilla <i class='material-icons left'>add</i></a></div>";
  //imi=0;
  $('#modal4').openModal({
    dismissible: false, // Modal can't be dismissed by clicking outside of the modal 
    //opacity: .5, // Opacity of modal background 
    //in_duration: 300, // Transition in duration 
    //out_duration: 200, // Transition out duration ready: 
    //function() { }, // Callback for Modal open complete: function() { /*alert('Closed');*/ } // Callback for Modal close });
  });
}
  var imi=0;
function agregar_casilla(){

      $("#contenido_cant").append("<div id='"+imi+"r'><div class='col s8'><input type='number' id='"+imi+"' name='"+imi+"' required/></div><div class='col s3'><a href='#!' class='btn red waves-effect waves-light' onclick='borrar_casilla("+imi+")' ><i class='material-icons'>clear</i></a></div></div>");
      imi++;

}
function borrar_casilla(id){

  document.getElementById(id+"r").innerHTML ="<input type='text' id='"+id+"' name='"+id+"' value='0' hidden/>";
}

function modificar_producto(id, codigo, modelo, precio_ref, cantidad){

document.getElementById("idprod").innerHTML='<input id="id_prod" name="id_prod" type="text" value="'+id+'" hidden>';

document.getElementById("modelo_modpro").innerHTML='<input placeholder="'+modelo+'" id="nombre" name="nombre" type="text" class="validate" value="'+modelo+'" required><label for="nombre" class="active">Nombre (modelo)</label>';
document.getElementById("precio_modpro").innerHTML='<input placeholder="'+precio_ref+'" id="precio" name="precio" type="text" class="validate" value="'+precio_ref+'" required><label for="precio" class="active">Precio referencial (Bs.)</label>';

$("#cod_prod").val(codigo);
$('#cantidadm').val(cantidad);
// $("#act").addClass('active');


  //Materialize.updateTextFields();
  $('#modal5').openModal();
}

$("#modificar_productos").on("submit", function(e){

    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_productos"));
    $.ajax({
      url: "recursos/agregarp.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){

      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("inventario.php");
      }
    });
});

$("#agregar_imei").on("submit", function(e){
    e.preventDefault();

    $("#contenido_data").append("<input type='number' id='cantidadi' name='cantidadi' value='"+imi+"' hidden/>");
    var val = new FormData(document.getElementById("agregar_imei"));
    $.ajax({
      url: "recursos/agregari.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){

      if (echo == "exito") {
        mensaje.html(echo);
        $("#modal4").closeModal(); 
        Materialize.toast("Agregado(s) con éxito." , 4000);
        $("#cuerpo").load("inventario.php");
      }else{
        mensaje.html(echo);
      }
    });
});


var mensaje = $("#mensaje");
mensaje.hide();

$(document).ready(function() {

    $('#tabla1').dataTable();
    $('#modal_trigger_1').leanModal();
    $('#modal_trigger_3').leanModal();


});

$("#agregar").on("submit", function(e){
//function agregar(){
  //Evitamos que se envíe por defecto
  e.preventDefault();

  //Creamos un FormData con los datos del mismo formulario
  var formData = new FormData(document.getElementById("agregar"));

  //Llamamos a la función AJAX de jQuery
  $.ajax({
    //Definimos la URL del archivo al cual vamos a enviar los datos
    url: "recursos/agregarp.php",
    //Definimos el tipo de método de envío
    type: "POST",
    //Definimos el tipo de datos que vamos a enviar y recibir
    dataType: "HTML",
    //Definimos la información que vamos a enviar
    data: formData,
    //Deshabilitamos el caché
    cache: false,
    //No especificamos el contentType
    contentType: false,
    //No permitimos que los datos pasen como un objeto
    processData: false
  }).done(function(echo){
    //Una vez que recibimos respuesta
    //comprobamos si la respuesta no es vacía
    if (echo !== "") {

      //Si hay respuesta (error), mostramos el mensaje
      mensaje.html(echo);
      $("#cuerpo").load("inventario.php");
    }
  });
});

</script>
</body>
</html>

<!--COMPARAR LOS DATOS IMEI PARA OBTENER EL RESTO DE DATOS DE PRODUCTO-->