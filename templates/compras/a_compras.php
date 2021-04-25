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
      <h3 align="">Buscar producto</h3>
      <div class="row">
        <form id="insert_row">
          <div class="input-field col s4">
            <div class="col s6">
              <input type="text" id="search_data" placeholder="Buscar producto" autocomplete="off" class="validate" required />
            </div>

            <div class="col s3">
              <input type="number" id="cantidad_" placeholder="Cantidad" required>
            </div>

            <div class="col s3">
              <input type="text" id="pupesos_" placeholder="Precio en Pesos Arg." required>
            </div>

            
            <input type="text" id="id_" value="" hidden>
            <input type="text" id="linea_" value="" hidden>
            <!-- <input type="text" id="pupesos_" value="" hidden> -->
            <input type="text" id="pubs_" value="" hidden>
          </div>

          <div class="col s2">
            <button class="btn waves-effect waves-light btn-large" type="submit" ><i class="material-icons right">assignment</i>Insertar</button>
          </div>
        </form>
        

        <div class="input-field col s1">
           % Descuento: 
          <div class="input-field inline">
            <input id="descuento_" type="number" min="0" max="100" value="0" class="validate">
          </div>
            

            

          <!-- </div> -->
        </div>

      </div>
    </div>

<div class="row">
  <div class="col s8">
  <table id="tabla_c" class="highlight">
    <thead>
      <tr>
          <!-- <th>Ver</th> -->
          <th>Código<br>(Producto)</th>
          <th>Linea</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>P.U.<br>(pesos arg.)</th>
          <th>P.U.<br>(Bs.)</th>
          <th>P.U. con <br>descuento (Pesos)</th>
          <th>P.U. con <br>descuento (Bs.)</th>
          <th>Valor de compra <br>S.D.</th>
          <th>Valor de compra <br>C.D.</th>

          <th>Borrar</th>
      </tr>
    </thead>

    <tbody>
      <tr>
      </tr>
    </tbody>
  </table>
  </div>

  <div class="col s3 offset-s1">
    <a onclick="recibo()" class="waves-effect waves-light btn-large"><i class="material-icons right">receipt</i>Registrar compra</a>
  </div>
</div>

<script>

//recuperar por formdata y enviar por json al lado servidor mediante ajax
//Crear un array con indices y guardar luego los datos de cantidad y pesos ahi... mediante el indice
var array_ = new Array();
$(document).ready(function(){
    
    $('#search_data').autocomplete({
      source: "recursos/compras/buscar_prod.php",
      minLength: 1,
      select: function(event, ui)
      {
        $("#id_").val(ui.item.id)
        $("#linea_").val(ui.item.linea)
        $("#pupesos_").val(ui.item.pupesos)
        $("#pubs_").val(ui.item.pubs)

        $('#search_data').val(ui.item.value);  
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };
});

document.getElementById("insert_row").addEventListener("submit", function (event) {
  event.preventDefault();

//Convertir precio en pesos a precio en Bs.
  var pubs_ = parseFloat($("#pupesos_").val()) * 0.07
  pubs_ = pubs_.toFixed(2)

// PRECIO CON DESCUENTO EN PESOS
  var desc_ = $("#descuento_").val()
  desc_ = parseFloat(desc_) * 0.01;
  var pupesos = $("#pupesos_").val()
  pupesos = parseFloat(pupesos) * parseFloat(desc_);
  pupesos = parseFloat($("#pupesos_").val()) - pupesos
  console.log(pupesos+"pcd pesos")

// PRECIO CON DESCUENTO EN BS.
  var pubs_desc = pubs_
  pubs_desc = parseFloat(pubs_desc) * parseFloat(desc_);
  pubs_desc = parseFloat(pubs_) - pubs_desc
  console.log(pubs_desc+"pcd bs")

  //Subtotal sin descuento
  precio_sd = parseFloat($("#cantidad_").val()) * pubs_
  precio_sd = precio_sd.toFixed(2)

  //Subtotal con descuento
  precio_cd = parseFloat($("#cantidad_").val()) * pubs_desc
  precio_cd = precio_cd.toFixed(2)

  let table = document.getElementById("tabla_c")
  let newTableRow = table.insertRow(-1)

  let newRow = newTableRow.insertCell(0)
  newRow.textContent = $("#id_").val()
  array_['id'] = $("#id_").val()

  newRow = newTableRow.insertCell(1)
  newRow.textContent = $("#linea_").val()
  array_['linea'] = $("#linea_").val()

  newRow = newTableRow.insertCell(2)
  newRow.textContent = $("#search_data").val()
  array_['descripcion'] = $("#search_data").val()

  newRow = newTableRow.insertCell(3)
  newRow.innerHTML = $("#cantidad_").val()

  newRow = newTableRow.insertCell(4)
  newRow.textContent = $("#pupesos_").val()
  array_['pupesos'] = $("#pupesos_").val()

  newRow = newTableRow.insertCell(5)
  newRow.textContent = pubs_
  array_['pubs'] = pubs_

  newRow = newTableRow.insertCell(6)
  newRow.textContent = pupesos
  array_['pup_desc'] = pupesos

  newRow = newTableRow.insertCell(7)
  newRow.textContent = pubs_desc
  array_['pubs_desc'] = pubs_desc

  newRow = newTableRow.insertCell(8)
  newRow.textContent = precio_sd
  array_['precio_sd'] = precio_sd

  newRow = newTableRow.insertCell(9)
  newRow.textContent = precio_cd
  array_['precio_cd'] = precio_cd

  newRow = newTableRow.insertCell(10)
  newRow.innerHTML = '<a href="#" class="btn-floating red"><i class="material-icons">delete</i></a>'

  console.log(array_)

  $("#search_data").val("")
  $("#cantidad_").val("")
  $("#pupesos_").val("")
});

function recibo() {
  $("#cuerpo").load('templates/compras/recibo_compra.php');
}
</script>