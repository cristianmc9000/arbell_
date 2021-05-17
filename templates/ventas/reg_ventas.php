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

.borde_tabla{
    border: 1px solid;
    border-collapse: collapse;
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

<!-- Modal registro de venta detalle de venta -->
<div class="row">
    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s4">
                    <span>Código arbell: </span><br>
                    <span>Lider/Experta:</span>
                </div>
                <div class="col s4" style="text-align: center;">
                    <span>Punto de venta: PRINCIPAL</span><br>
                    <span>Forma de pago:</span><br>
                    <span>Periodo:</span>
                </div>
                <div class="col s4" style="text-align:right">
                    <span>Distribuidora: CARMIÑA</span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <p><h5>Items del comprobante</h5></p>
                </div>
            <div class="col s12">
                <table class="borde_tabla">
                    <tr>
                        <th>Código <br> (producto)</th>
                        <th>Linea</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>P. unidad</th>
                        <th>Subtotal</th>
                    </tr>
                </table>
            </div>
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

/* funcion ver venta */
function ver_venta(codv){
$.ajax({
    url: "recursos/ventas/ver_venta.php?codv="+codv,
    method: "GET",
    success: function(response){
        console.log(response);
    }
});
    $("#modal1").openModal();
}
</script>

</body>
</html>