
<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
	<link rel="stylesheet" href="css/jquery.nice-number.css">
	<link rel="stylesheet" href="css/pedidos.css">
	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
		integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous"
		referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="css/viewpdf.css">

  <script src="js/jquery-3.0.0.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/jquery.nice-number.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"
		integrity="sha512-U5C477Z8VvmbYAoV4HDq17tf4wG6HXPC6/KM9+0/wEXQQ13gmKY2Zb0Z2vu0VNUWch4GlJ+Tl/dfoLOH4i2msw==" crossorigin="anonymous"
		referrerpolicy="no-referrer"></script>

	<title>Distribuidora Carmina - Pedidos</title>
</head>
<style>
	.grande{
		font-size: 3rem !important;
		/*color: #2ecc71;*/
	}
	.semi{
		font-size: 1.5rem !important;
	}
	.contenedor{
		/*margin-top: 5%;*/
		/*display: flex;*/
		/*gap: 20px;*/
	}

	.font_black{
		/*color: black !important;*/
	}

	.ui-autocomplete-row{
    padding: 1px;
    background-color: #f4f4f4;
    border-bottom:1px solid #ccc;
    font-weight:bold;
    display: flex;
    align-items: center;
  }
  .ui-autocomplete-row:hover{
    background-color: #ddd;
  }
  .zoom {
  transition: transform .2s; 
  }

  .zoom:hover {
    transform: scale(1.8); 
  }

</style>

<body>
<div class="nav_container">
	<nav>
		<div class="nav-wrapper">
			<a href="#" id="menu" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			<a href="#" class="brand-logo center fuente">Dist. Carmina</a>
			<ul class="right">
				<li><a href="#" id="cart"><i class="grande material-icons"><img style="max-height: 40px;" src="images/icons/vacio.png"/></i></a></li>
			</ul>
		</div>
	</nav>

	<ul id="slide-out" class="sidenav">
	    <li><div class="user-view">
	      <div class="background">
	        <img src="images/sort_desc.png" height="100%" width="100%">
	      </div>
	      <a href="#user"><img class="circle" src="images/logo_sin_fondo.png"></a>
	      <a href="#name"><span class="white-text name">Carmen</span></a>
	      <a href="#email"><span class="white-text email">carmen@gmail.com</span></a>
	    </div></li>
	    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
	    <li><a href="#!">Second Link</a></li>
	    <li><div class="divider"></div></li>
	    <li><a class="subheader">Subheader</a></li>
	    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
	</ul>
</div>

<!-- <div class="row" style="margin-bottom: 0px;">
	<div class="input-field col s10 offset-s1">
	    <select>
	      <option value="" disabled selected >Selecciona el catálogo</option>
	      <option value="1">Catálogo 55</option>
	      <option value="2">Catálogo 58</option>
	      <option value="3">Catálogo 60</option>
	    </select>
	   <label>Selecciona el catálogo</label>
	</div>
</div> -->


<!-- FORMULARIO PARA SUBIR CATÁLOGOS -->
<!-- <div class="container">
    <form class="col s12" id="load_pdf">
      <div class="row">
        <div class="input-field file-field col s6">
          <div class="btn">
            <span>Foto</span>
            <input type="file" name="pdf">
          </div>
          <div class="file-path-wrapper">
            <input id="foto" class="file-path validate" type="text">
          </div>
        </div>
      </div>

      <div class="modal-footer">
          <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
          <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
      </div>
  	</form>
</div> -->



<div class="contenedor" id="pdf_container">
<!-- 	<div class="left_arrow"><a href="#"><i class="large material-icons">chevron_left</i></a></div>
	<div class="catalogo"><img width="100%" src="images/catalogo.png" alt="catalogo..."></div>
	<div class="right_arrow"><a href="#"><i class="large material-icons">chevron_right</i></a></div> -->
	<div id="princ">
		<h3 id="open_h3">Open a PDF file</h3>
		<canvas style="max-width: 95%;" class="pdf-viewer hidden">

		</canvas>
	</div>
	<div id="foot">
		<ul style="margin-top: 0px;margin-bottom: 0px;">
			<li>
				<button id="openPDF" hidden>
					<span>Open</span> <i class="fas fa-folder-open"></i>
				</button>
				<input type="file" id="inputFile" hidden>
			</li>
			<li class="pagination">
				<button id="previous"><i class="fas fa-arrow-alt-circle-left"></i></button>
				<span id="current_page">0 of 0</span>
				<button id="next"><i class="fas fa-arrow-alt-circle-right"></i></button>
			</li>

			<li hidden>
				<span id="zoomValue">150%</span>
				<input type="range" id="zoom" name="cowbell" min="100" max="300" value="150" step="50" disabled>
			</li>
		</ul>
	</div>
