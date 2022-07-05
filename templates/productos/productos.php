<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();
$per = $_GET["mes"];
/* $anio = $_GET["anio"]; */

if (isset($_GET["mes"])) {
  $per = $_GET["mes"];
  $_SESSION['periodo'] = $per;
  $Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.periodo, (SELECT d.pubs FROM inventario d WHERE d.id=(SELECT MAX(e.id) FROM inventario e WHERE e.codp = a.id AND e.estado = 1) AND d.codp = a.id AND d.estado = 1) as pubs FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 1 AND a.linea = b.codli and a.periodo = ".$per;  
  // "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.periodo FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 1 AND a.linea = b.codli and a.periodo = ".$per; 
  
  
}else{
  $_SESSION['periodo'] = 'total';
  $per = 'total';
  $Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.periodo, (SELECT d.pubs FROM inventario d WHERE d.id=(SELECT MAX(e.id) FROM inventario e WHERE e.codp = a.id AND e.estado = 1) AND d.codp = a.id AND d.estado = 1) as pubs FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 1 AND a.linea = b.codli";
  // SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.periodo FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 1 AND a.linea = b.codli
}

/* $_SESSION['anio'] = $anio; */

// $Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, a.pupesos, a.pubs, a.cantidad, a.fechav FROM productos a, lineas b WHERE a.estado = 1 and a.linea = b.codli and fechareg LIKE '".$anio."-%-%' and periodo = ".$per; 



$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
  while($arr = $Busq->fetch_array()){ 

        $fila[] = array('id'=>$arr['id'], 'foto'=>$arr['foto'], 'linea'=>$arr['nombre'], 'codli'=>$arr['codli'], 'descripcion'=>$arr['descripcion'], 'cantidad'=>$arr['cantidad'], 'periodo'=>$arr['periodo'], 'pubs'=>$arr['pubs']); 

  }
}else{
        $fila[] = array('id'=>'--','foto'=>'--','linea'=>'--','codli'=>'--','descripcion'=>'--','pupesos'=>'--','pubs'=>'--','cantidad'=>'--','periodo'=>'--', 'pubs'=>'--');
}
  //consulta de lineas
// isset($_GET["mes"])

  $Sql2 = "SELECT codli, nombre FROM lineas WHERE periodo = ".$per." AND estado = 1";
  $Busq2 = $conexion->query($Sql2);

if ($Busq2) {
  if((mysqli_num_rows($Busq2))>0){
    while($arr2 = $Busq2->fetch_array()){ 
      $fila2[] = array('codli'=>$arr2['codli'], 'nombre'=>$arr2['nombre']); 
    }
  }
}else{
  // $fila2[] = array('codli'=>"--", 'nombre'=>"--"); 
}

?>

<style>
  table.dataTable tbody th, table.dataTable tbody td {
      padding: 0;
  }
  .fuente{
    color: red;

  }
  .fuente_azul{
    color: black;
  }
  .borde_tabla {
      border: 1px solid;
      border-collapse: collapse !important;
  }
  .borde_tabla td, .borde_tabla th{
    text-align: center;
  }
  .borde_tabla tr td {
      border: 1px solid;
      border-collapse: collapse !important;
      padding: 1px !important;
  }

  .borde_tabla tr th {
      border: 1px solid;
      border-collapse: collapse !important;
  }

  </style>

<div class="row">
<div class="col s11">
  <div class=" col s12 ">
      <div class="col s3">
          <b style= "color:blue">Seleccionar periodo:</b>
          <select onchange="enviarfecha()" name="mes" id="mes" class="browser-default">
              <option value="<?php echo $per; ?>" selected disabled><?php echo $per ?></option>
              <option value="total">Total</option>
              <option value="1"> 1 </option>
              <option value="2"> 2 </option>
              <option value="3"> 3 </option>
              <option value="4"> 4 </option>
              <option value="5"> 5 </option>
              <option value="6"> 6 </option>
              <!-- <option> Todos </option> -->
          </select>
      </div>
  </div>
<div class="col s4">
  <span class="fuente">
    <h3>
      Productos
      <!-- Modal Trigger -->
      <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1" <?php if ($per == 'total') echo 'style="display:none"'; ?>><i class="material-icons left">add</i></a>
    </h3>
  </span>
</div>
<div class="col s2 offset-s1 input-field">
  <a class="waves-effect waves-light btn-large orange <?php if ($per == "total") echo 'disabled' ?>" onclick="cargar_lineas()" id="modal_linea" href="#" ><i class="material-icons-outlined left">grading</i>Ver líneas</a>
