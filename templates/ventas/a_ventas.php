<style type="text/css">
.ui-autocomplete-row {
    padding: 8px;
    background-color: #f4f4f4;
    border-bottom: 1px solid #ccc;
    font-weight: bold;
}

.ui-autocomplete-row:hover {
    background-color: #ddd;
}

.zoom {
    transition: transform .2s;
}

.zoom:hover {
    transform: scale(1.8);
}

.helpertext {
    top: -20px;
    position: relative;
}
</style>
<div class="fuente" style="">
    <h5 align="" style="color: red;">Buscar Lider/Experta</h5>
    <div class="row">
        <form id="insert_row">
            <div class="input-field col s6">
                <div class="col s6">
                    <input type="text" id="search_le" placeholder="Buscar Lider/Experta" autocomplete="off" class="validate" required />
                </div>
                <!-- codigo -->
                <div class="col s3">
                    <input style="color: black;" type="text" id="ca" placeholder="código" autocomplete="off" disabled required>
                </div>
                <div class="col s2">
                    <input id="descuento_" type="number" min="0" max="100" value="0" class="validate" placeholder="% Descuento">
                    <small class="helpertext" style="color: red">% Descuento</small>
                    <input type="text" id="lugar" hidden>
                </div>
            </div>
            <!-- boton insertar -->
            <!-- <div class="col s2">
              <button class="btn waves-effect waves-light btn-large" type="submit" ><i class="material-icons right">assignment</i>Insertar</button>
              </div> -->
        </form>
    </div>
</div>
<!-- anadir buscar -->
<div id="form_productos" class="row" hidden>
    <div class="fuente" style="">
        <h5 align="" style="color: red;">Buscar producto</h5>
        <div class="row">
            <form id="insert_row_producto">
                <div class="input-field col s5">
                    <div class="col s5">
                        <input type="text" id="search_producto" placeholder="Buscar producto" autocomplete="off" class="validate" required />
                    </div>
                    <div class="col s3">
                        <input type="number" id="cantidad_" placeholder="Cantidad" autocomplete="off" class="validate" required>
                        <b><span id="stock" style="color: red; text-shadow: 0 0 0.2em #F87, 0 0 0.2em #F87"></span></b>
                        <input type="text" id="stock_" hidden>
                    </div>
                    <div class="col s3">
                        <input type="text" id="pupesos_" placeholder="Precio en Pesos" required>
                    </div>
                    <input type="text" id="id_" value="" hidden>
                    <input type="text" id="linea_" value="" hidden>
                    <input type="text" id="pubs_" value="" hidden>
                    <input type="text" id="subtotal_" value="" hidden>
                </div>
                <div class="col s2">
                    <button class="btn waves-effect waves-light btn-large" type="submit"><i class="material-icons right">assignment</i>Insertar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- tabla de productos pa la venta -->
<div id="tabla_ventas" class="row" hidden>
    <div class="col s8">
        <table class="highlight">
            <thead>
                <tr>
                    <th>Código<br>(Producto)</th>
                    <th>Linea</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                    <th>Precio U. Bs.</th>
                    <th>Precio U. Bs. <br>con descuento</th>
                    <th>Subtotal</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody id="tabla_c" class="tabla_c">
            </tbody>
        </table>
    </div>
    <div class="col s3 offset-s1">
        <a href="#!" onclick="confirmar_venta()" class="waves-effect waves-light btn-large"> <i class="material-icons right">receipt</i>Registrar venta</a>
    </div>
