<?php 
	require('../../recursos/conexion.php');
	session_start();
	$ca=$_SESSION["ca"];
	date_default_timezone_set("America/La_Paz");
	$year = ""; 

	$result = $conexion->query("SELECT * FROM `clientes` WHERE estado = 1 AND lider = ".$ca);
	$result = $result->fetch_all(MYSQLI_ASSOC);
	if ($result) {
		// echo var_dump($result[0]['CA']);
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
    <div class="input-field col s12 m6">
        <i class="material-icons prefix">search</i> 
        <input type="text" id="buscar_experta">
        <label for="buscar_experta">Buscar experta...</label>
    </div>
    <div class="col s12 m12 l12 xl12" id="cards_body">
        <?php foreach($result as $key  => $valor){ ?>
        <div class="col s12 m6 l6 xl6 nunito">
            <div class="z-depth-3 card horizontal card__pad" style="background-color: #ee6e73">
                <div class="card-stacked">
                    <div class="" >
                        <span><b>Nombre: </b><?php echo $valor['nombre'].' '.$valor['apellidos']?></span><br>
                        <span><b>Celular: </b><?php echo $valor['telefono']?></span><br>
                        <span><b>CA: </b><?php echo $valor['CA']?></span><br>
                        <span><b>CI: </b><?php echo $valor['CI']?></span>
                    </div>
                </div>
                <div class="card__img">
                    <div></div>
                    <div>
                        <a href="#" onclick="historial('<?php echo $valor['CA'] ?>')" style="float: right"
                            class="btn waves-effect waves-dark white black-text">Historial</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
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

document.getElementById('buscar_experta').addEventListener('input', () =>{
    let key = document.getElementById('buscar_experta').value;
    let cards_body = document.getElementById('cards_body');
    fetch('recursos/catalogos/filtro_expertas.php?key='+key)
    .then(response => {
        response.json().then(function(res) {  
            let cad = "";
            res.forEach(function(item, index, arr){

                cad = cad + `<div class="col s12 m6 l6 xl6 nunito">
                                <div class="z-depth-3 card horizontal card__pad" style="background-color: #ee6e73">
                                    <div class="card-stacked">
                                        <div class="" >
                                            <span><b>Nombre: </b>${item['nombre']+" "+item['apellidos']}</span><br>
                                            <span><b>Celular: </b>${item['telefono']}</span><br>
                                            <span><b>CA: </b>${item['CA']}</span><br>
                                            <span><b>CI: </b>${item['CI']}</span>
                                        </div>
                                    </div>
                                    <div class="card__img">
                                        <div></div>
                                        <div>
                                            <a href="#" onclick="historial('${item['CA']}')" style="float: right"
                                                class="btn waves-effect waves-dark white black-text">Historial</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            })                
            cards_body.innerHTML = cad;
        })
    })
})
function historial(ca) {
    console.log(ca)
    $("#cuerpo").load("templates/catalogos/historial.php?ca="+ca);
}


</script>