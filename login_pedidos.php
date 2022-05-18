<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/pedidos.css">
    <link rel="icon" type="image/x-icon" href="images/iconoarbell.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">


    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <title>Ingreso</title>
</head>

<body id="cuerpo">
    <div id="section_1">
        <div class="container">
            <div class="row">
                <h2 class="fuente center">Distribuidora Carmina</h2>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="center img_querie">
                    <img width="" src="images/logo_sin_fondo.png" alt="">
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 5%">
            <!-- <h4 class="fuente center">Ingresa tu código de cliente Arbell</h4> -->

            <div class="row">
                <!-- 				<div class="col s4 m3 l2 offset-l3 xl2 offset-xl3">
					<div class="input-field">
						<i class="material-icons-outlined prefix">phone</i>
						<input class="tam" type="text" id="phoneCode" name="phoneCode" value="+591" disabled>
					</div>
				</div> -->
                <div class="col s10 offset-s1 m8 l4 xl4 offset-m2 offset-l4 offset-xl4">
                    <form id="acceso">
                        <div class="input-field">
                            <input inputmode="numeric" class=" tam" type="password" id="codigo" name="codigo" />
                            <label for="codigo" class="tam">Ingresa tu código Arbell</label>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row">
                <div class="center centrar">
                    <div id="recaptcha-container"></div>
                </div>
            </div>
            <div class="row">
                <div class="center">
                    <button class="btn btn-large waves-effect waves-light red" form="acceso"><i
                            class="material-icons-outlined right">lock</i>Ingresar</button>
                </div>
            </div>
        </div>
    </div>

</body>
<input type="text" id="existe" value="false" hidden>

<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
<script>
$("#acceso").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("acceso"));
    $.ajax({
        url: "recursos/catalogos/acceder.php",
        type: "POST",
        dataType: "HTML",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(echo) {
        if (echo == '2') {
            return M.toast({
                html: 'Usuario inhabilitado.'
            })
        }
        if (echo != "1") {
            return M.toast({
                html: 'Código Arbell incorrecto.'
            })
        }
        if (echo == '1') {
            return window.location.replace("pedidos.php");
        }
    });
});
</script>

</html>