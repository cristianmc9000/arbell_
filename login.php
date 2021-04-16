<!DOCTYPE html>
  <head>
    <title>login</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/master.css">
  </head>

  <body>
  
    <div class="login-box">
        <img class="avatar" src="img/logo.png" alt="Logo Arbell">
        <h1>Ingresar al Sistema</h1>
        <form>
            <!-- Usuario -->
            <label for="username">Usuario</label>
            <input type="text" placeholder="Ingresar Usuario">
            
            <!-- Contrasseña -->
            <label for="password">Password</label>
            <input type="password" placeholder="Ingresar Password">

            <input type="submit" value="Ingresar"> 



        </form>



    </div>
    <div class="modal-footer row">
     	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>


<div class="row">
	<div class="col s4 offset-s1">
	
		<h4 class="fuente">Accede a tu cuenta</h4>
	</div>
</div>
<div class="formulario-acceso">
<form method="POST" id="acceso" action="" accept-charset="utf-8" class="col s12">

	<div class="row">
		<div class="input-field col s3 offset-s1">
			<i class="material-icons prefix">account_circle</i>
			<input type="text" name="userAcceso" class="acceso validate" id="userAcceso"  autocomplete="off" maxlength="20">
			<label for="userAcceso">CI</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s3 offset-s1">
		<i class="material-icons prefix">https</i>
		<input type="password" name="passAcceso" class="acceso" id="passAcceso"  autocomplete="off" maxlength="20">
		<label for="passAcceso">Contraseña</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s3 offset-s1">
			<button class="btn waves-effect waves-light" type="submit" name="acceso">Ingresar
			<i class="material-icons right">send</i></button>
    </div>
</div>
	
</form>
</div>



<script>

//Guardamos el controlador del div con ID mensaje en una variable
var mensaje = $("#mensaje");
//Ocultamos el contenedor
mensaje.hide();

//Cuando el formulario con ID acceso se envíe...
$("#acceso").on("submit", function(e){
	//Evitamos que se envíe por defecto
	e.preventDefault();
	//Creamos un FormData con los datos del mismo formulario
	var formData = new FormData(document.getElementById("acceso"));

	//Llamamos a la función AJAX de jQuery
	$.ajax({
		//Definimos la URL del archivo al cual vamos a enviar los datos
		url: "recursos/acceder.php",
		//Definimos el tipo de método de envío
		type: "POST",
		//Definimos el tipo de datos que vamos a enviar y recibir
		dataType: "HTML",
		//Definimos la información que vamos a enviar
		data: formData,
		//Deshabilitamos el caché
		cache: false,
		//No especificamos el contentType
		contentType: false,
		//No permitimos que los datos pasen como un objeto
		processData: false
	}).done(function(echo){
		//Una vez que recibimos respuesta
		//comprobamos si la respuesta no es vacía
		if (echo !== "") {
			
			//Si hay respuesta (error), mostramos el mensaje
			mensaje.html(echo);
			mensaje.show();
		} else {
			//Si no hay respuesta, redirecionamos a donde sea necesario
			//Si está vacío, recarga la página

			window.location.replace("index.php");
		}
	});
});

//Cuando el formulario con ID acceso se envíe...
$("#registro").on("submit", function(e){
	//Evitamos que se envíe por defecto
	e.preventDefault();
	//Creamos un FormData con los datos del mismo formulario
	var formData = new FormData(document.getElementById("registro"));


	//Llamamos a la función AJAX de jQuery
	$.ajax({
		//Definimos la URL del archivo al cual vamos a enviar los datos
		url: "recursos/registro.php",
		//Definimos el tipo de método de envío
		type: "POST",
		//Definimos el tipo de datos que vamos a enviar y recibir
		dataType: "HTML",
		//Definimos la información que vamos a enviar
		data: formData,
		//Deshabilitamos el caché
		cache: false,
		//No especificamos el contentType
		contentType: false,
		//No permitimos que los datos pasen como un objeto
		processData: false
	}).done(function(echo){
		//Cuando recibamos respuesta, la mostramos
		mensaje.html(echo);
		mensaje.show();
	});
});


</script>

</body>
</html>