</div>
<!-- TABLA -->
<div class="row">
  <table id="tabla1" class="highlight" >
    <thead>
      <tr>
          <th class="center">Ver</th>
          <th class="center">Código<br>(Producto)</th>
          <th class="center">Linea</th>
          <th class="center">Descripción</th>
          <th class="center">Periodo</th>
          <th class="center">Cantidad</th>
          <th class="center">Precio</th>
          <th class="center">Modificar</th>
          <th class="center">Borrar</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr>
        <td><img src="<?php echo $valor["foto"]?>" width="50px" height="40px" alt=""></td>
        <td class="center"><?php echo $valor["id"] ?></td>
        <td><?php echo $valor["linea"]?></td>
        <td><?php echo $valor["descripcion"]?></td>
        <td class="center"><?php echo $valor['periodo']?></td>
        <td class="center"><?php echo $valor["cantidad"] ?></td>
        <td class="center"><?php if (empty($valor['pubs'])) {echo 'Agotado';}else{ echo $valor["pubs"].' Bs.';}?> </td>
        <td  class="center">
          <a href="#!" onclick="mod_producto('<?php echo $valor['foto']?>','<?php echo $valor['id']?>','<?php echo $valor['linea'] ?>','<?php echo $valor['codli'] ?>','<?php echo $valor['descripcion'] ?>','<?php echo $valor['cantidad']?>','<?php echo $valor['pubs']?>')"><i class="material-icons">build</i></a>
        </td>
        <td class="center">
          <a href="#!" onclick="borrar_producto('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a>
        </td>
      
      </tr>
    <?php } ?>  
    </tbody>
  </table>
</div>
<!--MODAL AGREGAR LINEA-->
<div class="row">
<div id="modal_lin" class="modal col s6 offset-s3">
  <div class="modal-content">
    <h4 class="fuente">Nueva Linea</h4>  
    <div class="row">
      <form class="col s12" id="agregar_linea">
          <div class="input-field col s4">
            <input name="linea_" id="linea_" type="text" class="validate" required>
            <label for="linea_">Nombre de la Linea</label>
          </div>
          <div class="col s3">
              <button class="btn-large waves-effect waves-light orange" type="submit" ><i class="material-icons left">add</i>Agregar linea</button>
          </div>
      </form>
      <table id="tabla_lineas" class="borde_tabla">
          <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Periodo</th>
              <th>Modificar</th>
              <th>Borrar</th>
          </tr>
          <tbody>
              
          </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-light btn blue">Cerrar</a>
  </div>
</div>
</div>

