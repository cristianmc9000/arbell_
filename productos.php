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
#tabla2 td, #tabla2 th{
  padding: 0 !important;
}
#tabla2{
  font-size: 13px;
}
#tabla3 td, #tabla3 th{
  padding: 0 !important;


}


#tabla3{
  font-size: 13px;
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

<!--<span class="fuente"><h5>Ventas / Productos disponibles</h5></span>-->


<!-- TABLA -->
<div class="col s10">
<table id="tabla1" name="tabla1" class="highlight">
  <thead>
    <tr>
        
        <th data-field="id">Código</th>
        <th data-field="id">Producto</th>
        <th data-field="name">cantidad</th>
        <th data-field="price">Precio</th>
        <th data-field="price">Vender</th>

    </tr>
  </thead>

  <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr <?php if(($valor['cantidad']) =='0') echo 'style="background-color: #FA5858"'; if(($valor['cantidad'])<71){ echo 'style="background-color: #F4FA58"';}?>>
        
        <td><?php echo $valor["codigo"] ?></td>
        <td><?php echo $valor["modelo"] ?></td>
        <td><?php echo $valor["cantidad"] ?></td> 
        <td><?php echo $valor["precio_ref"]." Bs." ?></td>
        

        <td><center><input type="checkbox" id="<?php echo $valor['codigo'] ?>" onclick="contarSeleccionados('<?php echo $valor['id']?>')" ><label for="<?php echo $valor['codigo']?>"/></center></td>
        
      </tr>
    <?php } ?>  

    

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




<!--MODAL REALIZAR VENTA-->
<div class="row">
<div id="modal1" class="modal col s8 offset-s2">
  <div class="modal-content">
    <div class="row">
        <div class="row col s6" style="border: solid 1px; background-color: #efefef;">
        <p><b>--- Datos de cliente ---</b></p>
            <!-- TABLA -->
            <table id="tabla2" class="highlight">
              <thead>
                <tr>
                    <th data-field="nombres" >Nombres</th>
                    <th data-field="apellidos" >Apellidos</th>
                    <th data-field="ci" >CI</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($fila2 as $a  => $valor){ ?>
                  <tr style="cursor: pointer;" onclick="cargar_cliente('<?php echo $valor['id'] ?>', '<?php echo $valor['nombre'] ?>', '<?php echo $valor['apellidos'] ?>', '<?php echo $valor['ci'] ?>');">
                    <td><?php echo $valor["nombre"] ?></td>
                    <td><?php echo $valor["apellidos"] ?></td>
                    <td><?php echo $valor["ci"] ?></td>
                  </tr>
                <?php }?>
              </tbody>
            </table><br>
            <!--FORMULARIO DE CLIENTE-->
            <form  id="buscar_cliente">
              <div class="row" id="campos_cliente">

              </div>
            </form>
        </div>
        <div class="row col s6" id="impresion_1" style="border: solid 1px; background-color: #efefef;">
          <p><b>--- Detalle de venta ---</b></p>
          <table id="tabla3" class="highlight striped" style="border: solid 1px; font-size: 11px;">
              <thead>
                <tr valign="bottom">
                    <th>código</th>
                    <th>--</th>
                    <th class='col s12'>producto</th>
                    <th ></th>
                    <th>precio</th>
                    <th >---</th>
                    <th>stock</th>
                    <th></th>
                    <th class='col s10 right'>cantidad</th>

                </tr>
              </thead>
              <tbody id="cuerpo_tabla3">

              </tbody>
            </table>
        </div>

        <div class="row" style="color: red">
          <div class="col s12">
            <div class="col s2 offset-s8">
              <p><b> Subtotal: Bs. </b></p>
            </div>
            <div class="col s2">  
              <div class="input-field" id="subtotal">
                <input id="total" name="total" type="text" class="validate">
              </div> 
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn waves-effect waves-light" type="submit" onclick="enviar();">Aceptar</button>
          <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cerrar</a>
        </div>
    </div>
  </div>

</div>
</div>

