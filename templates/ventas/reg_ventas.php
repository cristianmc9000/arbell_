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
    <style>
    .fuente {
        font-family: 'Segoe UI light';
        color: red;
    }

    table.highlight>tbody>tr:hover {
        background-color: #a0aaf0 !important;
    }

    .borde_tabla {
        border: 1px solid;
        border-collapse: collapse !important;
    }

    .borde_tabla tr td {

        border: 1px solid;
        border-collapse: collapse !important;
    }

    .borde_tabla tr th {
        border: 1px solid;
        border-collapse: collapse !important;
    }
    </style>
</head>

<body>
    <span class="fuente">
        <h3>Registro de ventas</h3>
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
                <!-- <th>Pagos</th> -->
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
            <tr style='background-color: <?php if($valor["credito"] == 1){echo "#ffff9e";} if($valor["credito"] == 2){echo "#7eff9e";} ?>'>
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
                <td style="text-align: center">
                    <?php if($valor["credito"] == "0"){echo "Contado";} else{echo "<button onclick='pagos(event)'>Ver pagos</button>";} ?>
                </td>
                <td>
                    <a href="#!" onclick="ver_venta('<?php echo $valor['codv']?>')"><i class="material-icons">visibility</i></a>
                    <!-- <a href="#!"><i class="material-icons">build</i></a> -->
                </td>
                <td>
                    <!-- <a href="#!" onclick="borrar_venta('<?php echo $valor['codv'] ?>');"><i class="material-icons">delete</i></a> -->
                    <a href="#modal3" class="modal_trigger_3" onclick="$('#codv').val('<?php echo $valor['codv'] ?>')"><i class="material-icons">delete</i></a>
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
                        <span id="_ca">Código arbell: </span><br>
                        <span id="lider_ex">Lider/Experta:</span>
                    </div>
                    <div class="col s4" style="text-align: center;">
                        <span>Punto de venta: PRINCIPAL</span><br>
                        <span id="_credito">Forma de pago:</span><br>
                        <span id="_periodo">Periodo:</span>
                    </div>
                    <div class="col s4" style="text-align:right">
                        <span>Distribuidora: CARMIÑA</span>
                    </div>
                    <div class="col s12">
                        <p>
                            <h5>Items del comprobante</h5>
                        </p>
                    </div>
                    <div class="col s12">
                        <table id="detalle_ven" class="borde_tabla">
                            <tr>
                                <th>Código <br> (producto)</th>
                                <th>Linea</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>P. unidad</th>
                                <th>Subtotal</th>
                            </tr>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col s4 offset-s8">
                        <h5>TOTALES:</h5>
                    </div>
                    <div class="col s4 offset-s8">
                        <table class="borde_tabla">
                            <tr>
                                <th>Items:</th>
                                <td id="items"></td>
                            </tr>
                            <tr>
                                <th>Ganancias experta:</th>
                                <td id="gan_exp"></td>
                            </tr>
                            <tr>
                                <th>Total a pagar:</th>
                                <td id="total"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- MODAL ADMINISTRAR PAGOS -->
    <div class="row">
        <div id="modal2" class="modal">
            <div class="modal-content">
                <input id="codv_pago" type="text" value="codv" hidden>
                <div class="row">
                    <p>
                        <h4  class="fuente">Administrar pagos</h4>
                    </p><br>
                    <div class="input-field col s4">
                        <input type="number" id="nuevo_pago" name="nuevo_pago">
                        <label for="nuevo_pago">Insertar nuevo pago</label>
                    </div>
                    <div class="col s3">
                        <a href="#!" onclick="nuevo_pago()" id="boton_pagos" class="waves-effect waves-light btn-large blue">Agregar pago</a>
                    </div>
                    <table id="tabla_pagos" class="borde_tabla">
                        <tr>
                            <th>Fecha de pago</th>
                            <th>Monto</th>
                            <th>Borrar pago</th>
                        </tr>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <div class="col s4 offset-s8">
                        <b><p id="subtotal">Subtotal:</p>
                            <p style="color:red" id="debe">Debe:</p>
                        <p id="saldo">Saldo:</p></b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-light btn green">Aceptar</a>
            </div>
        </div>
    </div>