<!--MODAL AGREGAR PRODUCTO-->
<div class="row">
<div id="modal1" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4>Nuevo producto</h4>  
    <div class="row">
      <form class="col s12" id="agregar_producto">
          <div class="row">
            <div class="input-field file-field col s6">
              <div class="btn">
                <span>Foto</span>
                <input type="file" name="imagen">
              </div>
              <div class="file-path-wrapper">
                <input id="foto" class="file-path validate" type="text">
              </div>
              
            </div>
            <div class="input-field col s6">
              <input name="codigo" type="text" autocomplete="off" required>
              <label for="codigo">Código:</label>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s6">
              <select id = "linea" name = "linea" class="browser-default">
                <option value="" disabled selected>Seleccionar linea</option>
                <?php foreach($fila2 as $a  => $valor){ ?>
                  <option value="<?php echo $valor["codli"] ?>"><?php echo $valor["nombre"] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="input-field col s6">
              <input name="descripcion" type="text" autocomplete="off" required>
              <label for="descripcion">Descripción:</label>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" id="btn-add_prod" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<!--MODAL MODIFICAR PRODUCTO-->
<div class="row">
<div id="modal2" class="modal col s4 offset-s4">
  <div class="modal-content fuente fuente_azul" >
    <h4>Modificar producto</h4>  
    <div class="row">
      <form class="col s12" id="modificar_producto">
          <div class="row">
            <div class="input-field file-field col s6">
              <div class="btn">
                <span>Foto</span>
                <input type="file" name="imagen">
              </div>
              <div class="file-path-wrapper">
                <input id="imagen_ant" name="imagen_ant" type="text" hidden>
                <input id="imagen" class="file-path validate" type="text">
              </div>
            </div>
            <div class="input-field col s6">
              <input id="codigo" name="codigo" type="text" required>
              <label class="active" for="codigo">Código:</label>
              <input id="codigo_ant" name="codant" type="text" hidden>
            </div>
          </div>
          <div class="row">  
            <div class="input-field col s12">
              <input id="descripcion" name="descripcion" type="text" required>
              <label class="active" for="descripcion">Descripción:</label>
            </div>
            <div class="input-field col s6">
              <select id = "lin" name="linea" class="browser-default" >
                <option id="lin_prev" value="" ></option>
                <?php foreach($fila2 as $a  => $valor){ ?>
                  <option value="<?php echo $valor["codli"] ?>"><?php echo $valor["nombre"] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="input-field col s6">
              <input type="text" id="_cambio" name="_cambio" hidden>
              <input id="pbs" name="pbs" type="text" onkeypress="return check(event)" autocomplete="off" required>
              <label class="active" for="pbs">Precio en Bs.:</label>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal-footer">
        <button id="btn-mod_prod" class="btn waves-effect waves-light" form="modificar_producto" type="submit" >Aceptar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
    </div>
</div>
</div>

<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal3" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar Producto</b></h4>  
    <p>¿Esta seguro que desea eliminar este producto?</p>
    <div class="row">
      <form class="col s12" id="eliminar_producto">
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
    <div id="mensaje" class="modal-content" hidden></div>

<script>
var mensaje = $("#mensaje");
$(document).ready(function() {
    $('#tabla1').dataTable({
        "order": [[ 1, "asc" ]],
        "language": {
          "lengthMenu": "Mostrar _MENU_ registros por página",
          "zeroRecords": "Lo siento, no se encontraron datos",
          "info": "Página _PAGE_ de _PAGES_",
          "infoEmpty": "No hay datos disponibles",
          "infoFiltered": "(filtrado de _MAX_ resultados)",
          "paginate": {
            "next": "Siguiente",
            "previous": "Anterior"
          }},
    });
    $('#modal').leanModal();
});
//FUNCION PARA CARGAR LINEAS DESDE LA BASE DE DATOS
function cargar_lineas() {
  let _per = '<?php echo $per ?>'; 
  if (_per == 'total') {
    return Materialize.toast("Seleccione un periodo.", 4000);
  }

  let respuesta
  $.ajax({
      url: "recursos/productos/ver_lineas.php",
      //method: "GET",
      success: function(response) {
            $(".dinamic_rows").remove();
            let jsonParsedArray = JSON.parse(response)
            //INSERTANDO FILAS A LA TABLA VER PAGOS
            let table = document.getElementById("tabla_lineas")
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"

                    newRow = newTableRow.insertCell(0)
                    newRow.textContent = jsonParsedArray[key]['codli']

                    newRow = newTableRow.insertCell(1)
                    newRow.textContent = jsonParsedArray[key]['nombre']

                    newRow = newTableRow.insertCell(2)
                    newRow.textContent = jsonParsedArray[key]['periodo']

                    newRow = newTableRow.insertCell(3)
                    newRow.innerHTML = '<a onclick="mod_linea(event, '+jsonParsedArray[key]['codli']+')" style="cursor:pointer"><i class="material-icons">build</i></a>'

                    newRow = newTableRow.insertCell(4)
                    newRow.innerHTML = '<a onclick="borrar_linea(event, '+jsonParsedArray[key]['codli']+')" style="cursor:pointer"><i class="material-icons">delete</i></a>'
                }
            }
            $("#modal_lin").openModal()
      },
      error: function(error) {
          console.log(error)
      }
  })
}

function mod_linea(e, id) {

  let text = $('#tabla_lineas').find('._linea').val()
  $('#tabla_lineas').find('._linea').remove()
  $("#tabla_lineas").find('td').each (function() {
    if ($(this).html() == "") {
      $(this).html(text)
    }
  }); 

  e.target.parentNode.parentNode.parentNode.children[1].innerHTML = '<input type="text" onkeyup="onKeyUp(event)" class="_linea" value="'+e.target.parentNode.parentNode.parentNode.children[1].innerHTML+'">'
}
//funcion para detectar la tecla enter
function onKeyUp(e) {
  let keycode = e.keyCode;
    if(keycode == '13'){
      let linea = $("._linea").val()
      let codli = e.target.parentNode.parentNode.children[0].innerHTML
      $.ajax({
      url: "recursos/productos/modificar_linea.php?nombre="+linea+"&codli="+codli,
      method: "GET",
      success: function(response) {
        if (response) {
          Materialize.toast("Línea modificada.", 4000);
          e.target.parentNode.innerHTML = $("._linea").val()
        }
      },
      error: function(error) {
          console.log(error)
      }
  })

    }
}