<!--MODAL PARA ELIMINAR ARTICULOS-->
<div class="row">
  <div id="modal3" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">Se eliminará el producto: </h4>
    <p id="parrafo"></p>
      <div class="row">
        <form class="col s12" id="borrar_art">
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

<!--MODAL MODIFICAR ARTICULO-->
<div class="row">
<div id="modal4" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Modificar Producto</h4>  
    <div class="row">
      <form class="col s12" id="modificar_art">
        <div class="row">
          <div class="input-field col s12" id="id_articulo">
            
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12" id="cod_articulo">

          </div>
        </div>

        <div class="row">
          <div class="input-field col s12" id="model_articulo">

          </div>
        </div>

        <div class="row">
          <div class="input-field col s12" id="cant_articulo">

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

function cargar_cliente(id,nombre,apellidos,ci){

  document.getElementById("campos_cliente").innerHTML ='<div class="input-field col s4"><input id="nombrec" onchange="control();" name="nombrec" value="'+nombre+'" type="text" class="validate" required><label class="active" id="labelnc" for="nombrec">Nombres</label></div><div class="input-field col s4"><input id="apellidosc" name="apellidosc" onchange="control();" type="text" value="'+apellidos+'" class="validate" required><label class="active" id="labelac" for="apellidosc">Apellidos</label></div><div class="input-field col s4"><input id="ci" name="ci" type="number" class="validate" value="'+ci+'" ><label class="active" id="labelci" for="ci">CI</label></div><input type="text" name="id_c" id="id_c" value="'+id+'" hidden/>';
}
function modificar_articulo(id, codigo, modelo, cantidad){
document.getElementById("id_articulo").innerHTML= "<input id='id_mod' name='id_mod' type='number' class='validate' value='"+id+"' hidden>";
document.getElementById("cod_articulo").innerHTML= "<input id='cod_mod' name='cod_mod' type='text' class='validate' value='"+codigo+"' required><label for='cod_mod' class='active'>Código</label>";
document.getElementById('model_articulo').innerHTML="<input id='mod_model' name='mod_model' type='text' class='validate' value='"+modelo+"' required><label for='mod_model' class='active'>Modelo</label>";
document.getElementById("cant_articulo").innerHTML="<input id='mod_cant' name='mod_cant' type='text' class='validate' value='"+cantidad+"' required><label for='mod_cant' class='active'>Cantidad</label>";

      $('#modal4').openModal();

}
function control() {
  $("#id_c").val("control");
}
$("#modificar_art").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_art"));
    $.ajax({
      url: "recursos/modificarart.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("productos.php");
      }
    });
});


function borrar_producto(modelo, codigo, cantidad){
//PARA ESO TENGO QUE VERLO EN PERSONA
document.getElementById("parrafo").innerHTML = "<br>modelo: "+modelo+"<br>código: "+codigo+"<br>cantidad: "+cantidad ;
document.getElementById("contenido_bp").innerHTML= "<input id='descripcionbp' name='descripcionbp' type='text' class='validate'><label for='descripcionbp'>Breve descripción del motivo (opcional).</label><input type='text' id='imeibp' name='imeibp' value='"+codigo+"' hidden/>";
      $('#modal3').openModal();
}

$("#borrar_art").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_art"));
    $.ajax({
      url: "recursos/borrarart.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("productos.php");
      }
    });
});


var ids = [];
function contarSeleccionados(id){
  if (ids.indexOf(id) !== -1) {
    ids.splice(ids.indexOf(id),1);
  }else{
    ids.push(id);
  }
}

