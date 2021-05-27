<?php 
  date_default_timezone_set("America/La_Paz");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }


/*
.fijo{

  max-width: 250px;

}*/
.auto-imagen{

 width: 70%;

}

  </style>
</head>
<body>

<span class="fuente"><h3>Seleccione el periodo</h3></span>

<form action="recursos/redireccionador.php" method="post" class="col s12" id="ffecha">
    <div class="input-field col s3">
        <select name = "anio" id="anio">
          <option value="2021" '<?php if(date("Y") == "2021"){echo "selected";} ?>'><b>2021</b></option>
          <option value="2022" '<?php if(date("Y") == "2022"){echo "selected";} ?>'><b>2022</b></option>
          <option value="2023" '<?php if(date("Y") == "2023"){echo "selected";} ?>'><b>2023</b></option>
          <option value="2024" '<?php if(date("Y") == "2024"){echo "selected";} ?>'><b>2024</b></option>
        </select>
        <label><b>SELECCIONE EL PERIODO</b></label>
    </div>
    <input type="text" name="mes" id="mes" value="" hidden>

  <br><br>
<!-- <button class="btn waves-effect waves-light" type="submit">Aceptar</button> -->
</form>
<div class="row center">

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('01');" >

      <img class="auto-imagen" src="img/periodos/1.png" >

  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('02');" >

      <img class="auto-imagen" src="img/periodos/2.png" >

  </a>
</div>


<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('03');" >

      <img class="auto-imagen" src="img/periodos/3.png" >

  </a>
</div>
</div>
<div class="row center">

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('04');" >


      <img class="auto-imagen" src="img/periodos/4.png" >


  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('05');" >

      <img class="auto-imagen" src="img/periodos/5.png" >
    
  
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('06');" >

      <img class="auto-imagen" src="img/periodos/6.png" >

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