</div>

<div class="container" id="form_container">
	<div class="row">	
		<div class="input-field col s7">
	        <input id="search_data" type="text" autocomplete="off" class="validate semi" required>
	        <label for="search_data">Código producto</label>
	    </div>
		<div class="input-field col s4 offset-s1">
			<div class="number-container">
				<!-- <label for="">Cantidad</label> -->
				<input class="browser-default" type="number" name="" id="__cantidad" min="1" max="15" disabled>
			</div>
		</div>
		<div id="__datosprod" hidden></div>
	</div>
</div>

<div class="container center" id="add_container">
	<a class="waves-effect waves-light btn-large shop red lighten-1" id="add"><i class="material-icons right">add_shopping_cart</i>Agregar al carrito</a>
</div>



<div class="row roboto" id="cart_row" hidden>
	<div class="row get_out">
		<div class="left">
			<a href="#!" class="btn-large red lighten-2" id="return"><i class="material-icons">keyboard_return</i></a>
		</div>
	</div>
	<!-- antes era col s12 m12 l4 xl5 -->
	<div class="col s12 m12 l12" id="div_tabla_pedidos">
		<!-- <div class="col l6 m10 offset-m1 s12"> -->
			<div class="center"><h4 class="fuente">Tu pedido</h4></div>
			<table id="pedidos_cliente" class="content-table centered z-depth-4">
				<thead>
					<tr>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Borrar</th>
					</tr>
				</thead>
				<tbody>
					<td colspan="4">Aún no has agregado ningún producto.</td>
				</tbody>
			</table>

			<hr>
			<div class="row" align="right">
				<!-- <div class="col m6 offset-m6 s4 offset-s6"> -->
					<div class="neon" >Subtotal: <label id="total_ped" class="neon">0.00 Bs</label></div>
				<!-- </div> -->
			</div>
		<!-- </div> -->
	</div>

	<div class="center">
		<a class="waves-effect waves-light btn btn-large modal-trigger" id="mod_ubi" href="#modal_ubi">PEDIR!</a>
	</div>
</div>


</body>
</html>


