<?php
//Reanudamos la sesión
//probando push
session_start();

//Comprobamos si el usario está logueado
//Si no lo está, se le redirecciona al index
//Si lo está, definimos el botón de cerrar sesión y la duración de la sesión
if(!isset($_SESSION['usuario']) and $_SESSION['estado'] != 'Autenticado') {
	header('Location: index.php');

} else {

	$estado = $_SESSION['usuario'];
  $ciactual = $_SESSION['userCI']; 
	$salir = '<a href="recursos/salir.php" class="right" target="_self">Cerrar sesión</a>';

require('recursos/sesiones.php');
};

require('recursos/conexion.php');
$Sql = "SELECT id, descripcion, cantidad FROM productos WHERE cantidad < 71 and estado=1"; 
$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'], 'descripcion'=>$arr['descripcion'], 'cantidad'=>$arr['cantidad']); 
    }}else{
  $fila[] = array('id'=>'--','descripcion'=>'--','cantidad'=>'--');
}
?>

<!DOCTYPE html>
<html lang="ES">

<head>
<meta charset="utf-8">


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/datatable.css">
  <link rel="stylesheet" type="text/css" href="css/materialize.css">
  
  <script src="js/materialize.js"></script>
  <script src="js/datatable.js"></script>


<title> Arbell, Número de teléfono(s): 6637037, E-mail: arbellcarmina@gmail.com</title>
<style>
#titulo1{
	/*font-family: Matura MT Script Capitals;*/
	font-family: Homestead Display;
	color: #ffffff;

}
.fuente{
  font-family: Segoe UI Light;
}

@media only screen and (max-width: 1000px) {
	  #titulo1{
	  	display: none;
	  }
    #imprimir{
      display:none;
    }
}
@media only screen and (max-width: 1300px) {
	  #titulo2{
	  	display: none;
	  }
}
nav ul a:hover {
  background-color: rgba(0, 0, 0, 0.3) !important;
}

.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}
table.highlight > tbody > tr:hover {
  background-color: #a0aaf0 !important;
}

.color-amarillo{
  background-color:  #FFFF01 !important;
}
.color-rojo{
  background-color: #FFBBBB !important;
}
.divisas{
    width: 100%;
    height: auto;
    object-fit: cover;
}
</style>
</head>

<body>

  
<ul id="dropdown1" class="dropdown-content">
  <!--<li><a href="#!" onclick="cargar('eliminados');">Productos Activos</a></li>-->
  <li><a href="#!" onclick="cargar('art_eliminados');">Productos Eliminados</a></li>
</ul>




  <nav>
    <div class="nav-wrapper" >

      <ul class="right hide-on-med-and-down">
        <li><img align="center" width="40px" src="img/divisas2.png" alt=""></li>
        <li><input placeholder="valor del peso en Bs." id="valor" value="0.07" type="text"></li>
        <li><?php echo $estado; ?></li>
        <li><?php echo $salir; ?></li>
      </ul>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <!--<li style="background-color: black;">-->
        <li><a href="#!" onclick="location.reload();">INICIO</a></li>
        <li><a href="#!" onclick="cargar('templates/usuarios/a_usuarios');">USUARIOS</a></li>
        <li><a href="#!" onclick="cargar('templates/roles/a_roles');">ROLES</a></li>
        <li><a href="#!" onclick="cargar('templates/ventas/a_ventas');">VENTAS</a></li>
        <li><a href="#!" onclick="cargar('templates/compras/a_compras');">COMPRAS</a></li>
        <li><a href="#!" onclick="cargar('templates/productos/a_prod-periodos');">PRODUCTOS</a></li>
        <li><a href="#!" onclick="cargar('templates/lider-experta/a_lider-experta');">LIDER/EXPERTA</a></li>
        
        <li><a href="#!" onclick="cargar('sel_fecha');">REPORTES</a></li>


        <li class="brand-logo"></li>        
      </ul>

      <a href="#!" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>


    <ul class="side-nav" id="mobile-demo">
    <li><?php echo $estado, $ciUSER; ?></li>
    <li><a href="#!" onclick="location.reload();">INICIO</a></li>
    <li><a href="#!" onclick="cargar('productos');">Ventas</a></li>
    <li><a href="#!" onclick="cargar('inventario');">Productos</a></li>
    <li><a href="#!" onclick="cargar('clientes');">Clientes</a></li>
    <li><a href="#!" onclick="cargar('sel_fecha');">Registro de ventas</a></li>
    <li><a href="#!" onclick="cargar('Prod_vendidos');">Prod. Vendidos</a></li>
    <!--<li><a href="#!" onclick="cargar('reportes');">Reportes</a></li>-->
    <li><?php echo $salir; ?></li>
      </ul>

    </div>
  </nav>


<div class="row">
    <div id="cuerpo" class="col s12">
      
        <span class="fuente col s12">
          <div class="col s4"><h3>Productos escasos</h3></div><br>
        </span>

        <!-- TABLA -->
        <div class="col s10">
        <table id="tabla1" class="highlight">
          <thead>
            <tr>
                <th>Código <br> (Producto)</th>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Fecha de <br>vencimiento</th> 

            </tr>
          </thead>

        <!-- <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
            <tr style="background-color: #F78181">
              <td><?php echo $valor["id"] ?></td>
              <td><?php echo $valor["descripcion"] ?></td>
              <td><?php echo $valor["cantidad"] ?></td>
            </tr>
            <?php }?>
          </tbody>-->

          <tbody>
            <tr class="color-rojo">
              <td>122Pdsdsaasasasdsssd1</td>
              <td>Origenes</td>
              <td>Crema corporal enebro 100g</td>
              <td>29</td>
              <td>20/12/2022</td>
            </tr>
            <tr class="color-amarillo">
              <td>F200</td>
              <td>Inspiraciones</td>
              <td>Fragancia femenina simil ch 212 carola 50ml</td>
              <td>120</td>
              <td>10/05/2021</td>
            </tr>
            <tr class="color-rojo">
              <td>1212</td>
              <td>Origenes</td>
              <td>Lavanda bruma para almohada 75ml</td>
              <td>20</td>
              <td>18/11/2022</td>
            </tr>
            <tr class="color-amarillo">
              <td>F201</td>
              <td>Inspiraciones</td>
              <td>Fragancia femenina simil ch carola 50ml</td>
              <td>200</td>
              <td>20/04/2021</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
  $(".dropdown-button").dropdown({ hover: true });
  $(".button-collapse").sideNav();
  $('#tabla1').dataTable();
});

  function cargar(x){
    var y=".php";
          $("#cuerpo").load(x+y);
  }

</script>
        
</body>

</html>