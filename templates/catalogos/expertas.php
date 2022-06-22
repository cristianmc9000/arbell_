<?php 
	require('../../recursos/conexion.php');
	session_start();
	$ca=$_SESSION["ca"];
	date_default_timezone_set("America/La_Paz");
	$year = ""; 

	$result = $conexion->query("SELECT * FROM `clientes` WHERE estado = 1 AND lider = ".$ca);
	$result = $result->fetch_all(MYSQLI_ASSOC);
	if ($result) {
		// echo var_dump($result[0]['ca']);
	}
	

?>
<style>
.card__img {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
<br>
<div class="container">
    <div class="col s12 m12 l12 xl12">

        <br>
        <?php foreach($result as $key  => $valor){ ?>
        <div class="col s12 m6 l6 xl6 rubik">
            <div class="z-depth-3 card horizontal card__pad" style="background-color: #3498db">
                <div class="card-stacked">
                    <div class="">
                        <p>Nombre: <?php $valor['nombre'].' '.$valor['apellidos']?></p>
                        <p>Celular: <?php $valor['telefono']?></p>
                        <p>CA: <?php $valor['CA']?></p>
                        <p>CI: <?php $valor['CI']?></p>
                    </div>
                </div>
                <div class="card__img">
                    <div>
                        <a href="#" onclick="detalle('<?php echo $valor['CA'] ?>')" style="width: 100%"
                            class="btn waves-effect waves-dark white black-text">Historial</a>
                    </div>
                    <div <?php if ($valor['estado'] == '1' || $valor['credito'] == '0') {echo 'hidden';}?>>
                        <a href="#"
                            onclick="pagos('<?php echo $valor['id'] ?>', '<?php echo $valor['credito'] ?>', '<?php echo $valor['total_cd'] ?>')"
                            style="width: 100%" class="btn waves-effect waves-dark white black-text">Pagos</a>
                    </div>

                    <!-- <img class=" img__card" src="images/arbell_logo.png"> -->
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="rubik">

        <div id="modal1"  style="" class="modal">
            <div class="modal-content">
                <h4>Historial de pagos</h4>

                <table id="pagos" class="det content-table z-depth-4">
                    <thead>
                        <tr>
                            <th>Fecha de pago</th>
                            <th>Monto</th>
                            <!-- <th>PRECIO</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="dinamic_rows">No se ha realizado ningún pago...</td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <div>
                    <p id="saldo"></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
            </div>
        </div>

        <div id="modal2" class="modal">
            <div class="modal-content">
                <h4>Detalle del pedido</h4>
                <br>
                <div>
                    <table id="detalle" class="det centered content-table z-depth-4">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function() {
    $('.modal').modal();
    $("#titulo").html('Mis expertas');
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };
    document.querySelectorAll('.dd').forEach(function(e) {
        fecha = new Date(e.innerText);
        e.innerText = fecha.toLocaleDateString("es-ES", options);;
    });
});

function pagos(id, credito, total_cd) {
    if (credito == '1') {

        $(".dinamic_rows").remove();
        $.ajax({
            url: "recursos/catalogos/pagos.php?id=" + id,
            method: "GET",
            success: function(response) {
                res = JSON.parse(response)
                //INSERTANDO FILAS A LA TABLA VER PAGOS
                let table = document.getElementById("pagos")
                let subtotal = 0;
                if (res.length < 1) {
                    $("#pagos tbody").html(
                        '<tr><td colspan="2" class="dinamic_rows">No se ha realizado ningún pago...</td></tr>'
                    );
                } else {
                    for (key in res) {
                        if (res.hasOwnProperty(key)) {
                            let newTableRow = table.insertRow(-1)
                            newTableRow.className = "dinamic_rows"
                            newRow = newTableRow.insertCell(0)
                            let date = new Date(res[key]['fecha_pago'])
                            newRow.textContent = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date
                                .getFullYear();

                            newRow = newTableRow.insertCell(1)
                            newRow.textContent = res[key]['monto'] + " Bs."

                            subtotal += res[key]['monto'];

                        }
                    }
                }
                document.getElementById('saldo').innerHTML =
                    `Saldo: ${(parseFloat(total_cd)-parseFloat(subtotal)).toFixed(1)}`;
                $("#modal1").modal('open')
            },
            error: function(error) {
                console.log(error)
            }
        })
    } else {

    }

}

function detalle(id) {
    $(".dinamic_rows").remove();
    $.ajax({
        url: "recursos/catalogos/detalle.php?id=" + id,
        method: "GET",
        success: function(response) {
            res = JSON.parse(response)
            // console.log(res.length)
            let table = document.getElementById("detalle")
            for (key in res) {
                if (res.hasOwnProperty(key)) {
                    let newTableRow = table.insertRow(-1)
                    newTableRow.className = "dinamic_rows"
                    newRow = newTableRow.insertCell(0)
                    newRow.textContent = res[key]['codpro']

                    newRow = newTableRow.insertCell(1)
                    newRow.textContent = res[key]['descripcion']

                    newRow = newTableRow.insertCell(2)
                    newRow.textContent = res[key]['cant']

                    newRow = newTableRow.insertCell(3)
                    newRow.textContent = res[key]['pubs'] + " Bs."
                }
            }

            $("#modal2").modal('open')
        },
        error: function(error) {
            console.log(error)
        }
    })


}

</script>