<script type="text/javascript" src="js/viewpdf.js"></script>
<script>
	$(document).ready(function(){
    	$('.sidenav').sidenav();
    	$('select').formSelect();
    	$('input[type="number"]').niceNumber({
			autoSize: true,
			autoSizeBuffer: 1,
			buttonDecrement: "-",
			buttonIncrement: "+",
			buttonPosition: 'around'
		});

		$.ajax({
		  url: "recursos/catalogos/last-pdf.php",
		  method: "GET",
		  success: function(response) {
		  	response = JSON.parse(response)
		 		console.log(response.ruta);
		 		load_pdf(response.ruta);
		  }
		})

		$('#search_data').autocomplete({
      source: "recursos/catalogos/search_data.php",
      minLength: 3,
      select: function(event, ui)
      {
        // $("#id_").val(ui.item.id)
        // $("#linea_").val(ui.item.linea)
        // $("#pupesos_").val(parseFloat(ui.item.pupesos).toFixed(1))
        // $("#codli_").val(ui.item.codli)
        // console.log(ui.item.id)
        $("#__datosprod").html("<input id='__datosp' cp='"+ui.item.value+"' np='"+ui.item.id+"' pp='"+ui.item.pupesos+"' fp='"+ui.item.foto+"' hidden/>");
        $('#search_data').val(ui.item.value)
        // $('#foto_prod').attr("src", ui.item.foto);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item.id)
        .append(item.label)
        .appendTo(ul);
    };

  });

var reg_pedidos = new Array();

document.getElementById('add').addEventListener('click', () => {
	$("#cart i").html('<img style="max-height: 40px;" src="images/icons/lleno.png"/>');

	// console.log(reg_pedidos.length)
	// let c_sell = $("#current_sell").val()
	// let c_stock = $("#current_stock").val()
	var cantp = $("#__cantidad").val();
	// let disp = parseInt(c_stock) - parseInt(c_sell)

	// if (disp < cantp) {
		// return M.toast({html: "Cantidad solicitada insuficiente en stock, "+disp+" disponible."})
	// }else{
		M.toast({html: "Agregado al carrito de compra."})
	// }

	var cp = $("#__datosp").attr("cp");
	var np = $("#__datosp").attr("np");
	var pp = $("#__datosp").attr("pp");
	var fp = $("#__datosp").attr("fp");
	
	if (parseInt(cantp) > 50 || cantp == "") {M.toast({html: "El pedido no puede superar las 15 unidades"})}
		else{
	if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."})}
	else{
		pp = parseInt(pp)*parseInt(cantp);
		
		reg_pedidos[cp] = [cp, np, cantp, pp, fp];
		//borrando tabla
		// $('#pedidos_cliente tr:not(:first-child)').slice(0).remove();
		// var table = $("#pedidos_cliente")[0];
		// console.log($("#pedidos_cliente tbody"))
		$("#pedidos_cliente tbody").html("")
		var table = $("#pedidos_cliente tbody")[0];

		total =  0;
		//llenando tabla
		// reg_pedidos = reg_pedidos.filter(Boolean)
		// let json_pedi = JSON.stringify(reg_pedidos)
		// console.log(json_pedi)
		// console.log(reg_pedidos.length)
		console.log(reg_pedidos.length)
		console.log(reg_pedidos)

		reg_pedidos.forEach(function (valor) {
			console.log(".....")
			var row = table.insertRow(-1);
			row.insertCell(0).innerHTML = "<a style='text-decotarion: none; cursor: pointer; color: red;' onclick='borr_pla("+valor[0]+")'><i class='material-icons prefix'>delete</i></a>";
			row.insertCell(0).innerHTML = valor[3];
			row.insertCell(0).innerHTML = valor[2];
			row.insertCell(0).innerHTML = valor[1];
			total  = parseInt(total) + parseInt(valor[3]);
		});
		$("#total_ped").html(total +" Bs.");
		// $("#shop_button").addClass('pulse');
		// $("#modal2").modal('close');
	}}

});

document.getElementById('cart').addEventListener('click', () => {
	// console.log("mostrar")
	// M.toast({html: "Agregado al carrito de compras."})
	document.getElementById('add_container').hidden = true
	document.getElementById('form_container').hidden = true
	document.getElementById('pdf_container').hidden = true
	document.getElementById('cart_row').hidden = false
	document.getElementById('menu').hidden = true
});

document.getElementById('return').addEventListener('click', () => {
	// console.log("ocultar")
	// M.toast({html: "Agregado al carrito de compras."})
	document.getElementById('add_container').hidden = false
	document.getElementById('form_container').hidden = false
	document.getElementById('pdf_container').hidden = false
	document.getElementById('cart_row').hidden = true
	document.getElementById('menu').hidden = false
});



	// document.getElementById("openPDF_").addEventListener('click', () => {
	// 	$.ajax({
	// 	  url: "recursos/catalogos/last-pdf.php",
	// 	  method: "GET",
	// 	  success: function(response) {
	// 	  	response = JSON.parse(response)
	// 	 		console.log(response.ruta);
	// 	 		// load_pdf(response.ruta);
	// 	 		prueba();
	// 	  }
	// 	})
	// })

// CÓDIGO PARA ENVIAR CATÁLOGOS A PHP
	// $("#load_pdf").on("submit", function(e){
 //    e.preventDefault(); 
 //    var data = new FormData(document.getElementById("load_pdf"));
 //    $.ajax({
 //      url: "recursos/catalogos/load-pdf.php",
 //      type: "POST",
 //      dataType: "HTML",
 //      data: data,
 //      cache: false,
 //      contentType: false,
 //      processData: false
 //    }).done(function(echo){

 //    	if (echo) {
 //    		M.toast({html: "Catálogo agregado con éxito."})
 //    	}
 //    	if (echo == "2") {
 //    		M.toast({html:"Debe seleccionar un archivo."})
 //    	}
 //    	if (echo == "3") {
 //    		M.toast({html: "Solo se permite el formato PDF."})
 //    	}

 //        // $("#cuerpo").load("templates/productos/productos.php"+echo);

 //    });
	// });


</script>
