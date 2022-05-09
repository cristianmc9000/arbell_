<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();
date_default_timezone_set("America/La_Paz");
$year = date('Y');
if (isset($_GET["ges"])) {
  $year = $_GET["ges"];
}

$result = $conexion->query("SELECT valor FROM cambio WHERE id = 2");
$result = $result->fetch_all(MYSQLI_ASSOC);

$Sql = "SELECT a.id, a.ca, CONCAT(c.nombre,' ',c.apellidos) as cliente, a.fecha, a.total, a.descuento, a.valor_peso, a.credito, a.periodo FROM pedidos a, clientes c WHERE a.ca = c.CA AND a.estado = 1 AND a.fecha LIKE '".$year."%'";

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

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap');
.roboto{
    font-family: 'Segoe UI Light'
    /*font-family: 'Roboto', sans-serif;*/
}
.fuente{
    color: red;
}
.fuente_azul{
    color: black;
}

#detalle_ped th, #detalle_ped tr td{
    border:  1px solid;
}

.line div{
    line-height: 1px;
    display: flex;
    flex-direction: row;
    gap: 20px;
}
.line div p{
    width: calc(33.3% - 20px);
}

.columnas{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
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
<div class="col s5">
<span class="fuente">
    <h3>
        Pedidos: Gestión - <?php echo $year;?>
    </h3>
</span>
    <div class="center">
        <a href="#!" id="cambio" style="background-color: #bdc3c7;" class="btn btn-flat waves-light waves-effect"><?php echo $result[0]['valor'] ?> Bs.</a>
    </div>
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

            <th>Aceptar pedido</th>
            <th>Rechazar pedido</th>
        </tr>
    </thead>

<tbody>
    <?php foreach($fila as $a  => $valor){ ?>
        <tr <?php if($valor["credito"] == '1'){echo 'style="background-color: #ffff9e"';}?>>
            <td><?php echo $valor["id"] ?></td>
            <td><?php echo $valor["ca"]?></td>
            <td><?php echo $valor["cliente"]?></td>
            <td><?php echo $valor["fecha"]?></td>
            <td><?php echo $valor["periodo"] ?></td>
            <td><?php if($valor["credito"] == '1'){echo 'Crédito';}else{echo 'Contado';} ?></td>
            <td><?php echo $valor["total"]?> Bs.</td>

            <td>
            <a href="#!" onclick="aceptar_pedido('<?php echo $valor['id']?>', '<?php echo $valor['ca']?>', '<?php echo $valor['cliente']?>', '<?php echo $valor['credito']?>', '<?php echo $valor['total']?>', '<?php echo $valor['valor_peso']?>', '<?php echo $valor['descuento']?>')"><i class="material-icons">check_circle</i></a>
            <!-- <a href="#!"><i class="material-icons">build</i></a> -->
            </td>
            <td>
            <a href="#!" onclick="rechazar_pedido('<?php echo $valor['id'] ?>');"><i class="material-icons">remove_shopping_cart</i></a>
            </td>

        </tr>
    <?php } ?>  
</tbody>
</table>

<!--MODAL MODIFICAR INVENTARIO-->
<div id="modal1" class="modal roboto">
    <div class="modal-content">
        <h4>Detalle del pedido</h4>
        <input type="text" id="id_ped" hidden>
        <div class="row">
            <div class="col s12 line">
                <div>
                    <p id="det_ca"></p>
                    <p id="det_cli"></p>
                    <p id="det_desc"></p>
                </div>
                <div>
                    <p id="det_cred"></p>
                    <p id="det_total"></p>
                    <p id="det_total_cd"></p>
                </div>
            </div>

            <div class="col s12">
                <table id="detalle_ped" class="highlight striped centered"> <!-- class="borde_tabla" -->
                    <thead>
                        <tr>
                            <th>Código <br> (producto)</th>
                            <th>Linea</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Subtotal C/D</th>
                        </tr>
                    </thead>
                    <tbody class="centered"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-light btn red left">Cerrar</a>
        <a href="#!" id="reg_ped" class="waves-effect waves-light btn">Aceptar pedido</a>
    </div>
</div>



<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal2" class="modal col s4 offset-s4">
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

<!-- Modal Structure -->
<div class="row">
  <div id="modal3" class="modal roboto col s4 offset-s4">
    <div class="modal-content ">
        <h4>Valor de cambio</h4>
        <div class="columnas">
            <div><p>1 Peso arg.</p></div>
            <div><input id="_cambio" type="text" value="<?php echo $result[0]['valor'] ?>"></div>
            <div><p>Bs.</p></div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" id="set_value" class="waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>

<div class="row">
    <div id="modal4" class="modal roboto col s4 offset-s4">
        <div class="modal-content">
          <h4>Se rechazará el pedido seleccionado.</h4>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light btn red left">Cerrar</a>
            <a href="#!" id="del_ped" class="waves-effect waves-light btn">Aceptar</a>
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

    // $('.modal').leanModal();

});

