<?php 
require("../../recursos/sesiones.php");
require("../../recursos/conexion.php");
session_start();

$gestion = $_GET['ges'];
$periodo = $_GET['per'];
if ($periodo == "6") {
	$per_a = "per".$periodo;
	$per_a = $gestion.$_SESSION[$per_a];
	$gestion = (int)$gestion+1;
	$per_b = "per1";
	$per_b = $gestion.$_SESSION[$per_b];
}else{

	$per_a = "per".$periodo;
	$per_a = $gestion.$_SESSION[$per_a];
	// $gestion = (int)$gestion+1;
	$periodo = (int)$periodo+1;
	$per_b = "per".$periodo;
	$per_b = $gestion.$_SESSION[$per_b];

}
	$result = $conexion->query("SELECT a.codc, a.ci_usu, b.nombre, b.apellidos, a.fecha, a.totalsd, a.totalcd, a.descuento, a.valor_pesos FROM compras a, usuarios b WHERE (fecha BETWEEN '".$per_a."' AND '".$per_b."') AND a.ci_usu = b.CI AND a.estado = 1");
	if((mysqli_num_rows($result))>0){
	  while($arr = $result->fetch_array()){ 
	        $fila[] = array('codc'=>$arr['codc'], 'ci_usu'=>$arr['ci_usu'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'fecha'=>$arr['fecha'], 'totalsd'=>$arr['totalsd'], 'totalcd'=>$arr['totalcd'], 'descuento'=>$arr['descuento'], 'valor'=>$arr['valor_pesos']); 
	  }
	}else{
	        $fila[] = array('codc'=>'--', 'ci_usu'=>'--', 'nombre'=>'--', 'apellidos'=>'--', 'fecha'=>'--', 'totalsd'=>'--', 'totalcd'=>'--', 'descuento'=>'--', 'valor'=>'--');
	}

?>

<h3 class="fuente">Reporte de compras</h3>
<table id="tabla1">
	<thead>
		<tr>
			<th>Código</th>
			<th>C.I.</th>
			<th>Nombres</th>
			<th>Fecha de <br>compra</th>
			<th>Total sin <br>descuento</th>
			<th>Total con <br>descuento</th>
			<th>Descuento</th>
			<th>Valor de <br>cambio</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($fila as $a  => $valor){ ?>
		<tr>
			<td><?php echo $valor['codc']?></td>
			<td><?php echo $valor['ci_usu']?></td>
			<td><?php echo $valor['nombre']." ".$valor['apellidos']?></td>
			<td><?php echo $valor['fecha']?></td>
			<td><?php echo $valor['totalsd']?></td>
			<td><?php echo $valor['totalcd']?></td>
			<td><?php echo $valor['descuento']." %"?></td>
			<td><?php echo $valor['valor']." Bs."?></td>
		</tr>
	    <?php } ?>
	</tbody>
</table>

<script>
	    
$(document).ready(function() {
	$('#tabla1').dataTable( {
        "order": [[ 0, "desc" ]]
    });
})
</script>