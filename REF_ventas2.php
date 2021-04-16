
<?php
$pagi = $_GET['pagi']; 
$contar_pagi = (strlen($pagi));    // Contamos el numero de caracteres 
// Numero de registros por pagina 
$numer_reg = 10; 
require('recursos/conexion.php');
//$nombre_tabla = $tabla_db1; 

// Contamos los registros totales 
$Sql0 = "SELECT a.id, b.CI, b.nombre as nc, b.apellidos as ac, a.total, a.fecha FROM `venta` a, `clientes` b WHERE b.nombre = a.nombre_cli and b.apellidos = a.apellidos_cli and a.estado=1"; 
$result0 = $conexion->query($Sql0) or die(mysql_error());   // Esta linea hace la consulta 
    //$result0 = mysql_query($query0) or die(mysql_error());  
    $numero_registros0 = mysqli_num_rows($result0);  

############################################## 
// ----------------------------- Pagina anterior 
$prim_reg_an = $numer_reg - $pagi; 
$prim_reg_ant = abs($prim_reg_an);        // Tomamos el valor absoluto 

if ($pagi <> 0)  
{  
$pag_anterior = "<a href='ventas2.php?pagi=$prim_reg_ant'>Pagina anterior</a>"; 
} 
// ----------------------------- Pagina siguiente 
$prim_reg_sigu = $numer_reg + $pagi; 

if ($pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$pag_siguiente = "<a href='ventas2.php?pagi=$prim_reg_sigu'>Pagina siguiente</a>"; 
} 
// ----------------------------- Separador 
if ($pagi <> 0 and $pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$separador = "|"; 
} 
// Creamos la barra de navegacion 

$pagi_navegacion = "$pag_anterior $separador $pag_siguiente"; 

// ----------------------------- 
############################################## 

if ($contar_pagi > 0)  
{  
// Si recibimos un valor por la variable $page ejecutamos esta consulta 

    $Sql = "SELECT a.id, b.CI, b.nombre as nc, b.apellidos as ac, a.total, a.fecha FROM `venta` a, `clientes` b WHERE b.nombre = a.nombre_cli and b.apellidos = a.apellidos_cli and a.estado=1 LIMIT $pagi,$numer_reg"; 
}  
else  
{  
// Si NO recibimos un valor por la variable $page ejecutamos esta consulta 

    $Sql = "SELECT a.id, b.CI, b.nombre as nc, b.apellidos as ac, a.total, a.fecha FROM `venta` a, `clientes` b WHERE b.nombre = a.nombre_cli and b.apellidos = a.apellidos_cli and a.estado=1 LIMIT 0,$numer_reg"; 
}  

    $result = $conexion->query($Sql) or die(mysql_error());   // Esta linea hace la consulta 
    //$result = mysql_query($query);  
    $numero_registros = mysqli_num_rows($result);  


$_SESSION['fil'] = array(); 
$Sql2 = "SELECT a.modelo, b.imei, d.id FROM productos a, detalle b, prodime c, venta d WHERE b.imei = c.imei and a.id = c.id and d.id = b.id_venta"; 
$Busq2 = $conexion->query($Sql2); 
while($arr2 = $Busq2->fetch_array()) 
    { 
        $fila2[] = array('modelo'=>$arr2['modelo'], 'imei'=>$arr2['imei'], 'id'=>$arr2['id']); 
        array_push($_SESSION['fil'], $fila2); 
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    color: red;
  }


  </style>
</head>
<body>
<div class="row">
<div class="col s11">

<span class="fuente"><h3>Registro de ventas</h3></span>

<!-- TABLA -->

