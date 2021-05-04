<style type="text/css">
    .ui-autocomplete-row
    {
      padding:8px;
      background-color: #f4f4f4;
      border-bottom:1px solid #ccc;
      font-weight:bold;
    }
    .ui-autocomplete-row:hover
    {
      background-color: #ddd;
    }
    .zoom {
    transition: transform .2s; 
    }

    .zoom:hover {
    transform: scale(1.8); 
    }
</style>

    <div class="fuente" style="">
      <h5 align="">Buscar Lider/Experta</h5>
      <div class="row">
        <form id="insert_row" >
          <div class="input-field col s6">
              <div class="col s6">
              <input type="text" id="search_le" placeholder="Buscar Lider/Experta" autocomplete="off" class="validate" required />
              </div>
              <!-- codigo -->
              <div class="col s3">
              <input type="text" id="ca" placeholder="código" autocomplete="off" required>
              </div>

              <div class="col s2">
              <input id="descuento_" type="number" min="0" max="100" value="" class="validate" placeholder="% Descuento">
            </div>
          </div>
              <!-- boton insertar -->
              <!-- <div class="col s2">
              <button class="btn waves-effect waves-light btn-large" type="submit" ><i class="material-icons right">assignment</i>Insertar</button>
              </div> -->
        </form>
      </div>
    </div>

<!-- anadir buscar -->
    <div class="row">
    <div class="fuente" style="">
      <h5 align="">Buscar producto</h5>
      <div class="row">
        <form id="insert_row_producto" >
          <div class="input-field col s5">
            <div class="col s5">
              <input type="text" id="search_producto" placeholder="Buscar producto" autocomplete="off" class="validate" required />
            </div>
            <div class="col s1">
              <b id="stock"></b>
            </div>
            <div class="col s3">
              <input type="number" id="cantidad_" placeholder="Cantidad" autocomplete="off" required>
            </div>
            <div class="col s3">
              <input type="text" id="pubs_" placeholder="Precio en bs." required>
            </div>
            <input type="text" id="id_" value="" hidden>
            <input type="text" id="linea_" value="" hidden>
            <input type="text" id="pupesos_" value="" hidden>
          <!--   <input type="text" id="pubs_" value="" hidden> -->
          </div>
          <div class="col s2">
            <button class="btn waves-effect waves-light btn-large" type="submit" ><i class="material-icons right">assignment</i>Insertar</button>
          </div>
        </form>
      </div>
    </div>

    </div>


    <!-- tabla de productos pa la venta -->
    <div class="row">
  <div class="col s8">
  <table id="tabla_compras" class="highlight">
    <thead>
      <tr>
          <!-- <th>Ver</th> -->
          <th>Código<br>(Producto)</th>
          <th>Linea</th>
          <th>Descripción</th>
          <th>Stock</th>
          <th>Cantidad</th>
          <th>Precio U. <br>Pesos</th>
          <th>Precio U. Bs.</th>
          <th>Precio con <br>Descuento</th>
          <th>Subtotal</th>
          <th>Borrar</th>
      </tr>
    </thead>
    <tbody id="tabla_c" class="tabla_c">
    </tbody>
  </table>
  </div>

<!--MODAL AGREGAR PRODUCTO-->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h5 class="fuente"><b>Se registrará la compra y se imprimirá un recibo.</b></h5> <br><br> 
  </div>
  <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn-flat red left">CANCELAR</a>
      <a href="#!" onclick="crear_html()" class="modal-close waves-effect waves-light btn-flat blue">REGISTRAR COMPRA</a>
  </div>
</div>
</div>

<script>

//recuperar por formdata y enviar por json al lado servidor mediante ajax
//Crear un array con indices y guardar luego los datos de cantidad y pesos ahi... mediante el indice

$(document).ready(function(){
    $('#modal').leanModal();
    $('#search_le').autocomplete({
      source: "recursos/ventas/buscar_le.php",
      minLength: 1,
      select: function(event, ui)
      {
        $("#ca").val(ui.item.ca)
        if(ui.item.nivel == "experta"){
          $("#descuento_").val('30')
        }
        $('#search_le').val(ui.item.value);  
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

    //buscar producto 
    $('#search_producto').autocomplete({
      source: "recursos/ventas/buscar_producto.php",
      minLength: 1,
      select: function(event, ui)
      {
        $("#pubs_").val(ui.item.pubs)
        $("#stock").html(ui.item.stock)
        $('#search_producto').val(ui.item.value);  
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    }; 
});
/* --------------funcion insertar fila de producto---------------- */
document.getElementById("insert_row_producto").addEventListener("submit", function (event) {
  event.preventDefault();

//Convertir precio en pesos a precio en Bs.
  var pubs_ = parseFloat($("#pupesos_").val()) * parseFloat($("#valor").val())
  pubs_ = pubs_.toFixed(1)

// PRECIO CON DESCUENTO EN PESOS
  var desc_ = $("#descuento_").val()
  desc_ = parseFloat(desc_) * 0.01;
  var pupesos = $("#pupesos_").val()
  pupesos = parseFloat(pupesos) * parseFloat(desc_);
  pupesos = parseFloat($("#pupesos_").val()) - pupesos
  pupesos = pupesos.toFixed(1)
  // console.log(pupesos+"pcd pesos")

// PRECIO CON DESCUENTO EN BS.
  var pubs_desc = pubs_
  pubs_desc = parseFloat(pubs_desc) * parseFloat(desc_);
  pubs_desc = parseFloat(pubs_) - pubs_desc
  pubs_desc = pubs_desc.toFixed(1)

  // console.log(pubs_desc+"pcd bs")

  /* //Subtotal sin descuento
  precio_sd = parseFloat($("#cantidad_").val()) * pubs_
  precio_sd = precio_sd.toFixed(1) */

  //Subtotal con descuento
  precio_cd = parseFloat($("#cantidad_").val()) * pubs_desc
  precio_cd = precio_cd.toFixed(1)

  let table = document.getElementById("tabla_c")
  let newTableRow = table.insertRow(-1)
  
  let newRow = newTableRow.insertCell(0)
  newRow.textContent = $("#id_").val()
  newRow.className = "_id"

  newRow = newTableRow.insertCell(1)
  newRow.textContent = $("#linea_").val()
  newRow.className = "_linea"

  newRow = newTableRow.insertCell(2)
  newRow.textContent = $("#search_producto").val()
  newRow.className = "_descripcion"

  newRow = newTableRow.insertCell(3)
  newRow.textContent = $("#cantidad_").val()
  newRow.className = "_cantidad"

  newRow = newTableRow.insertCell(4)
  newRow.textContent = $("#pupesos_").val()
  newRow.className = "_pupesos"

  newRow = newTableRow.insertCell(5)
  newRow.textContent = pubs_
  newRow.className = "_pubs"

  newRow = newTableRow.insertCell(6)
  newRow.textContent = pupesos
  newRow.className = "_pupesos_desc"

  newRow = newTableRow.insertCell(7)
  newRow.textContent = pubs_desc
  newRow.className = "_pubs_desc"

  newRow = newTableRow.insertCell(8)
  newRow.textContent = precio_sd
  newRow.className = "_precio_sd"

  newRow = newTableRow.insertCell(9)
  newRow.textContent = precio_cd
  newRow.className = "_precio_cd"

  newRow = newTableRow.insertCell(10)
  newRow.innerHTML = '<a href="#!" onclick="delete_row(event)" class="btn-floating red"><i class="material-icons">delete</i></a>'


  $("#search_producto").val("")
  $("#cantidad_").val("")
  $("#pupesos_").val("")
});


</script>

