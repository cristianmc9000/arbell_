

<?php
require('../../recursos/conexion.php');


// SELECT b.modelo, b.precio_ref, c.cantidad FROM venta a, productos b, detalle c WHERE a.id = c.id_venta and c.idpro = b.id
session_start();
$suc = $_SESSION['sucursal'];


$mes = $_GET["mes"];
$anio = $_GET["anio"];

$Sql = "SELECT a.id, b.CI, b.nombre as nc, b.apellidos as ac, a.total, a.fecha FROM `venta` a, `clientes` b WHERE b.id = a.id_cli and a.sucursal = ".$suc." and a.estado=1 and a.fecha LIKE '".$anio."-".$mes."-%'"; 
$Busq = $conexion->query($Sql); 


if((mysqli_num_rows($Busq))>0){
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'ci'=>$arr['CI'], 'nombrec'=>$arr['nc'], 'apellidoc'=>$arr['ac'], 'total'=>$arr['total'], 'fecha'=>$arr['fecha']); 
    }}else{
  $fila[] = array('id'=>'--','ci'=>'--','nombrec'=>'--','apellidoc'=>'--','total'=>'--','fecha'=>'--');
}


// $Sql2 = "SELECT a.modelo, b.imei, d.id FROM productos a, detalle b, prodime c, venta d WHERE b.imei = c.imei and a.id = c.id and d.id = b.id_venta"; 
    $Sql2 = "SELECT a.id, c.idpro, b.modelo, b.precio_ref, c.cantidad FROM venta a, productos b, detalle c WHERE a.id = c.id_venta and c.idpro = b.id";
$Busq2 = $conexion->query($Sql2); 
while($arr2 = $Busq2->fetch_array()) 
    { 
        $fila2[] = array('id'=>$arr2['id'], 'idp'=>$arr2['idpro'], 'modelo'=>$arr2['modelo'], 'precio'=>$arr2['precio_ref'], 'cantidad'=>$arr2['cantidad']); 
    } 

?>


<html>
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    color: red;

  }
  .fuente_azul{
    color: black;
  }

  </style>
</head>
<body>
<div class="row">
<div class="col s11">


<span class="fuente col s12">
  <div class="col s4"><h3>Registro de ventas</h3></div><br>
  <div class="col s3 offset-s1"><a onclick="abrir_mcalculo();" class="modal-action modal-close waves-effect waves-red btn red">Calcular total/fecha</a></div>
</span>

<!-- TABLA -->
<table id="tabla1" class="highlight">
  <thead>
    <tr>
        <th>Fecha de venta</th>
        <th>Cliente</th>
        <th>Total</th>

        <th>Modificar</th>
        <th>Borrar</th>
        <th>Detalle</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach($fila as $a  => $valor){ ?>
    <tr>

      <td><?php echo $valor["fecha"] ?></td>
      <td><?php echo $valor["nombrec"]." ".$valor["apellidoc"]  ?></td>
      <td><?php echo $valor["total"] ?> Bs.</td>

      <td><a href="#!" onclick="mod_registro('<?php echo $valor['fecha']?>','<?php echo $valor['nombrec'] ?>','<?php echo $valor['apellidoc'] ?>','<?php echo $valor['id']?>','<?php echo $valor['total']?>')"><i class="material-icons">build</i></a></td>
      <td><a href="#!" onclick="borrar_registro(<?php echo $valor['id'] ?>);"><i class="material-icons">delete</i></a></td>
      <td><a href="#!" onclick="cargar_detalle('<?php echo $valor['fecha']?>','<?php echo $valor['nombrec']?>','<?php echo $valor['apellidoc'] ?>','<?php echo $valor['ci'] ?>','<?php echo $valor['id'] ?>','<?php echo $valor['total']?>')" ><i class="material-icons">search</i></a></td>
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

<!--MODAL VER  REGISTRO-->
<div class="row">
  <div id="modal1" class="modal col s4 offset-s4">
    <div class="modal-content">
      <div id = "impresion_1">
      <h5>-- DETALLE DE VENTA --</h5>  
      <br>
      <p id="ncliente"></p>
      <p id="ci_detalle"></p>
      <p id="fecha_detalle"></p>

        <div class="row col s12" >
          <p><b>--- ARTICULO(S) VENDIDO(S) ---</b></p>
            <table id="tabla3" class="col s12 highlight" style="border: solid 1px;">
              <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Bs.</th>
                    <th>Cantidad</th>
                </tr>
              </thead>
              <tbody id="cuerpo_tabla3">

              </tbody>
            </table>
        </div>
        <div class="row col s3 offset-s8">
          <b><p id="subtotal" style="color: blue"></p></b>
        </div><br>
        </div>
        <div class="modal-footer">
          <a href="#!" onclick="printContent('impresion_1');" class="modal-action modal-close waves-effect waves-red btn blue left">imprimir</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-red btn red">Cerrar</a>
        </div>
    </div>
  </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="row">
  <div id="modal4" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h5>MODIFICAR DETALLE DE VENTA</h5>  
      <p id="ncliente_mod"></p>
      <p id="fecha_detalle_mod"></p>
        <div class="row col s12" >
          <p><b>--- ARTICULO(S) VENDIDO(S) ---</b></p>
            <table id="tabla3" class="highlight" style="border: solid 1px; font-size: 11px;">
              <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th class='col s5 offset-s4'>Cantidad</th>
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

<!--MODAL PARA CALCULAR TOTAL/FECHA-->
<div class="row">
  <div id="modal6" class="modal col s6 offset-s3">
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

$(document).on('change', ".cant_ven", function(){
 
  var total = 0;
  $('.cant_ven').each(function(){
    var cant = $(this).val();
    var precio = $(this).attr('precio');
    total = total+(cant*precio);
  })

  total = parseFloat(total);
  total = total.toFixed(2);
  $("#total_mod").val(total);
 });

$("#mod_total").on("submit", function(e){
  e.preventDefault();
  var formData = new FormData();
  var id_venta = $("#idv_mod").val();
  var fecha_venta = $("#fecha_mod").val();
  var total = $("#total_mod").val();

  var cants=[];
  var idc=[];
  $('.cant_ven').each(function(){
    var cant = $(this).val();
    var id_p = $(this).attr('idc');
    cants.push(cant);
    idc.push(id_p);
  })

  var x="";
  var y="";

      for (var i = 0; i < idc.length; i++){
        // x=x+"&"+i+"="+idc[i];
        // y=y+"&"+i+"c="+cants[i];
        formData.append(i+"", ""+idc[i]);
        formData.append(i+"c", ""+cants[i]);
      }
      formData.append("eid", ""+id_venta);
      formData.append("efecha", ""+fecha_venta);
      formData.append("etotal", ""+total);
      formData.append("ecantidad", ""+idc.length);
      // misdatos="&eid="+id_venta+"&efecha="+fecha_venta+"&etotal="+total+x+y+"&ecantidad="+idc.length;

    $.ajax({
      url: "recursos/modregistro.php",
      type: "POST",
      dataType: "HTML",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        if(echo.includes("closeModal")){
          $("#cuerpo").load("ventas.php?anio=<?php echo $anio ?>&mes=<?php echo $mes ?>");
        }
        
      }
    }); 
});



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