<table id="tabla1" class="highlight">
  <thead>
    <tr>

        <th data-field="price">CI Cliente</th>
        <th data-field="id">Nombre cliente</th>

        <th data-field="price">Monto total</th>
        <th data-field="price">Fecha de venta</th>
        <th data-field="price">Modificar</th>
        <th data-field="price">Borrar</th>
        <th data-field="price">Ver Venta</th>
    </tr>
  </thead>

  <tbody>
  <?php     while ($registro = mysqli_fetch_array($result)){   ?>
    <tr>

      <td><?php echo $registro["CI"] ?></td>
      <td><?php echo $registro["nc"]." ".$registro["ac"]  ?></td>
      <td><?php echo $registro["total"] ?></td>
      <td><?php echo $registro["fecha"] ?></td>
      <td><a href="#!" onclick="mod_registro('<?php echo $registro['fecha']?>','<?php echo $registro["nc"] ?>','<?php echo $registro["ac"] ?>','<?php echo $registro['id']?>','<?php echo $registro['total']?>')"><i class="material-icons">build</i></a></td>
      <td><a href="#!" onclick="borrar_registro(<?php echo $registro["id"] ?>);"><i class="material-icons">delete</i></a></td>
      <td><a href="#!" onclick="cargar_detalle('<?php echo $registro['fecha']?>','<?php echo $registro["nc"] ?>','<?php echo $registro["ac"] ?>','<?php echo $registro['id']?>','<?php echo $registro['total']?>')" ><i class="material-icons">search</i></a></td>
    </tr>
  <?php } ?>  
  </tbody>
</table>
<?php 
echo " 

<div align='center'>  
  <table border='0' cellpadding='0' cellspacing='0' width='600'> 
    <tr>  
      <td width='600' colspan='4'>&nbsp;</td>  
    </tr> 
    <tr>  
      <td width='600' colspan='4'><p align='right'>Registros: $numero_registros de un total de $numero_registros0</td>  
    </tr> 
   </table>  
</div> 

<p align='center'>$pagi_navegacion</p> 
"; 

?>
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

<!--MODAL VER  REGISTRO-->
<div class="row">
  <div id="modal1" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h5>-- DETALLE DE VENTA --</h5>  
      <p id="ncliente"></p>
      <p id="fecha_detalle"></p>
        <div class="row col s12" >
          <p><b>--- ARTICULO(S) VENDIDO(S) ---</b></p>
            <table id="tabla3" class="highlight" style="border: solid 1px;">
              <thead>
                <tr>
                    <th data-field="modelo" >modelo</th>
                    <th data-field="imei" >imei</th>
                </tr>
              </thead>
              <tbody id="cuerpo_tabla3">

              </tbody>
            </table>
        </div>
        <div class="row col s3 offset-s8">
          <b><p id="subtotal" style="color: blue"></p></b>
        </div><br>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-red btn red">Cerrar</a>
        </div>
    </div>
  </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="row">
  <div id="modal4" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h5>-- DETALLE DE VENTA --</h5>  
      <p id="ncliente_mod"></p>
      <p id="fecha_detalle_mod"></p>
        <div class="row col s12" >
          <p><b>--- ARTICULO(S) VENDIDO(S) ---</b></p>
            <table id="tabla3" class="highlight" style="border: solid 1px;">
              <thead>
                <tr>
                    <th data-field="modelo" >modelo</th>
                    <th data-field="imei" >imei</th>
                </tr>
              </thead>
              <tbody id="cuerpo_tabla3_mod">

              </tbody>
            </table>
        </div>
        <div class="row">
          <form class="col s12" id="mod_total">
            <div class="row col s3 offset-s8">
              <b><p id="subtotal_mod" style="color: blue"></p></b>
            </div><br>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
<!--BOTON IMPRIMIR-->
<!--<div class="fijo" id="imprimir" >
  <a href="#" style="color: red;">
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover3.playclip();">
      <img src="img/print.png" >
    </div>
    <div class="card-action">
      IMPRIMIR TABLA
    </div>
  </div>
  </a>
</div>-->


