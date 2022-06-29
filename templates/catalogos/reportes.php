<?php 
// session_start();
// require('../../recursos/conexion.php');
// $ca = $_SESSION['ca'];

// $result = $conexion->query("SELECT * FROM clientes WHERE estado = 1 AND lider = ".$ca);
// $result = $result->fetch_all(MYSQLI_ASSOC);

?>

<style>

</style>

<div class="container">
<br>
	<table id="tabla_reportes" class="content-table centered z-depth-4">
		<thead>
			<tr>
				<th>Código</th>
				<th>Experta</th>
				<th>Items</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody style="font-size: 0.9em">
			<td colspan="4">No existen datos.</td>
		</tbody>
	</table>

</div>

	 <div id="modal_reporte_experta" class="modal roboto">
    <div class="modal-content" >
      <div class="center">
      	<h6 id="modal_title" class="rubik" style=" font-weight: bold;">Datos de experta</h6><br>
      </div>
      <div>
					<table class="det rubik z-depth-4">
						<tr>
							<th width="20%">Experta:</th>
							<td><span id="mr_experta"></span></td>
						</tr>
						<tr>
							<th width="20%">CA:</th>
							<td><span id="mr_ca"></span></td>
						</tr>
						<tr>
							<th >CI:</th>
							<td><span id="mr_ci"></span></td>
						</tr>
						<tr>
							<th>Celular:</th>
							<td><span id="mr_celular"></span></td>
						</tr>
						<tr>
							<th>Dirección:</th>
							<td><span id="mr_dir"></span></td>
						</tr>
					</table>
    	</div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn right">Aceptar</a>
    </div>
  </div>


<script>
	$(document).ready(function() {
		$("#titulo").html('Reportes');
		$('.modal').modal();

		fetch('recursos/catalogos/reportes.php')
			.then(response => {
				response.json().then(res => {
					// console.log(res)
					let cad = "";
					res.forEach(function(item, index, res){
						cad = cad + `<tr><td><a href="#" onclick="datos_experta('${item.ca}', '${item.experta}','${item.CI}', '${item.telefono}', '${item.lugar}')">${item.ca}</a></td><td>${item.experta}</td><td>${item.cant}</td><td>${parseFloat(item.total).toFixed(1)} Bs.</td></tr>`
					})
					// console.log(cad)
					document.getElementById('tabla_reportes').children[1].innerHTML = cad;
				})
			})

	});

	function datos_experta(ca, experta, ci, telf, lugar) {
		let instance = M.Modal.getInstance(document.getElementById('modal_reporte_experta'))
		document.getElementById('mr_experta').innerHTML = experta
		document.getElementById('mr_ca').innerHTML = ca
		document.getElementById('mr_ci').innerHTML = ci
		document.getElementById('mr_celular').innerHTML = telf
		document.getElementById('mr_dir').innerHTML = lugar
		instance.open();
	}
 		    

</script>