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
      <h3 align="">Buscar Lider/Experta</h3>
      <div class="row">
        <form id="insert_row" >
          <div class="input-field col s6">
              <div class="col s6">
              <input type="text" id="search_data" placeholder="Buscar Lider/Experta" autocomplete="off" class="validate" required />
              </div>
              <!-- codigo -->
              <div class="col s3">
              <input type="number" id="ca" placeholder="código" autocomplete="off" required>
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
    $('#search_data').autocomplete({
      source: "recursos/ventas/buscar_le.php",
      minLength: 1,
      select: function(event, ui)
      {
        $("#ca").val(ui.item.ca)
        if(ui.item.nivel == "experta"){
          $("#descuento_").val('30')
        }
        $('#search_data').val(ui.item.value);  
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

    /* buscar producto */
    // $('#search_prod').autocomplete({
    //   source: "recursos/ventas/buscar_producto.php",
    //   minLength: 1,
    //   select: function(event, ui)
    //   {
    //     $("#ca").val(ui.item.ca)
    //     if(ui.item.nivel == "experta"){
    //       $("#descuento_").val('30')
    //     }
    //     $('#search_data').val(ui.item.value);  
    //   }
    // }).data('ui-autocomplete')._renderItem = function(ul, item){
    //     // console.log(item)
    //     return $("<li class='ui-autocomplete-row'></li>")
    //     .data("item.autocomplete", item)
    //     .append(item.label)
    //     .appendTo(ul);
    // };
});
</script>