function printContent(el) {

  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;


  document.body.innerHTML = printcontent;
   $("#modal1").closeModal();
  window.print();
  document.body.innerHTML = restorepage;

    
    $("#cuerpo").load("ventas.php?anio=<?php echo $anio ?>&mes=<?php echo $mes ?>");
   
}

var mensaje = $("#mensaje");


$(document).ready(function() {
    $('#tabla1').dataTable( {
        "order": [[ 0, "desc" ]]
    } );
    $('.modal').modal();

});



function mod_registro(fecha, nombre, apellido, id, total){
  document.getElementById("ncliente_mod").innerHTML ="<b>Cliente: </b>"+nombre+" "+apellido;
  document.getElementById("fecha_detalle_mod").innerHTML ="<b>Fecha de compra: </b>"+fecha;
  document.getElementById("cuerpo_tabla3_mod").innerHTML ="";

  <?php foreach($fila2 as $a  => $valor){ ?>
        if (<?php echo $valor['id']?> == id){
          var table = document.getElementById("cuerpo_tabla3_mod");
          var row = table.insertRow(0);
          row.insertCell(0).innerHTML = "<?php echo $valor['modelo'] ?>";
          row.insertCell(1).innerHTML = "<?php echo $valor['precio'] ?>";
          row.insertCell(2).innerHTML = "<div class='col s5 offset-s4'><input type='number' class='cant_ven' idc='<?php echo $valor['idp'] ?>'  precio='<?php echo $valor['precio'] ?>' value='<?php echo $valor['cantidad'] ?>' /></div>";
          
        }
  <?php } ?>
  document.getElementById("subtotal_mod").innerHTML="Total Bs.: <input type='text' id='total_mod' name='total_mod' value='"+total+"' required/><input type='text' name='idv_mod' id='idv_mod' value='"+id+"' hidden/><input type='text' id='fecha_mod' name='fecha_mod' value='"+fecha+"' hidden/>";
  $("#modal4").openModal(); 
}

function cargar_detalle(fecha, nombre, apellido, ci, id, total){
  document.getElementById("ncliente").innerHTML ="<b>Cliente: </b>"+nombre+" "+apellido;
  document.getElementById("fecha_detalle").innerHTML ="<b>Fecha de compra: </b>"+fecha;
  $("#ci_detalle").html("<b>CI: </b>"+ci);
  document.getElementById("cuerpo_tabla3").innerHTML ="";

  <?php foreach($fila2 as $a  => $valor){ ?>
        if (<?php echo $valor['id']?> == id){
          var table = document.getElementById("cuerpo_tabla3");
          var row = table.insertRow(0);
          row.insertCell(0).innerHTML = "<?php echo $valor['modelo'] ?>";
          row.insertCell(1).innerHTML = "<?php echo $valor['precio'] ?>";
          row.insertCell(2).innerHTML = "<?php echo $valor['cantidad'] ?>";
        }
  <?php } ?>
  document.getElementById("subtotal").innerHTML="Total: "+total+" Bs.";
  $("#modal1").openModal();  
}


function borrar_registro(id){
  
  var x=[];
  var cad="";
  <?php foreach($fila2 as $a  => $valor){ ?>
    if(<?php echo $valor["id"] ?> == id){
      x.push('<?php echo $valor["idp"] ?>'); 
    }
  <?php } ?>
  for (var i = 0; i < x.length; i++) {
    cad=cad+'<input type="text" name="'+i+'" value="'+x[i]+'" hidden/>';
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
          $("#cuerpo").load("ventas.php?anio=<?php echo $anio ?>&mes=<?php echo $mes ?>");
      }
    });
});

</script>

</div>
</div>
</body>
</html>