function realizarVenta(){

document.getElementById("campos_cliente").innerHTML ='<div class="input-field col s4"><input id="nombrec" name="nombrec" value ="" type="text" class="validate" required><label id="labelnc" for="nombrec">Nombres</label></div><div class="input-field col s4"><input id="apellidosc" name="apellidosc" type="text" value="" class="validate" required><label id="labelac" for="apellidosc">Apellidos</label></div><div class="input-field col s4"><input id="ci" name="ci" type="number" class="validate" value="" ><label id="labelci" for="ci">CI</label></div><input type="text" name="id_c" id="id_c" value="control" hidden/>';

var precio_total= 0;
document.getElementById("cuerpo_tabla3").innerHTML ="";

  for (var i = 0; i < ids.length; i++) {
      <?php foreach($fila as $a  => $valor){ ?>

      if ('<?php echo $valor['id'] ?>' == ids[i]){

        var table = document.getElementById("cuerpo_tabla3");
        var row = table.insertRow(0);
        row.insertCell(0).innerHTML = "<?php echo $valor['codigo'] ?>";
        row.insertCell(1).innerHTML = ":::";
        row.insertCell(2).innerHTML = "<?php echo $valor['modelo'] ?>";
        row.insertCell(3).innerHTML = ":::";
        row.insertCell(4).innerHTML = "<?php echo $valor['precio_ref'] ?>";
        row.insertCell(5).innerHTML = ":::";
        row.insertCell(6).innerHTML = "<?php echo $valor['cantidad'] ?>";
        row.insertCell(7).innerHTML = ":::";
        row.insertCell(8).innerHTML = "<div class='col s10 right'><input class='cant_ven' idc='<?php echo $valor['id'] ?>' type='number' precio='<?php echo $valor['precio_ref'] ?>' value='1' min='1' /></div>";

        precio_total= precio_total+parseFloat("<?php echo $valor['precio_ref'] ?>");

      }
    <?php } ?>
  }
  precio_total=precio_total.toFixed(2);
  document.getElementById("subtotal").innerHTML ='<input id="total" name="total" type="text" value="'+precio_total+'" class="validate">';


}

 $(document).on('change', ".cant_ven", function(){
 
  var total = 0;
  $('.cant_ven').each(function(){
    var cant = $(this).val();
    var precio = $(this).attr('precio');
    total = total+(cant*precio);
  })

  total = parseFloat(total);
  total = total.toFixed(2);
  $("#total").val(total);
 });


function enviar() {

   nombrec=document.getElementById("nombrec").value; 
   apellidosc=document.getElementById("apellidosc").value;
   cic=document.getElementById("ci").value; 
   total=document.getElementById("total").value;
   id_c=document.getElementById("id_c").value;

  var cants=[];
  var idc=[];
  $('.cant_ven').each(function(){
    var cant = $(this).val();
    var id = $(this).attr('idc');
    cants.push(cant);
    idc.push(id);

  })



  var x="";
  var y="";
    if(idc.length > 0){
      for (var i = 0; i < ids.length; i++){
        x=x+"&"+i+"="+idc[i];
        y=y+"&"+i+"c="+cants[i];

      }
       misdatos="eid="+id_c+"&enombre="+nombrec+"&eapellidos="+apellidosc+"&eci="+cic+"&etotal="+total+x+y+"&ecantidad="+ids.length;

       objetoAjax=creaObjetoAjax();

       objetoAjax.open("POST","recursos/ventas.php",true);

       objetoAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       objetoAjax.setRequestHeader("Content-length", misdatos.length);
       objetoAjax.setRequestHeader("Connection", "close");
       objetoAjax.onreadystatechange=recogeDatos;
       objetoAjax.send(misdatos);
   }else{
    Materialize.toast("No se ha seleccionado ningún producto...", 4000); 
   }
} 

function creaObjetoAjax () { 
     var obj;
     if (window.XMLHttpRequest) {
        obj=new XMLHttpRequest();
        }
     else { 
        obj=new ActiveXObject(Microsoft.XMLHTTP);
        }
     return obj;
}
function recogeDatos() {
    if (objetoAjax.readyState==4 && objetoAjax.status==200) {
        miTexto=objetoAjax.responseText;
        if(miTexto.includes('rellenar_campos')){
          Materialize.toast("DEBES LLENAR TODOS LOS CAMPOS CORRECTAMENTE !", 5000);
        }else{
            mensaje.html(miTexto);
            if(!miTexto.includes('stock_productos')){
              $("#cuerpo").load("productos.php");
            }
          }
        }
}
function limpiar(){
  for(var i=0; i< ids.length; i++){
    document.getElementById(ids[i]).checked=0;
  } 
  ids.length=0;
}
</script>
</body>
</html>
