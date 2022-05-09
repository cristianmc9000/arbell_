<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();
date_default_timezone_set("America/La_Paz");
$year = date('Y');
if (isset($_GET["ges"])) {
  $year = $_GET["ges"];
}

$Sql = "SELECT a.id, a.ca, CONCAT(c.nombre,' ',c.apellidos) as cliente, a.fecha, a.total, a.descuento, a.valor_peso, a.credito, a.periodo FROM pedidos a, clientes c WHERE a.ca = c.CA AND a.estado = 2 AND a.fecha LIKE '".$year."%'";

// $_SESSION['periodo'] = $per;
//consulta tabla inventario

$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()){ 
        $fila[] = array('id'=>$arr['id'], 'ca'=>$arr['ca'], 'cliente'=>$arr['cliente'], 'fecha'=>$arr['fecha'], 'total'=>$arr['total'], 'descuento'=>$arr['descuento'], 'valor_peso'=>$arr['valor_peso'], 'credito'=>$arr['credito'], 'periodo'=>$arr['periodo']); 
    }
}else{
        $fila[] = array('id'=>'---', 'ca'=>'---', 'cliente'=>'---', 'fecha'=>'---', 'total'=>'---', 'descuento'=>'---', 'valor_peso'=>'---', 'credito'=>'---', 'periodo'=>'---');
}
?>

<style>
.fuente{
    color: red;
}
.fuente_azul{
    color: black;
}
</style>

<div class="row">
<div class="col s11">
<div class=" col s4 ">
    <div class="col s3">
        <b style= "color:blue"> Gestión:</b>
        <select onchange="enviarfecha()" name="ges" id="ges" class="browser-default">
            <option value="<?php echo $year ?>" selected disabled><?php echo $year?></option>
            <option value="2022"> 2022 </option>
            <option value="2023"> 2023 </option>
            <option value="2024"> 2024 </option>
            <option value="2025"> 2025 </option>
            <option value="2026"> 2026 </option>
            <option value="2027"> 2027 </option>

            <!-- <option> Todos </option> -->
        </select>
    </div>
</div>
<div class="col s7">
<span class="fuente">
    <h3>
        Registro de pedidos: Gestión - <?php echo $year;?>
    </h3>

</span>
</div>

<!-- TABLA -->
<table id="tabla1" class="highlight centered">
    <thead>
        <tr>
            <th>Código</th>
            <th>CA</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Periodo</th>
            <th>Tipo pago</th>
            <th>Total</th>

            <!-- <th>Imprimir</th> -->
        </tr>
    </thead>

<tbody>
    <?php foreach($fila as $a  => $valor){ ?>
        <tr >
            <td><?php echo $valor["id"] ?></td>
            <td><?php echo $valor["ca"]?></td>
            <td><?php echo $valor["cliente"]?></td>
            <td><?php echo $valor["fecha"]?></td>
            <td><?php echo $valor["periodo"] ?></td>
            <td><?php if($valor["credito"] == '1'){echo 'Crédito';}else{echo 'Contado';} ?></td>
            <td><?php echo $valor["total"]?> Bs.</td>


            <!-- <td> -->
            <!-- <a href="#!" onclick="borrar_inventario('<?php echo $valor['id'] ?>');"><i class="material-icons">print</i></a> -->
            <!-- </td> -->

        </tr>
    <?php } ?>  
</tbody>
</table>

<!--MODAL MODIFICAR INVENTARIO-->
<div class="row">
<div id="modal2" class="modal col s4 offset-s4">
  <div class="modal-content fuente fuente_azul" >
    <h4>Modificar producto</h4>  
    <div class="row">
        <form class="col s12" id="modificar_inventario">
            <div class="row">
                <div  class="input-field col s6">
                    <input name="pupesos" id="pup" onkeypress="return check(event)" type="text" required>
                    <label class="active" for="pupesos">P.U. (pesos arg.):</label>
                    <input type="text" id = "codigo" name= "id" hidden>
                </div>
            <div class="input-field col s6">
                <input name="pubs" onkeypress="return check(event)" id="pub" type="text" required>
                <label class="active" for="pubs">P.U. (Bs.):</label>
                </div>
            </div>
            <div class="row">  
                <div class="input-field col s6">
                <input id="cantidad" name="cantidad" type="number" required>
                <label class="active" for="cantidad">Cantidad: </label>
                <input type="text" id="cant_ant" name="cant_ant" hidden>
            </div>
            <div class="input-field col s6">
                <input id="fechav" name = "fechav" type="date">
                <label class="active" for="first_name">Fecha de vencimiento</label>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>



<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal3" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar Producto</b></h4>  
    <p>¿Esta seguro que desea eliminar este producto del inventario?</p>
    <div class="row">
      <form class="col s12" id="eliminar_inventario">
          <div class="row">
            <div class="input-field col s6" >
              <input id="datos_borrar" name="id" type="text" hidden>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>


<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
    <div id="mensaje" class="modal-content" hidden>

<script>

var mensaje = $("#mensaje");
$(document).ready(function() {
    $('#tabla1').dataTable({
        "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "Lo siento, no se encontraron datos",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay datos disponibles",
        "infoFiltered": "(filtrado de _MAX_ resultados)",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
        }
    });
});



//funcion periodo
function enviarfecha() {
    ges = $('#ges').val();
    $("#cuerpo").load("templates/pedidos/reg_pedidos.php?ges="+ges);
}

</script>

</div>
</div>






















<!-- FALTA CREAR EL MODAL CON DETALLE DE PEDIDO Y OPCION DE ACEPTAR PEDIDO PARA LUEGO REGISTRARLO EN LA TABLA VENTAS. -->