<!-- MODAL ELIMINAR VENTA  -->
    <div class="row">
        <div id="modal3" class="modal col s4 offset-s4">
            <div class="modal-content">
                <input id="codv" type="text" value="codv" hidden>
                <div class="row">
                    <h4 class="fuente">Se eliminará la venta.</h4>
                    <span> Se devolveran los productos al inventario.</span>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn left red">Cancelar</a>
                <a href="#!" onclick="borrar_venta()" class="modal-action modal-close waves-effect waves-light btn">Confirmar</a>
            </div>
        </div>
    </div>

    <div id="mensaje"></div>

<!-- -----------------CRUD DE USUARIOS------------------------ -->
<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
        "order": [
            [0, "desc"]
        ]
    });
    $('#modal').leanModal();
    $('.modal_trigger_3').leanModal();
    
});
var mensaje = $("#mensaje");
mensaje.hide();

/* funcion ver venta */
function ver_venta(codv) {
    detalle_venta(codv).then(respuesta => {
        let total = 0
        let cantidad = 0
        let gan_exp = 0
        let periodo = 0
        let credito
        let ca
        let cliente
        var jsonParsedArray = JSON.parse(respuesta)
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                total += parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(jsonParsedArray[key]['pubs_cd'])
                credito = jsonParsedArray[key]['credito']
                ca = jsonParsedArray[key]['ca']
                cliente =jsonParsedArray[key]['cliente']
                if(parseInt(jsonParsedArray[key]['periodo'])> periodo){
                    periodo = parseInt(jsonParsedArray[key]['periodo'])
                }
            }
        }
        if(credito = 1){credito = "Crédito"}else{credito = "Contado"}
        total = total.toFixed(1)
        $("#_periodo").html("Periodo: "+periodo)
        $("#_credito").html("Tipo de pago: "+credito)
        $("#_ca").html("Código Arbell: "+ca)
        $("#lider_ex").html("Lider/experta: "+cliente)

        //INSERTANDO FILAS A LA TABLA DETALLE DE VENTA 
        let table = document.getElementById("detalle_ven")
        $(".dinamic_rows").remove();
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                newRow = newTableRow.insertCell(0)
                newRow.textContent = jsonParsedArray[key]['codp']

                newRow = newTableRow.insertCell(1)
                newRow.textContent = jsonParsedArray[key]['linea']

                newRow = newTableRow.insertCell(2)
                newRow.textContent = jsonParsedArray[key]['descripcion']

                newRow = newTableRow.insertCell(3)
                newRow.textContent = jsonParsedArray[key]['cantidad']

                newRow = newTableRow.insertCell(4)
                newRow.textContent = jsonParsedArray[key]['pubs_cd']

                newRow = newTableRow.insertCell(5)
                newRow.textContent = (parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(jsonParsedArray[key]['pubs_cd'])).toFixed(1)

                cantidad = cantidad + parseInt(jsonParsedArray[key]['cantidad'])
                gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))

            }
        }

        $("#total").html(total)
        $("#items").html(cantidad)
        $("#gan_exp").html((gan_exp).toFixed(1))
        $("#modal1").openModal()
    })
}
//OBTENER EL DETALLE DE VENTA EN JSON
function detalle_venta(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/ver_venta.php?codv=" + codv,
            method: "GET",
            success: function(response) {
                resolve(response)
            },
            error: function(error) {
                console.log(error)
                reject(error)
            }
        })
    })
}

