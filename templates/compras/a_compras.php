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
  </head>
  <body>
    <div class="container" style="padding:120px;">
      <h3 align="center">AutoComplete Textbox with Image using jQuery Ajax PHP Mysql and JqueryUI</h3>
      <div class="row">
        <div class="input-field col s12">
          <input type="text" id="search_data" placeholder="Buscar producto" autocomplete="off" class="validate" />
        </div>
      </div>
    </div>
<script>
$(document).ready(function(){
    $('#search_data').autocomplete({
      source: "recursos/compras/buscar_prod.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#search_data').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };
});
</script>