</div>
<!--MODAL AGREGAR PRODUCTO-->
<div class="row">
    <div id="modal1" class="modal col s4 offset-s4">
        <div class="modal-content">
            <h5 class="fuente"><b>Se registrará la venta con los datos:</h5>
            <!-- ---------modal confirmar venta---------- -->
            <form action="#">
                <div>
                    <p id="cliente_c"></p>
                    <p id="ca_c"></p>
                    <p id="monto_c"></p>
                </div>
                <p> Tipo de Pago:
                    <input name="tipo_pago" type="radio" id="contado" value="0" onclick="$('#pago_i').hide()" />
                    <label for="contado">Contado</label>
                    <input name="tipo_pago" type="radio" id="credito" value="1" onclick="$('#pago_i').show()" />
                    <label for="credito">Crédito</label>
                </p>
                <div class="row" id="pago_i" hidden>
                    <div class="col s2"> Pago Inicial:</div>
                    <div class="col s3">
                        <input type="number" id="pago_inicial" name="pago_inicial">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light btn-flat red left">CANCELAR</a>
            <a href="#!" onclick="crear_html()" class="waves-effect waves-light btn-flat blue">REGISTRAR VENTA</a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // $('#modal').leanModal();
    //----------filtro lider/experta---------------
    $('#search_le').autocomplete({
        source: "recursos/ventas/buscar_le.php",
        minLength: 1,
        select: function(event, ui) {
            $("#descuento_").removeAttr('disabled');
            $("#ca").val(ui.item.ca)
            if (ui.item.nivel == "experta") {
                $("#descuento_").val('30')
            }
            $('#search_le').val(ui.item.value);
            $('#lugar').val(ui.item.lugar);
            $('#form_productos').attr("hidden", false);
            $('#tabla_ventas').attr("hidden", false);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
    //buscar producto 
    $('#search_producto').autocomplete({
        source: "recursos/ventas/buscar_producto.php",
        minLength: 1,
        select: function(event, ui) {
            $("#pupesos_").val(ui.item.pupesos)
            $("#stock").html("Cantidad stock: " + ui.item.stock)
            $("#stock_").val(ui.item.stock)
            $('#search_producto').val(ui.item.value);
            $('#id_').val(ui.item.id);
            $('#linea_').val(ui.item.linea);
            $('#pubs_').val(ui.item.pubs);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
});

//------confirmar venta----------
function confirmar_venta() {

    $("#cliente_c").html("Lider/Experta: " + $("#search_le").val());
    $("#ca_c").html("Código Arbell: " + $("#ca").val());
    let totalcd = 0;
    document.querySelectorAll('#tabla_ventas tbody tr').forEach(function(e) {
        totalcd = totalcd + parseFloat(e.querySelector('._precio_cd').innerText);
    });
    $("#monto_c").html("Total a pagar: " + totalcd.toFixed(1) + " Bs.");
    $("#modal1").openModal();
}

/* --------------funcion insertar fila de producto---------------- */
document.getElementById("insert_row_producto").addEventListener("submit", function(event) {
    event.preventDefault();
    $("#descuento_").prop("disabled", true);
    if (parseInt($("#cantidad_").val()) > parseInt($("#stock_").val())) {
        Materialize.toast("<span style='color: yellow'>La cantidad ingresada es mayor al stock </span>", 5000)
        return false;
    }
    //Convertir precio en pesos a precio en Bs.
    var pubs_ = parseFloat($("#pupesos_").val()) * parseFloat($("#valor").val())
    pubs_ = pubs_.toFixed(1)
    // PRECIO CON DESCUENTO EN PESOS
    var desc_ = $("#descuento_").val()
    desc_ = parseFloat(desc_) * 0.01;
    var pupesos = $("#pupesos_").val()
    pupesos_desc = parseFloat(pupesos) * parseFloat(desc_);
    pupesos_desc = parseFloat($("#pupesos_").val()) - pupesos
    pupesos_desc = pupesos_desc.toFixed(1)
    // console.log(pupesos+"pcd pesos")

    // PRECIO CON DESCUENTO EN BS.
    var pubs_desc = pubs_
    pubs_desc = parseFloat(pubs_desc) * parseFloat(desc_);
    pubs_desc = parseFloat(pubs_) - pubs_desc
    pubs_desc = pubs_desc.toFixed(1)
    // console.log(pubs_desc+"pcd bs")
    /* //Subtotal sin descuento
    precio_sd = parseFloat($("#cantidad_").val()) * pubs_
    precio_sd = precio_sd.toFixed(1) */

    //Subtotal con descuento
    precio_cd = parseFloat($("#cantidad_").val()) * pubs_desc
    precio_cd = precio_cd.toFixed(1)
    $("#subtotal_").val(precio_cd)

    let table = document.getElementById("tabla_c")
    let newTableRow = table.insertRow(-1)

    let newRow = newTableRow.insertCell(0)
    newRow.textContent = $("#id_").val()
    newRow.className = "_id"

    newRow = newTableRow.insertCell(1)
    newRow.textContent = $("#linea_").val()
    newRow.className = "_linea"

    newRow = newTableRow.insertCell(2)
    newRow.textContent = $("#search_producto").val()
    newRow.className = "_descripcion"

    newRow = newTableRow.insertCell(3)
    newRow.textContent = $("#stock_").val()
    newRow.className = "_stock"

    newRow = newTableRow.insertCell(4)
    newRow.textContent = $("#cantidad_").val()
    newRow.className = "_cantidad"

    newRow = newTableRow.insertCell(5)
    newRow.textContent = pubs_
    newRow.className = "_pubs"

    newRow = newTableRow.insertCell(6)
    newRow.textContent = pubs_desc
    newRow.className = "_pubs_desc"

    newRow = newTableRow.insertCell(7)
    newRow.textContent = precio_cd
    newRow.className = "_precio_cd"

    newRow = newTableRow.insertCell(8)
    newRow.innerHTML = '<a href="#!" onclick="delete_row(event)" class="btn-floating red"><i class="material-icons">delete</i></a>'

    $('#stock').html("")
    $("#search_producto").val("")
    $("#cantidad_").val("")
    $("#pupesos_").val("")
});

function crear_html() {
    let filas = $("#tabla_ventas").find('tbody tr').length;
    if (filas < 1) {
        Materialize.toast("Debe insertar un producto.", 5000);
        return $("#modal1").closeModal();
    }
    if (!document.querySelector('input[name="tipo_pago"]:checked')) {
        return Materialize.toast("Debe seleccionar el tipo de pago.", 4000);
    }
    if (document.getElementById("credito").checked) {
        if ($("#pago_inicial").val() == "") {
            return Materialize.toast("Debe ingresar el pago inicial.", 4000)
        }
    }

    var date = new Date();
    var options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };
    date = date.toLocaleDateString("es-ES", options)

    array_ = "";
    let items = 0
    var pubs__ = 0
    var pubs__desc = 0
    let gan_exp_u = 0
    let gan_exp = 0
    var totalsd = 0
    let totalcd = 0.0
    var descuento = 0

document.querySelectorAll('#tabla_ventas tbody tr').forEach(function(e) {
let fila = `
<tr>
    <td>${e.querySelector('._id').innerText}</td>
    <td>${e.querySelector('._linea').innerText}</td>
    <td>${e.querySelector('._descripcion').innerText}</td>
    <td>${e.querySelector('._cantidad').innerText}</td>
    <td>${e.querySelector('._pubs').innerText}</td>
    <td>${e.querySelector('._pubs_desc').innerText}</td>
    <td>${e.querySelector('._precio_cd').innerText}</td>
</tr>`;

        array_ = array_ + fila;
        gan_exp = gan_exp + (parseFloat(e.querySelector('._pubs').innerText) * parseInt(e.querySelector('._cantidad').innerText))


        // totalsd = totalsd + parseFloat(e.querySelector('._precio_sd').innerText);
        totalcd = totalcd + parseFloat(e.querySelector('._precio_cd').innerText);
        pubs__ = pubs__ + parseFloat(e.querySelector('._pubs').innerText);
        pubs__desc = pubs__desc + parseFloat(e.querySelector('._pubs_desc').innerText);
        items = items + parseInt(e.querySelector('._cantidad').innerText);
    });

    gan_exp_u = pubs__ - pubs__desc
    gan_exp_u = gan_exp_u.toFixed(1)
    gan_exp = gan_exp - totalcd
    gan_exp = gan_exp.toFixed(1)
    _descuento = $("#descuento_").val();
    _valor = $("#valor").val();

    let _nombre_le = $("#search_le").val()
    let _ca = $("#ca").val()

    var data = detalle_venta()
    data.push({
        total_cd: totalcd.toFixed(1) + ""
    })
    data.push({
        _descuento: _descuento
    })
    data.push({
        _valor: _valor
    })
    data.push({
        _ca: _ca
    })
    data.push({
        _tipo_pago: $("input[name='tipo_pago']:checked").val()
    })
    data.push({
        _pago_inicial: $("#pago_inicial").val()
    })
    var json_data = JSON.stringify(data)



    insertar_venta_detalle(json_data).then(respuesta => {
        console.log(respuesta + " respuesta de funcion promise")
        var miHtml = `<title>RECIBO</title>

  <style>
    .bod{
      font-family: 'Consolas';
    }
    .detalle, .detalle th, .detalle td {
      border: 1px solid black;
      border-collapse: collapse;
    }
 
  </style>
  <div class="bod">
  
    <span style="float:right">${date}</span>
    <br><br>

    <table width="100%" border="0">
      <tr>
        <td width="33%" align="left">
          <span>Código Arbell: ${_ca}</span><br>
          <span>Lider/Experta: ${_nombre_le}</span>
        </td>
        <td width="33%" align="center">
          <span>Punto de venta: Principal</span><br>
          <span>Forma de pago: Efectivo</span><br>
          <span>Periodo: PERIODO 2 - 2021</span>
        </td>
        <td width="33%" align="right">
          <span>Distribuidora: CARMIÑA</span>
        </td>
      </tr>
    </table>

  <br>
  
   <h2>Items del comprobante</h2>
   <table width="100%" class="detalle">
    <thead>
      <tr >
        <th >Código<br>(producto)</th>
        <th >Linea</th>
        <th >Descripción</th>
        <th >Cantidad</th>
        <th >P. Unidad (Bs.)</th>
        <th >P.Unidad C.D. (Bs.)</th>
        <th >Subtotal (Bs.)</th>
      </tr>
    </thead>
    <tbody>
      ${array_}
    </tbody>
   </table>
   <br>
   <br>

  <div style="float: right">
   <h3>TOTALES</h3>
  
     <table class="detalle">
      <tr>
        <td><b>Items:</b></td>
        <td><b>${items} u. (Incluye 0 aux):</b></td>
      </tr>
      <tr>
        <td><b>Ganancias experta U.:</b></td>
        <td>${gan_exp_u}</td>
      </tr>
      <tr>
        <td><b>Ganancias experta:</b></td>
        <td>${gan_exp}</td>
      </tr>
      <tr>
        <td><b>Total a pagar:</b></td>
        <td>${totalcd}</td>
      </tr>
     </table>
   </div>
  </div>`;
        imprimir(miHtml, respuesta);
        $("#modal1").closeModal();
        $("#tabla_c tr").remove();
    })
}

function detalle_venta() {
    let array_ = [];
    document.querySelectorAll('#tabla_ventas tbody tr').forEach(function(e) {
        let fila = {
            id: e.querySelector('._id').innerText,
            linea: e.querySelector('._linea').innerText,
            descripcion: e.querySelector('._descripcion').innerText,
            cantidad: e.querySelector('._cantidad').innerText,
            pubs: e.querySelector('._pubs').innerText,
            pubs_desc: e.querySelector('._pubs_desc').innerText,
            precio_cd: e.querySelector('._precio_cd').innerText
        };
        array_.push(fila)
    });
    return (array_)
}

function insertar_venta_detalle(json_data) {

    return new Promise((resolve, rechazar) => {
        $.ajax({
            url: "recursos/ventas/registrar_venta.php",
            data: {
                "json": json_data
            },
            method: "post",
            success: function(response) {
                resolve(response)
            },
            error: function(error) {
                console.log(error)
                rachazar(error)
            }
        });
    })
}
//funcion borrar fila de tabla ventas
function delete_row(e) {
    console.log(e.target.parentNode.parentNode.parentNode.remove())
}

function imprimir(miHtml, numfac) {
    var pdf = new jsPDF('l', 'pt', 'a4');
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function(element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return false
        }
    };

    // var ventana = window.open ("about:blank", "_blank")
    var ventana = window.open();
    ventana.document.write(miHtml);
    // ventana.document.close();
    // ventana.focus();
    $(ventana.document).ready(function() {
        ventana.print();
        ventana.close();



        //FALTA CAMBIAR EL TAMAÑO DE LA HOJA DEL RECIBO
        margins = {
            top: 1,
            bottom: 1,
            left: 10,
            width: 10
        };
        pdf.fromHTML(
            miHtml,
            margins.left,
            margins.top, {
                'width': margins.width,
                'elementHandlers': specialElementHandlers
            },

            function(dispose) {
                pdf.save('recibo_venta_' + numfac + '.pdf');
            }, margins
        );

        return true;
    });

}
</script>
<script src="js/jsPDF.min.js"></script>