//ABRIR MODAL PAGOS CON TODOS LOS DATOS DE LA TABLA
function pagos(e) {


    document.getElementById("boton_pagos").setAttribute('onclick', "nuevo_pago()");
    $("#boton_pagos").removeClass('disabled')


    row = e.target.parentNode.parentNode
    cell = row.getElementsByTagName("td")
    $("#codv_pago").val(cell[0].innerText)
    ver_pagos(cell[0].innerText).then(respuesta => {
        let subtotal = 0
        $(".dinamic_rows").remove();
        var jsonParsedArray = JSON.parse(respuesta)
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    subtotal += parseFloat(jsonParsedArray[key]['monto'])
                    saldo = parseFloat(jsonParsedArray[key]['total'])
                }
            }
        $("#subtotal").html("Subtotal: "+subtotal)
        $("#debe").html("Saldo: "+(saldo-subtotal))
        $("#saldo").html("Crédito: "+subtotal+"/"+saldo)

        if (subtotal >= saldo ) {
            $("#boton_pagos").addClass('disabled')
            document.getElementById('boton_pagos').removeAttribute("onclick");
        }

        //INSERTANDO FILAS A LA TABLA VER PAGOS
        let table = document.getElementById("tabla_pagos")
        for (key in jsonParsedArray) {
            if (jsonParsedArray.hasOwnProperty(key)) {
                let newTableRow = table.insertRow(-1)
                newTableRow.className = "dinamic_rows"
                newRow = newTableRow.insertCell(0)
                newRow.textContent = jsonParsedArray[key]['fecha_pago']

                newRow = newTableRow.insertCell(1)
                newRow.textContent = jsonParsedArray[key]['monto']

                newRow = newTableRow.insertCell(2)
                newRow.innerHTML = '<a onclick="borrar_pago(event, '+jsonParsedArray[key]['id']+', '+jsonParsedArray[key]['codv']+')" class="btn-floating red"><i class="material-icons">delete</i></a>'
            }
        }
    })

    $("#modal2").openModal()
}

//RECUPERAR DATOS DE LA BD TABLA: PAGOS(JSON)
function ver_pagos(codv) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/ventas/ver_pagos.php?codv="+codv,
            method: "GET",
            success: function(response) {
                resolve(response)
            },
            error: function(error) {
                console.log(error)
                reject(error)
            }
        })
    })
}
//FUNCION PARA BORRAR UN PAGO DE LA BASE DE DATOS TABLA: PAGOS
function borrar_pago(e, id, codv) {
    console.log(id)
    $.ajax({
            url: "recursos/ventas/borrar_pago.php?id="+id+"&codv="+codv,
            method: "GET",
            success: function(response) {
                if(response){
                    Materialize.toast("Pago eliminado", 4000)
                    document.getElementById("boton_pagos").setAttribute('onclick', "nuevo_pago()");
                    document.getElementById("boton_pagos").classList.remove("disabled");
                    $("#modal2").closeModal()   
                    $("#cuerpo").load("templates/ventas/reg_ventas.php")

                }else{
                    console.log("error: "+response)
                }

            },
            error: function(error) {
                console.log(error)
            }
    })
    e.target.parentNode.parentNode.parentNode.remove()
}

//FUNCION PARA INSERTAR UN NUEVO PAGO
function nuevo_pago() {
    let codv = $("#codv_pago").val()
    let monto = $("#nuevo_pago").val()
    $.ajax({
        url: "recursos/ventas/nuevo_pago.php?codv="+codv+"&monto="+monto,
        method: "GET",
        success: function(response) {
            console.log(response)
            if(response){
                $("#modal2").closeModal()
                Materialize.toast("Pago agregado.", 4000)
                $("#cuerpo").load("templates/ventas/reg_ventas.php")
            }else{
                console.log("error: "+response)
            }
        },
        error: function(error) {
            console.log(error)
        }
    })
}

//funcion borrar venta
function borrar_venta(){
let codv = $("#codv").val()
$.ajax({
    url: "recursos/ventas/borrar_venta.php?codv="+codv,
    method: "GET",
    success: function (response){
        console.log(response);
        if (response) {
            Materialize.toast("Venta eliminada.", 4000)
            $("#cuerpo").load("templates/ventas/reg_ventas.php")
        }
    }

});
}
</script>

</body>
</html>