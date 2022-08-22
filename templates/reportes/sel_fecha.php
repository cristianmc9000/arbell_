<?php 
  date_default_timezone_set("America/La_Paz");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }

/*.fijo{
  border-style: solid;
  border-color: red;
}*/
.auto-imagen{
  padding:  1px;
  border: 4px solid transparent;
  background: linear-gradient(60deg, #afafaf 10%, #4e4e4e 100%);
  width: 80%;
  height:  250px;
}
.hijo{
  width:  40%;
}
.ui-autocomplete-row {
    padding: 8px;
    background-color: #f4f4f4;
    border-bottom: 1px solid #ccc;
    font-weight: bold;
}

.ui-autocomplete-row:hover {
    background-color: #ddd;
}
  </style>
</head>
<body>


<!-- <div class="row valign"> -->

  <div class="padre" style="display: flex; flex-direction: column; gap: 20px; justify-content: center; align-items: center; padding-top: 10%">

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap:20px; " class="hijo">
    <div class="" style="width: 100%">
        <!-- <div class="input-field"> -->
          <label>Seleccione la gestión:</label>
            <select name="gestion" id="gestion" class="browser-default">
              <option value="2021"  <?php if(date("Y") == "2021"){echo "selected";} ?>><b>2021</b></option>
              <option value="2022"  <?php if(date("Y") == "2022"){echo "selected";} ?>><b>2022</b></option>
              <option value="2023"  <?php if(date("Y") == "2023"){echo "selected";} ?>><b>2023</b></option>
              <option value="2024"  <?php if(date("Y") == "2024"){echo "selected";} ?>><b>2024</b></option>
            </select>
            <!-- <label><b>SELECCIONE LA GESTIÓN</b></label> -->
        <!-- </div> -->
    </div>

    <div class="" style="width: 100%;">
        <!-- <div class="input-field"> -->
          <label>Seleccione el periodo:</label>
          <select name="periodo" id="periodo" class="browser-default">
            <option value="0">Todos los periodos</option>
            <option value="1">Periodo 1</option>
            <option value="2">Periodo 2</option>
            <option value="3">Periodo 3</option>
            <option value="4">Periodo 4</option>
            <option value="5">Periodo 5</option>
            <option value="6">Periodo 6</option>
          </select>
          <!-- <label><b>SELECCIONE LA GESTIÓN</b></label> -->
        <!-- </div> -->
    </div>
  </div>

  <div class="hijo" >
    <label>Tipo de reporte:</label>
      <select name="tipo_reporte" id="tipo_reporte" class="browser-default">
        <option value="r_ventas.php" selected><b>Reportes de ventas</b></option>
        <option value="r_compras.php" ><b>Reportes de compras</b></option>
        <option value="r_le.php"><b>Reportes de Líder/Experta</b></option>
        <option value="r_lider.php"><b>Reporte de líderes</b></option>
      </select>
  </div>

  <div class="hijo">
    <div class="input-field">
      <input type="text" id="search_le" placeholder="Buscar líder" autocomplete="off" class="validate" hidden />
      <input type="text" id="codigo_le" hidden>
    </div>
  </div>

  <div class="center hijo" >
    <a href="#" onclick="reporte()" class="btn-large pink">Generar reporte</a>
  </div>

</div>

<script>
var mensaje = $("#mensaje");
mensaje.hide();


  $(document).ready(function() {
    $('select').material_select();
  });

  $('#search_le').autocomplete({
      source: "recursos/reportes/buscar_lider.php",
      minLength: 3,
      select: function(event, ui) {
          $("#codigo_le").val(ui.item.ca)
          $('#search_le').val(ui.item.value)
      }
  }).data('ui-autocomplete')._renderItem = function(ul, item) {
      return $("<li class='ui-autocomplete-row'></li>")
          .data("item.autocomplete", item)
          .append(item.label)
          .appendTo(ul);
  };


document.getElementById("tipo_reporte").addEventListener('change', () => {
  var option = document.getElementById("tipo_reporte").value;
  if (option == "r_lider.php") {
    document.getElementById("search_le").hidden = false;
    document.getElementById("search_le").disabled = false;
    document.getElementById("search_le").value = '';
    document.getElementById("codigo_le").value = '';
    // document.getElementById("search_le").setAttribute = 'required'
  }else{
    document.getElementById("search_le").value = '';
    document.getElementById("codigo_le").value = '';
    document.getElementById("search_le").disabled = true;
    document.getElementById("search_le").hidden = true;
    // document.getElementById("search_le").removeAttribute = 'required'
  }
})

//reporte por periodo y gestión
function reporte() {
  if (document.getElementById('tipo_reporte').value == 'r_lider.php' && document.getElementById('codigo_le').value == '') {
    return Materialize.toast('Ingrese el nombre o código de una lider/experta', 4000);
  }

  let per = document.getElementById('periodo').value;
  let gestion = document.getElementById('gestion').value
  let tipo = document.getElementById('tipo_reporte').value
  let ca = document.getElementById('codigo_le').value
  // let lider = document.getElementById('search_le').value
   console.log("templates/reportes/"+tipo+"?ges="+gestion+"&per="+per+"&ca="+ca)
  $("#cuerpo").load("templates/reportes/"+tipo+"?ges="+gestion+"&per="+per+"&ca="+ca)
}



</script>
</body>
</html>