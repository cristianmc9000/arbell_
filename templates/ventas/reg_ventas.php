<?php
require('../../recursos/conexion.php');
$Sql = "SELECT a.codv, b.nombre, b.apellidos, a.fecha, a.total, a.credito FROM ventas a, clientes b WHERE a.ca = b.CA AND a.estado = 1"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('codv'=>$arr['codv'], 'nombre'=>$arr['nombre'],'apellidos'=>$arr['apellidos'],'fecha'=>$arr['fecha'],'total'=>$arr['total'],'credito'=>$arr['credito']); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>.fuente {
    font-family: 'Segoe UI light';
    color: red;
}
table.highlight>tbody>tr:hover {
    background-color: #a0aaf0 !important;
}
</style>

</head>
<body>
<span class="fuente"><h3>Registro de ventas</h3>
</span>

<!-- TABLA -->
<table id="tabla1" class="highlight">
    <thead>
        <tr>
            <th>Código</th>
            <th>Lider/Experta</th>
            <th>Fecha de Venta</th>
            <th>Monto Total</th>
            <th>Tipo de Venta</th>
            <th>Ver</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
        <tr>
            <td>
                <?php echo $valor["codv"] ?>
            </td>
            <td>
                <?php echo $valor["nombre"]." ".$valor["apellidos"] ?>
            </td>
            <td>
                <?php echo $valor["fecha"]?>
            </td>
            <td>
                <?php echo $valor["total"]?>
            </td>
            <td>
                <?php if($valor["credito"] == "0"){echo "Contado";} else{echo "Crédito";} ?>
            </td>

            <td>
                <a href="#!" onclick="ver_venta('<?php echo $valor['codv']?>')"><i class="material-icons">visibility</i></a> 
                <!-- <a href="#!"><i class="material-icons">build</i></a> -->
            </td>
            <td>
                <!-- <a href="#!" onclick="borrar_producto('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a> -->
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<!-- MODAL DATOS -->
<div class="row">
    <div id="modal1" class="modal col s4 offset-s4">
        <div class="modal-content">
            <h4>Agregar usuario</h4>
            <div class="row">
                <form id="agregar_usuario" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input name="ci" type="text" class="validate">
                            <label for="ci">Cédula de Identidad:</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="mensaje"></div>


<!-- -----------------CRUD DE USUARIOS------------------------ -->
<script>
$(document).ready(function() {
    $('#tabla1').dataTable();
    $('#modal').leanModal();
});
var mensaje = $("#mensaje");
mensaje.hide();
</script>

</body>
</html>