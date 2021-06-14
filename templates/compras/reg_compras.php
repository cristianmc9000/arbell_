<?php
require('../../recursos/sesiones.php');
session_start();
require('../../recursos/conexion.php');

// echo $_GET['ges'];

$Sql = "SELECT a.codc, a.fecha, a.totalsd, a.totalcd, a.descuento, a.valor_pesos FROM compras a WHERE a.estado = 1 AND a.fecha LIKE '".$_GET['ges']."%'"; 
$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()) 
        { 
            $fila[] = array('codc'=>$arr['codc'], 'fecha'=>$arr['fecha'],'totalsd'=>$arr['totalsd'],'totalcd'=>$arr['totalcd'],'descuento'=>$arr['descuento'], 'valor_pesos'=>$arr['valor_pesos']);
        } 
}else{
    $fila[] = array('codc'=>'--', 'fecha'=>'--','totalsd'=>'--','totalcd'=>'--','descuento'=>'--', 'valor_pesos'=>'--');
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


    .borde_tabla tr th, .borde_tabla tr td {
        border: 1px solid;
        border-collapse: collapse !important;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    </style>
</head>

<body>
    <div class="col s11">
        <div class="col s1">
                <b style= "color:blue"> Gestión:</b>
                <select onchange="enviarges()" name="ges" id="ges" class="browser-default">
                    <option value="0" selected disabled> Seleccionar</option>
                    <option value="2021"> 2021 </option>
                    <option value="2022"> 2022 </option>
                    <option value="2023"> 2023 </option>
                    <option value="2024"> 2024 </option>
                    <option value="2025"> 2025 </option>
                </select>
        </div>
        <div class="col s10 m8 offset-m3">
            <span class="fuente"><h3>Registro de compras de la gestión: <?php echo $_GET['ges']?></h3></span> 
        </div>
    </div>
    
    <!-- TABLA -->
    <table id="tabla1" class="highlight">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha de compra</th>
                <th>Total sin descuento</th>
                <th>Total con descuento</th>
                <th>Descuento</th>
                <th>Valor de cambio</th>
                <th>Detalle</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
            <tr>
                <td>
                    <?php echo $valor["codc"] ?>
                </td>
                <td>
                    <?php echo $valor["fecha"] ?>
                </td>
                <td>
                    <?php echo $valor["totalsd"] ?>
                </td>
                <td>
                    <?php echo $valor["totalcd"] ?>
                </td>
                <td >
                    <?php echo $valor["descuento"] ?>
                </td>
                <td >
                    <?php echo $valor["valor_pesos"] ?>
                </td>
                <td>
                    <a href="#!" onclick="ver_compra('<?php echo $valor['codc']?>', '<?php echo $valor['fecha'] ?>', '<?php echo $valor['totalcd'] ?>' )"><i class="material-icons">visibility</i></a>
                </td>
                <td>
                    <a href="#modal3" class="modal_trigger_3" onclick="$('#codc').val('<?php echo $valor['codc'] ?>')"><i class="material-icons">delete</i></a>
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
<!--                     <div class="col s4">
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
                    </div> -->
                    <div class="col s12">
                        <center><b><h5>Detalle de compra</h5></b></center>
                    </div>
                    <div class="col s12">
                        <div class="col s12">
                        <h5>TOTALES:</h5>
                        </div>
                        <div class="col s4">
                            <span id="fecha_com"></span><br>
                            <span id="items"></span><br>
                            <span id="gan_exp"></span><br>
                            <span id="total"></span>
                        </div>
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

                </div>
            </div>
        </div>
    </div>

<!-- MODAL ADMINISTRAR PAGOS -->
    <div class="row">
        <div id="modal2" class="modal">
            <div class="modal-content">
                <input id="codv_pago" type="text" value="codv" hidden>
                <input id="_subtotal" type="text" hidden>
                <input id="_total" type="text" hidden>

                <div class="row">
                    <p>
                        <h4  class="fuente">Administrar pagos</h4>
                    </p><br>
                    <div class="input-field col s4">
                        <input type="number" min="0" onkeypress="return check(event)" id="nuevo_pago" name="nuevo_pago">
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
                            <p style="color:red" id="debe">Saldo:</p>
                        <p id="saldo">Total:</p></b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" id="btn-cerrar_modal2" class=" modal-action modal-close waves-effect waves-light btn green">Aceptar</a>
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
    $('#modal').leanModal();
    $('.modal_trigger_3').leanModal();
    
});
var mensaje = $("#mensaje");
mensaje.hide();

/* funcion ver venta */
function ver_compra(codc, fecha, total) {
    detalle_compra(codc).then(respuesta => {
        let cantidad = 0
        let auxiliares = 0
        let gan_exp = 0

        var jsonParsedArray = JSON.parse(respuesta)

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
                newRow.textContent = jsonParsedArray[key]['pubs_cd'] +" Bs."

                newRow = newTableRow.insertCell(5)
                newRow.textContent = ((parseInt(jsonParsedArray[key]['cantidad']) * parseFloat(jsonParsedArray[key]['pubs_cd'])).toFixed(1)) +" Bs."

                if (jsonParsedArray[key]['codli'] == 16 || (jsonParsedArray[key]['codli'] >= 32 && jsonParsedArray[key]['codli'] <= 37)) {
                    auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                }
                cantidad += parseInt(jsonParsedArray[key]['cantidad']) 
                
                gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))

            }
        }
        $("#fecha_com").html("<b>Fecha de compra: </b>"+fecha)
        $("#items").html("<b>Items: </b>"+cantidad+"u. Incluye "+auxiliares+" auxiliares.")
        $("#gan_exp").html("<b>Ganancias: </b>"+((gan_exp).toFixed(1))+" Bs.")
        $("#total").html("<b>Total:</b> "+total +" Bs.")
        $("#modal1").openModal()
    })
}
//OBTENER EL DETALLE DE VENTA EN JSON
function detalle_compra(codc) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "recursos/compras/ver_compra.php?codc="+codc,
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

//funcion gestión
function enviarges() {
    ges = $('#ges').val();
    console.log(ges)
    $("#cuerpo").load("templates/ventas/reg_ventas.php?ges="+ges);
}
</script>

</body>
</html>