function aceptar_pedido(id, ca, cliente, credito, total, valor_peso, descuento) {
    if (credito == '1') {
        credito = 'Crédito'
    }else{
        credito = "Contado"
    }

    let json = [id, ca, credito, total, valor_peso, descuento]
    document.getElementById("id_ped").value = JSON.stringify(json)

    document.getElementById("det_ca").innerHTML = "<b>Código arbell: </b>"+ca
    document.getElementById("det_cli").innerHTML = "<b>Cliente: </b>"+cliente
    document.getElementById("det_desc").innerHTML = "<b>Descuento: </b>"+descuento+"%"
    document.getElementById("det_cred").innerHTML = "<b>Tipo pago: </b>"+credito
    document.getElementById("det_total").innerHTML = "<b>Total: </b>"+total+" Bs."

    

    $.ajax({
        url: "recursos/pedidos/detalle.php?id="+id,
        method: "GET",
        success: function(response) {
            let total_cd = 0;
            let cantidad = 0;
            let auxiliares = 0;
            var jsonParsedArray = JSON.parse(response)
            //INSERTANDO FILAS A LA TABLA DETALLE DE PEDIDO
            let table = document.getElementById("detalle_ped")
            $(".dinamic_rows").remove();
            for (key in jsonParsedArray) {
                if (jsonParsedArray.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"
                    newRow = newTableRow.insertCell(0)
                    newRow.textContent = jsonParsedArray[key]['id']

                    newRow = newTableRow.insertCell(1)
                    newRow.textContent = jsonParsedArray[key]['linea']

                    newRow = newTableRow.insertCell(2)
                    newRow.textContent = jsonParsedArray[key]['descripcion']

                    newRow = newTableRow.insertCell(3)
                    newRow.textContent = jsonParsedArray[key]['cantidad']

                    newRow = newTableRow.insertCell(4)
                    newRow.textContent = jsonParsedArray[key]['pubs'] +" Bs."

                    newRow = newTableRow.insertCell(5)
                    newRow.textContent = jsonParsedArray[key]['pubs_desc'] +" Bs."

                    
                    // gan_exp = gan_exp + (parseFloat(jsonParsedArray[key]['pubs']) * parseInt(jsonParsedArray[key]['cantidad']) - parseFloat(jsonParsedArray[key]['pubs_cd']) * parseInt(jsonParsedArray[key]['cantidad']))
                    total_cd += parseFloat(jsonParsedArray[key]['pubs_desc'])

                    cantidad += parseInt(jsonParsedArray[key]['cantidad'])
                    if (jsonParsedArray[key]['codli'] == 16 || (jsonParsedArray[key]['codli'] >= 32 && jsonParsedArray[key]['codli'] <= 37)) {
                        auxiliares += parseInt(jsonParsedArray[key]['cantidad']) 
                    }
                }
            }

            document.getElementById("det_total_cd").innerHTML = "<b>Total C/D: </b>"+total_cd+" Bs."
            $("#modal1").openModal();
        },
        error: function(error) {
            console.log(error)
        }
    });
}

document.getElementById('cambio').addEventListener('click', () => {
    $("#modal3").openModal();
});
document.getElementById('set_value').addEventListener('click', () => {
    let cambio = document.getElementById("_cambio").value;
    $.ajax({
        url: "recursos/pedidos/cambio.php?valor="+cambio,
        method: "GET",
        success: function(response) {
            console.log(response)
            $("#modal3").closeModal();
            $("#cuerpo").load("templates/pedidos/pedidos.php");
        },
        error: function(error) {
            console.log(error)
        }
    })
});

document.getElementById('reg_ped').addEventListener('click', () => {
    // let array_
    let id = document.getElementById("id_ped").value
    id = JSON.parse(id)
    

    let total_cd = id[3]
    let descuento = id[5]
    let valor = id[4]
    let ca = id[1]
    let tipo_pago = id[2]
    let pago_inicial = "0";
    
    if (tipo_pago == "Contado") {
        tipo_pago = "0";
    }else{
        tipo_pago = "1";
    }


            $.ajax({
                url: "recursos/pedidos/check_stock.php?id="+id[0],
                method: "GET",
                success: function(item) {
                    if (item != '1') {
                        item = JSON.parse(item)
                        return Materialize.toast("Cantidad del producto: "+item.codpro+" insuficiente en stock, "+item.stock+" disponibles.", 4000);
                    }
                    
                    $.ajax({
                        url: "recursos/pedidos/detalle.php?id="+id[0]+"&x=1",
                        method: "GET",
                        success: function(resp) {
                            resp = JSON.parse(resp)
                            resp.push({total_cd: total_cd})
                            resp.push({_descuento: descuento})
                            resp.push({_valor: valor})
                            resp.push({_ca: ca})
                            resp.push({_tipo_pago: tipo_pago})
                            resp.push({_pago_inicial: pago_inicial})
                            // console.log(resp)
                            $.ajax({
                                url: "recursos/ventas/registrar_venta.php",
                                data: {
                                    "json": JSON.stringify(resp)
                                },
                                method: "post",
                                success: function(response) {
                                    console.log(response)
                                    $("#modal1").closeModal()
                                    $("#cuerpo").load("templates/pedidos/pedidos.php")
                                    Materialize.toast("El pedido fué registrado.", 4000)
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                },
                error: function(error) {
                    console.log(error)
                }
            });

});
function rechazar_pedido(id) {
    document.getElementById('id_ped').value = id
    $("#modal4").openModal()
}

document.getElementById('del_ped').addEventListener('click', () => {
    let id = document.getElementById('id_ped').value
    $.ajax({
        url: "recursos/pedidos/rechazar.php?id="+id,
        method: "GET",
        success: function(response) {
            // console.log(response)
            $("#modal4").closeModal();
            Materialize.toast("El pedido fué rechazado.", 4000);
            $("#cuerpo").load("templates/pedidos/pedidos.php");
        },
        error: function(error) {
            console.log(error)
        }
    });    
})

//funcion periodo
function enviarfecha() {
    ges = $('#ges').val();
    $("#cuerpo").load("templates/pedidos/pedidos.php?ges="+ges);
}

</script>

</div>
</div>
