<?php 
require("../../recursos/sesiones.php");
require("../../recursos/conexion.php");
session_start();

$gestion = $_GET['ges'];
$periodo = $_GET['per'];
$ca = $_GET['ca'];

if ($periodo == 0) {
	$result = $conexion->query("SELECT a.ca, b.nombre, b.apellidos, SUM(a.total) AS monto FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."%' AND a.ca = b.CA AND a.estado = 1 AND lider = '".$ca."' GROUP BY a.ca");
	$result2 = $conexion->query("SELECT a.ca, b.nombre, b.apellidos, SUM(a.total) AS monto FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."%' AND a.ca = '".$ca."' AND b.CA = '".$ca."' AND a.estado = 1 GROUP BY a.ca");
}else{
	$result = $conexion->query("SELECT a.ca, b.nombre, b.apellidos, SUM(a.total) AS monto FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."%' AND a.periodo = ".$periodo." AND a.ca = b.CA AND a.estado = 1 AND lider = '".$ca."' GROUP BY a.ca");
	$result2 = $conexion->query("SELECT a.ca, b.nombre, b.apellidos, SUM(a.total) AS monto FROM ventas a, clientes b WHERE a.fecha LIKE '".$gestion."%' AND a.periodo = ".$periodo." AND a.ca = '".$ca."' AND b.CA = '".$ca."' AND a.estado = 1 GROUP BY a.ca");
}

	if((mysqli_num_rows($result))>0){
	  while($arr = $result->fetch_array()){ 
	        $fila[] = array('ca'=>$arr['ca'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'monto'=>$arr['monto']); 
	  }
	}else{
	        $fila[] = array('ca'=>'--', 'nombre'=>'--', 'apellidos'=>'--', 'monto'=>'--');
	}

	if (mysqli_num_rows($result2)>0) {
		$res = $result2->fetch_all(MYSQLI_ASSOC);
	}else{
		$res = $conexion->query("SELECT CA, nombre, apellidos FROM clientes WHERE CA = '".$ca."'");
		$res = $res->fetch_all(MYSQLI_ASSOC);
		$res[0]['monto'] = '0';
	}

	
	// echo $res[0]['nombre'].' '.$res[0]['apellidos'];

?>
<style>
	.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #aaa;
    border-top-width: 1px;
    border-right-width: 1px;
    border-left-width: 1px;
    border-radius: 3px;
    padding: 5px;
    background-color: transparent;
    margin-bottom: 0px;
		margin-left: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
		padding-top: 0px;
		padding-right: 0px;
		border-top-width: 0px;
		border-left-width: 0px;
		border-right-width: 0px;
  }
</style>
<title>reporte de compras</title>
<h3 class="fuente">Reporte de Lider/Experta</h3><br>
<div class="row">
	<div class="col s11">
		<table id="tabla1">
			<thead>
				<tr>
					<th>Código Arbell</th>
					<th>Nombres y apellidos</th>
					<th>Valor de compras en Bs.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fila as $a  => $valor){ ?>
				<tr>
					<td><?php echo $valor['ca']?></td>
					<td><?php echo $valor['nombre']." ".$valor['apellidos']?></td>
					<td><?php echo round(((float)$valor['monto']), 2)?></td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	    
$(document).ready(function() {
	$('#tabla1').dataTable({
      "order": [[ 2, "desc" ]],
      "language": {
	      "lengthMenu": "Registros _MENU_ por página",
	      "zeroRecords": "Lo siento, no se encontraron datos",
	      "info": "Página _PAGE_ de _PAGES_",
	      "infoEmpty": "No hay datos disponibles",
	      "infoFiltered": "(filtrado de _MAX_ resultados)",
	      "paginate": {
	        "next": "Siguiente",
	        "previous": "Anterior"
	      }},
		"dom": 'Bfrtip',
    "buttons":[
      {
        extend:     'excelHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/ms-excel--v1.png"/></i>',
        titleAttr:  'Exportar a Excel',
        className:  'btn-flat green',
        title: 			'Reporte de líder: <?php echo $res[0]["nombre"]." ".$res[0]["apellidos"]; if($_GET["per"] == '0'){echo '\n Periodo: Todos los periodos';}else{echo '\n Periodo: '.$_GET["per"];} ?><?php echo '\n Valor de compras de lider: '.round($res[0]["monto"], 1)." Bs.";?>'
      },
      {
        extend:     'pdfHtml5',
        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
        titleAttr:  'Exportar a PDF',
        className:  'btn-flat red',
        title: 			'Reporte de líder: <?php echo $res[0]["nombre"]." ".$res[0]["apellidos"]; if($_GET["per"] == '0'){echo '\n Periodo: Todos los periodos';}else{echo '\n Periodo: '.$_GET["per"];} ?><?php echo '\n Valor de compras de lider: '.round($res[0]["monto"], 1)." Bs.";?>'
      },
      {
        extend:     'print',
        text:       '<i class="material-icons-outlined">print</i>',
        titleAttr:  'Imprimir',
        className:  'btn-flat blue',
        title: 			'<span style="font-size:20; line-height:1.2em"><b>Reporte del líder</b>: <?php echo $res[0]["nombre"]." ".$res[0]["apellidos"];?><br><?php if($_GET["per"] == '0'){echo '<b>Periodo:</b> Todos los periodos';}else{echo "<b>Periodo:</b> ".$_GET["per"];} ?><br><b>Valor de compras de lider: </b><?php echo round($res[0]["monto"], 1)." Bs."?></span>'
      }
    ]
    });
})
</script>