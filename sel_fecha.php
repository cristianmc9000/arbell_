
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
          <option value="2017" selected><b>2017</b></option>
          <option value="2018"><b>2018</b></option>
          <option value="2019"><b>2019</b></option>
          <option value="2020"><b>2020</b></option>
        </select>
        <label><b>SELECCIONE EL AÑO</b></label>
    </div>
    <input type="text" name="mes" id="mes" value="" hidden>

  <br><br>
<!-- <button class="btn waves-effect waves-light" type="submit">Aceptar</button> -->
</form>
<div class="row col s12">

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('01');" >
  <div class="card z-depth-5" >
    <div class="card-image center" onmouseover="hover2.playclip();" style="background-color: green !important;" >
      <img src="img/meses/enero.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('02');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <div style="background-color: green;"><img src="img/meses/febrero.png" ></div>
    </div>
  </div>
  </a>
</div>


<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('03');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/marzo.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('04');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/abril.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('05');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/mayo.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('06');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/junio.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('07');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/julio.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('08');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/agosto.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('09');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/septiembre.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('10');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/octubre.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('11');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/nov.png" >
    </div>
  </div>
  </a>
</div>

<div class="fijo col s3" >
  <a href="#" onclick="enviarfecha('12');" >
  <div class="card z-depth-5">
    <div class="card-image center" onmouseover="hover2.playclip();" >
      <img src="img/meses/dic.png" >
    </div>
  </div>
  </a>
</div>

</div>


<!--            <div class="modal-footer">
                <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
            -->


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
   
   $("#cuerpo").load("ventas.php?anio="+anio+"&mes="+mes);

   
}

</script>
</body>
</html>