<!--MODAL PARA ELIMINAR REGISTROS-->
<div class="row">
  <div id="modal3" class="modal col s4 offset-s4">
    <div class="modal-content">
    <h4 id="titulobp">¿ESTA SEGURO QUE QUIERE ELIMINAR ESTE REGISTRO DE VENTA? </h4>
    <p id="parrafo"></p>
      <div class="row">
        <form class="col s12" id="borrar_reg">
          <div class="row">
            <div class="input-field col s12" id="contenido_br">

            </div>
          </div>
          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Eliminar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div id="modal5" class="modal col s8 offset-s2">
    <div class="modal-content" id="sel_fecha">

    </div>
  </div>
</div>


<script>



var mensaje = $("#mensaje");
mensaje.hide();

$(document).ready(function() {
    //$('#tabla1').dataTable( {
    //    "order": [[ 3, "desc" ]]
    //} );
    //$('#modal').leanModal();

});


/*$(function() {
  theTable = $("#tabla2");
      $("#q").keyup(function() {
      $.uiTableFilter(theTable, this.value);
  });
});*/
function mod_registro(fecha, nombre, apellido, id, total){
  document.getElementById("ncliente_mod").innerHTML ="<b>Cliente: </b>"+nombre+" "+apellido;
  document.getElementById("fecha_detalle_mod").innerHTML ="<b>Fecha de venta: </b>"+fecha;
  document.getElementById("cuerpo_tabla3_mod").innerHTML ="";

  <?php foreach($fila2 as $a  => $valor){ ?>
        if (<?php echo $valor['id']?> == id){
          var table = document.getElementById("cuerpo_tabla3_mod");
          var row = table.insertRow(0);
          row.insertCell(0).innerHTML = "<?php echo $valor['modelo'] ?>";
          row.insertCell(1).innerHTML = "<?php echo $valor['imei'] ?>";
        }
  <?php } ?>
  document.getElementById("subtotal_mod").innerHTML="Total: <input type='number' name='total_mod' value='"+total+"' required/><input type='text' name='idv_mod' value='"+id+"' hidden/>";
  $("#modal4").openModal(); 
}
$("#mod_total").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("mod_total"));

    $.ajax({
      url: "recursos/modregistro.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("ventas.php");
      }
    });
});

function cargar_detalle(fecha, nombre, apellido, id, total){
  document.getElementById("ncliente").innerHTML ="<b>Cliente: </b>"+nombre+" "+apellido;
  document.getElementById("fecha_detalle").innerHTML ="<b>Fecha de venta: </b>"+fecha;
  document.getElementById("cuerpo_tabla3").innerHTML ="";

  <?php foreach($fila2 as $a  => $valor){ ?>
        if (<?php echo $valor['id']?> == id){
          var table = document.getElementById("cuerpo_tabla3");
          var row = table.insertRow(0);
          row.insertCell(0).innerHTML = "<?php echo $valor['modelo'] ?>";
          row.insertCell(1).innerHTML = "<?php echo $valor['imei'] ?>";
        }
  <?php } ?>
  document.getElementById("subtotal").innerHTML="Total: "+total;
  $("#modal1").openModal();  
}

function borrar_registro(id){
  
  var x=[];
  var cad="";
  <?php foreach($fila2 as $a  => $valor){ ?>
    if(<?php echo $valor["id"] ?> == id){
      x.push('<?php echo $valor["imei"] ?>'); 
    }
  <?php } ?>
  for (var i = 0; i < x.length; i++) {
    cad=cad+'<input type="text" id="'+i+'" name="'+i+'" value="'+x[i]+'" hidden/>';
  }

  document.getElementById("contenido_br").innerHTML= "<b>El / Los productos contenidos en este detalle de venta serán agregados al módulo de ventas.<br> Si desea puede modificar/eliminarlos/VENDERLOS desde la pantalla 'Ventas/PD'.</b><input type='text' id='idreg' name='idreg' value='"+id+"' hidden/>"+cad+"<input type='text' id='cantidad' name='cantidad' value='"+x.length+"' hidden/>";
  $("#modal3").openModal();  
}

$("#borrar_reg").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_reg"));

    $.ajax({
      url: "recursos/borrarregistro.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("ventas.php");
      }
    });
});
</script>

</div>
</div>
</body>
</html>