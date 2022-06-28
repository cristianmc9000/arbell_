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

<script>
	$(document).ready(function() {
		$("#titulo").html('Reportes');

		fetch('recursos/catalogos/reportes.php')
			.then(response => {
				response.json().then(res => {
					// console.log(res)
					let cad = "";
					res.forEach(function(item, index, res){
						cad = cad + `<tr><td>${item.ca}</td><td>${item.experta}</td><td>${item.cant}</td><td>${parseFloat(item.total).toFixed(1)} Bs.</td></tr>`
					})
					// console.log(cad)
					document.getElementById('tabla_reportes').children[1].innerHTML = cad;
				})
			})

	});

 		    

</script>