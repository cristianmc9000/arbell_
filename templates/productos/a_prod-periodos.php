
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }



.fijo{

  max-width: 250px;

}

  </style>
</head>
<body>

<span class="fuente"><h3>Seleccione la fecha</h3></span>

<form action="recursos/redireccionador.php" method="post" class="col s12" id="ffecha">
    <div class="input-field col s3">
        <select name = "anio" id="anio">
          <option value="2017" selected><b>2021</b></option>
          <option value="2018"><b>2022</b></option>
          <option value="2019"><b>2023</b></option>
          <option value="2020"><b>2024</b></option>
        </select>
        <label><b>SELECCIONE EL AÑO</b></label>
    </div>
    <input type="text" name="mes" id="mes" value="" hidden>

  <br><br>
<!-- <button class="btn waves-effect waves-light" type="submit">Aceptar</button> -->
</form>
<div class="row">

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('1');" >
  <div class="card z-depth-5" >
    <div class="card-image center">
      <img src="img/periodos/1.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('2');" >
  <div class="card z-depth-5">
    <div class="card-image center" >
      <img src="img/periodos/2.png" >
    </div>
  </div>
  </a>
</div>


<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('3');" >
  <div class="card z-depth-5">
    <div class="card-image center">
      <img src="img/periodos/3.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('4');" >
  <div class="card z-depth-5">
    <div class="card-image center">
      <img src="img/periodos/4.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('5');" >
  <div class="card z-depth-5">
    <div class="card-image center">
      <img src="img/periodos/5.png">
    </div>
  </div>
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('6');" >
  <div class="card z-depth-5">
    <div class="card-image center">
      <img src="img/periodos/6.png" >
    </div>
  </div>
  </a>
</div>


</div>




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



<script>

var mensaje = $("#mensaje");
mensaje.hide();


  $(document).ready(function() {
    $('select').material_select();
  });


function enviarfecha(mes_recibido) {
   
   anio = document.getElementById('anio').value;
   document.getElementById('mes').value = mes_recibido;
   mes = mes_recibido;
   
   $("#cuerpo").load("templates/productos/ventas.php?anio="+anio+"&mes="+mes);

   
}

</script>
</body>
</html>