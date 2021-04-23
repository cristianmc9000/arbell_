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
</style>

    <div class="fuente" style="">
      <h3 align="">Buscar producto</h3>
      <div class="row">
        <div class="input-field col s3">
          <input type="text" id="search_data" placeholder="Buscar producto" autocomplete="off" class="validate" />
          <input type="text" id="id_" value="" hidden>
          <input type="text" id="linea_" value="" hidden>
          <input type="text" id="pupesos_" value="" hidden>
          <input type="text" id="pubs_" value="" hidden>
        </div>
        <div col s2>
          <a href="#!" onclick="insert_row()" class="waves-effect waves-light btn-large"><i class="material-icons right">assignment</i>Insertar</a>
        </div>
      </div>
    </div>
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
        <th>Precio con <br>descuento</th>
        <th>Subtotal</th>

        <th>Borrar</th>
    </tr>
  </thead>

  <tbody>
  
    <tr>

      

    </tr>

  </tbody>
</table>
</div>
<script>

//recuperar por formdata y enviar por json al lado servidor mediante ajax
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
function insert_row() {
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
  newRow.innerHTML = "<input type='number' name='cantidad'>"

  newRow = newTableRow.insertCell(4)
  newRow.textContent = $("#pupesos_").val()
  array_['pupesos'] = $("#pupesos_").val()

  newRow = newTableRow.insertCell(5)
  newRow.textContent = $("#pubs_").val()
  array_['pubs'] = $("#pubs_").val()

  newRow = newTableRow.insertCell(6)
  newRow.textContent = ""

  newRow = newTableRow.insertCell(7)
  newRow.textContent = ""



  newRow = newTableRow.insertCell(8)
  newRow.innerHTML = '<a href="#" class="btn-floating red"><i class="material-icons">delete</i></a>'

  console.log(array_)

}
</script>