function borrar_linea(e, id) {  
  $.ajax({
      url: "recursos/productos/borrar_linea.php?id="+id,
      method: "GET",
      success: function(response) {
          if(response){
              console.log(response +" respuesta de borrar_linea.php")
              Materialize.toast("Línea eliminada.", 4000)
              console.log(e.target.parentNode.parentNode.parentNode.remove())
          }else{
              Materialize.toast("No se puede eliminar línea, contiene productos activos.", 4000)
          }
      },
      error: function(error) {
          console.log(error)
      }
  })
  
}

$("#agregar_producto").on("submit", function(e){
    e.preventDefault(); 
    $("#btn-add_prod").addClass('disabled')
    document.getElementById('btn-add_prod').disabled = true
    var val = new FormData(document.getElementById("agregar_producto"));
    $.ajax({
      url: "recursos/productos/agregar_producto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        $("#btn-add_prod").removeClass('disabled')
        document.getElementById('btn-add_prod').disabled = false
        mensaje.html(echo);
        console.log(echo)
        if (echo.includes("?mes")) {
          $("#modal1").closeModal(); 
          Materialize.toast("PRODUCTO AGREGADO." , 2000);
          $("#cuerpo").load("templates/productos/productos.php"+echo);
        } 

      }
    });
});

function mod_producto(foto, id, linea, codli, descripcion, cantidad, pubs) {

  $("#imagen_ant").val(foto)
  $("#imagen").val(foto)
  $("#codigo").val(id)
  $("#codigo_ant").val(id)
  //PARA SELECCIONAR LINEA 
  $("#lin_prev").val(codli)
  $("#lin_prev").html(linea)
  $("#lin_prev").prop("selected", true)
  // FIN SELECCIONAR LINEA
  $("#descripcion").val(descripcion)
  $("#cantidad").val(cantidad)

  if (pubs) {
    $("#pbs").val(pubs)
    $("#_cambio").val($("#valor").val());
    document.getElementById('pbs').disabled = false;
  }else{
    $("#pbs").val('Agotado')
    document.getElementById('pbs').disabled = true;
  }

  $("#modal2").openModal()
}

$("#modificar_producto").on("submit", function(e){
    e.preventDefault();
    $("#btn-mod_prod").addClass('disabled')
    document.getElementById('btn-mod_prod').disabled = true
    var val = new FormData(document.getElementById("modificar_producto"));
    $.ajax({
      url: "recursos/productos/modificar_producto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      // return console.log(echo)
      if (echo !== "") {
        $("#btn-mod_prod").removeClass('disabled')
        document.getElementById('btn-mod_prod').disabled = false
        mensaje.html(echo);
        // console.log(echo);
        if (echo.includes("?mes")) {
          $("#modal2").closeModal(); 
          Materialize.toast("PRODUCTO MODIFICADO." , 4000);
          $("#cuerpo").load("templates/productos/productos.php?"+echo);
        }
      }
    });
});

function borrar_producto(id){
  $("#datos_borrar").val(id)
  $('#modal3').openModal()
}

$("#eliminar_producto").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("eliminar_producto"));
    $.ajax({
      url: "recursos/productos/borrarproducto.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        if (echo == '2') {
          return Materialize.toast("No se puede eliminar el producto porque contiene productos activos en inventario." , 4000);
        }else{
          console.log(echo);
          $("#modal3").closeModal(); 
          Materialize.toast("PRODUCTO ELIMINADO." , 4000);
          $("#cuerpo").load("templates/productos/productos.php"+echo);
        }
    });
});

$("#agregar_linea").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_linea"));
    $.ajax({
      url: "recursos/productos/agregar_linea.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        mensaje.html(echo);
        console.log(echo);
        if (echo.includes("?mes")) {
          $("#modal_lin").closeModal(); 
          Materialize.toast("LINEA AGREGADA." , 4000);
          $("#cuerpo").load("templates/productos/productos.php"+echo);
        }
      })
    });

function convertira() {
  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pubs").val(bs.toFixed(2));
}
$("#pupesos").on("keydown input", function(){
  pesos = $("#pupesos").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pubs").val(bs.toFixed(2));
})

function convertirm() {
  pesos = $("#pup").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pub").val(bs.toFixed(2));
}
$("#pup").on("keydown input", function(){
  pesos = $("#pup").val()
  bs = pesos * parseFloat($("#valor").val());
  $("#pub").val(bs.toFixed(2));
})

function enviarfecha() {
    mes = $('#mes').val();
    if (mes == 'total') {
      $("#cuerpo").load("templates/productos/productos.php");  
    }else{
      $("#cuerpo").load("templates/productos/productos.php?mes="+mes);
    }
    
}

</script>

</div>
</div>
