<?php
require('recursos/conexion.php');
session_start();
$suc = $_SESSION['sucursal'];

$Sql = "SELECT a.nombre_cli, a.apellidos_cli, c.modelo, a.fecha, b.cantidad, c.precio_ref, (c.precio_ref*b.cantidad) AS cantidadprecio FROM venta a, detalle b, productos c WHERE a.id = b.id_venta and c.id = b.idpro and a.sucursal = ".$suc; 
$Busq = $conexion->query($Sql); 

while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('nombre'=>$arr['nombre_cli'], 'apellidos'=>$arr['apellidos_cli'], 'prod'=>$arr['modelo'], 'fecha'=>$arr['fecha'], 'cant'=>$arr['cantidad'], 'precio'=>$arr['precio_ref'], 'cantpre'=>$arr['cantidadprecio']);  
    } 



?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>PRODUCTOS VENDIDOS</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }


table.highlight > tbody > tr:hover {
  background-color: #a0aaf0 !important;
}

#tabla1{
  border-collapse: separate;
  border-radius: 5px;
  border-spacing: 1px;
  border: solid;
  border-color: #1f1f1f;
}

.fijo{
  position: fixed !important;
  right: 10px;
  bottom: 5%;
  max-width: 230px;
  z-index: 10 !important;
  width: 230px;

}
.fijo:hover{
  background: #ffffff;
  margin-right:40px;
}
#tabla2{
  border-collapse: collapse;
  border-spacing: 0px;
  border: solid;
  border-color: #000000;
}


.filas_tabla {

   text-align: left;
   vertical-align: top;
   border: 0px solid #000;
   border-collapse: collapse;
   padding: 0em;
  
}
  </style>
</head>
<body>
<div class="row">
<div class="col s11">

<span class="fuente col s12">
  <div class="col s4"><h3>Productos vendidos</h3></div><br>
  <div class="col s3 offset-s1"><a onclick="abrir_mcalculo();" class="modal-action modal-close waves-effect waves-red btn red">Calcular total/fecha</a></div>
</span>

<!-- TABLA -->

<table id="tabla1" class="highlight">
  <thead>
    <tr>

        <th data-field="price">Fecha de venta</th>
        <th data-field="id">Cliente</th>
        <th data-field="price">Producto</th>
        <th data-field="price">Cantidad</th>
        <th data-field="price">Precio unitario</th>
        <th data-field="price">Total</th>
       

    </tr>
  </thead>

  <tbody>
  <?php foreach($fila as $a  => $valor){ ?>
    <tr>

      <td><?php echo $valor["fecha"] ?></td>
      <td><?php echo $valor["nombre"] ?> <?php echo $valor["apellidos"]?></td>
      <td><?php echo $valor["prod"] ?></td>
      <td><?php echo $valor["cant"] ?></td>
      <td><?php echo $valor["precio"] ?> Bs.</td>
      <td><?php echo round($valor["cantpre"],2) ?> Bs.</td>
    </tr>
  <?php } ?>  
  </tbody>
</table>

<!--MODAL PARA RECIBIR MENSAJES DESDE PHP-->  
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div id="mensaje" class="modal-content">

    </div>
    <div class="modal-footer row">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>

<!--MODAL PARA CALCULAR TOTAL/FECHA-->
<div class="row">
  <div id="modal6" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">Ingrese la fecha.</h4>
    <label>Para generar los datos de un solo día utilice solamente el primer selector. (Fecha inicio)</label>
    <br><br><br>
      <div class="row">
        <form class="col s12" id="fecha_cal">
          <div class="col s4">
            <label>Fecha inicio</label>
            <div class="input-field">
              <input type="date" name="fecha_ini" id="fecha_ini">
            </div>
          </div>
          <div class="col s4 offset-s3">
          <label>Fecha fin</label>
            <div class="input-field">
              <input type="date" name="fecha_fin" id="fecha_fin">
            </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>

          </div>
        </form>
        <br><br>
      <div id="contenido_total">
        
      </div>

      </div>

    </div>
  </div>
</div>

<script>
  function abrir_mcalculo() {
    $("#fecha_ini").val("");
    $("#fecha_fin").val("");
    $('#modal6').openModal();

  }

$("#modal6").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("fecha_cal"));
    // var inicio = $("#fecha_ini").val();
    // var fin = $("#fecha_fin").val();

    $.ajax({
      url: "recursos/calcular_total.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        $("#contenido_total").html(echo);


      }
    });
});


var mensaje = $("#mensaje");
mensaje.hide();

$(document).ready(function() {
    $('#tabla1').dataTable( {
        "order": [[ 0, "desc" ]]
    } );
});


</script>

</div>
</div>
</body>
</html>
