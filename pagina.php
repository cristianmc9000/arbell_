<?php
/* consulta prueba 
SELECT b.codp, a.descripcion, c.cantidad, b.fecha_venc FROM productos a, inventario b, invcant c WHERE b.codp = a.id AND b.codp = c.codp AND b.fecha_venc < "2021-10-01" */
/* SELECT b.codp, a.descripcion, c.cantidad, b.fecha_venc FROM productos a, inventario b, invcant c WHERE b.codp = a.id AND b.codp = c.codp;  */
//Reanudamos la sesión
//probando push
require('recursos/sesiones.php');
require('recursos/conexion.php');
session_start();
date_default_timezone_set("America/La_Paz");
$fecha = date('Y-m-d');
$fecha = date ('Y-m-d', strtotime($fecha.'+ 3 month'));

//Comprobamos si el usario está logueado
//Si no lo está, se le redirecciona al index
//Si lo está, definimos el botón de cerrar sesión y la duración de la sesión
if(!isset($_SESSION['usuario']) and $_SESSION['estado'] != 'Autenticado') {
	header('Location: index.php');
} else {
	$estado = $_SESSION['usuario'];
  $ciactual = $_SESSION['userCI']; 
	$salir = '<a href="recursos/salir.php" class="right" target="_self">Cerrar sesión</a>';
};

//consulta para inicio
$Sql = "SELECT a.id, d.nombre, a.descripcion, c.cantidad FROM productos a,   invcant c, lineas d WHERE a.id=c.codp AND a.linea = d.codli AND c.cantidad < 51"; 
$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id'=>$arr['id'],'linea'=>$arr['nombre'], 'descripcion'=>$arr['descripcion'],'cantidad'=>$arr['cantidad']); 
    }}else{
  $fila[] = array('id'=>'--', 'linea'=>'--', 'descripcion'=>'--', 'cantidad'=>'--');
    }

  /* consulta fecha de vencimiento */
  $Sql2 = "SELECT b.codp, d.nombre, a.descripcion, b.fecha_venc FROM productos a, inventario b, lineas d WHERE b.estado = 1 AND a.linea = d.codli AND b.codp = a.id AND b.fecha_venc < '".$fecha."' AND b.fecha_venc > '0000-00-00'";
$Busq2 = $conexion->query($Sql2); 
if((mysqli_num_rows($Busq2))>0){
while($arr = $Busq2->fetch_array()) 
    { 
        $fila2[] = array('id'=>$arr['codp'],'linea'=>$arr['nombre'], 'descripcion'=>$arr['descripcion'],'fecha'=>$arr['fecha_venc']); 
    }}else{
  $fila2[] = array('id'=>'--', 'linea'=>'--', 'descripcion'=>'--', 'fecha'=>'--');
}
?>
<!DOCTYPE html>
<html lang="ES">
<head>
<meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="img/iconoarbell.ico" />
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
body{
  background: linear-gradient(90deg, #ccfff8, #e9fffc);
}
#titulo1{
	/*font-family: Matura MT Script Capitals;*/
	font-family: Homestead Display;
	color: #ffffff;
}
input{
  /*font-weight: bold;*/
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #78827d;
  opacity: 1;
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
.color-nav{
  background-color: #1abc9c;
}
nav ul a:hover {
  background-color: rgba(0, 0, 0, 0.3) !important;
}
nav ul li a:hover {
  background-color: rgba(c, c, 0, 0.3) !important;
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

<nav class="color-nav">
  <div class="nav-wrapper" >
    <ul class="right hide-on-med-and-down">
      <li><img align="center" width="40px" src="img/divisas2.png" alt=""></li>
      <li><input style="width: 40px" placeholder="valor del peso en Bs." id="valor" value="0.07" type="text"></li>
      <li><?php echo $estado; ?></li>
      <li><?php echo $salir; ?></li>
    </ul>

    <ul id="dropdown1" class="dropdown-content">
    <li><a href="#!" onclick="cargar('templates/ventas/a_ventas');">Realizar Venta</a></li>
    <li><a href="#!" onclick="cargar('templates/ventas/reg_ventas');">Registro de Ventas</a></li>
    </ul>

    <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a href="#!" onclick="location.reload();">INICIO</a></li>
        <li><a href="#!" onclick="cargar('templates/usuarios/a_usuarios');">USUARIOS</a></li>
        <li><a href="#!" onclick="cargar('templates/roles/a_roles');">ROLES</a></li>
        <!-- <li><a href="#!" onclick="cargar('templates/ventas/a_ventas');">VENTAS</a></li> -->
        <li><a class="dropdown-button" data-beloworigin="true" href="#!" data-activates="dropdown1">VENTAS<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a href="#!" onclick="cargar('templates/compras/a_compras');">COMPRAS</a></li>
        <li><a href="#!" onclick="cargar('templates/productos/a_prod-periodos');">PRODUCTOS</a></li>
        <li><a href="#!" onclick="cargar('templates/inventarios/a_inventarios.php');">INVENTARIO</a></li>
        <li><a href="#!" onclick="cargar('templates/lider-experta/a_lider-experta');">LIDER/EXPERTA</a></li>
        <li><a href="#!" onclick="cargar('templates/reportes/sel_periodo');">REPORTES</a></li>
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
      <div class="col s6">
        <span class="fuente col s12">
          <div class="col s12"><h3>Productos escasos</h3></div><br>
        </span>
          <!-- TABLA -->
          <div class="col s11">
          <table id="tabla1" class="highlight">
            <thead>
              <tr>
                <th>Código <br> (Producto)</th>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Cantidad</th>
              </tr>
            </thead>
            <!--  -->
            <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
              <tr style="background-color: #F78181">
                <td><?php echo $valor["id"] ?></td>
                <td><?php echo $valor["linea"] ?></td>
                <td><?php echo $valor["descripcion"] ?></td>
                <td><?php echo $valor["cantidad"] ?></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- tabla fechas -->
      <div class="col s6">
        <span class="fuente col s12">
          <div class="col s12"><h3>Productos Próximos a Vencer</h3></div><br>
        </span>
          <!-- TABLA -->
          <div class="col s11">
          <table id="tabla2" class="highlight">
            <thead>
              <tr>
                <th>Código <br> (Producto)</th>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Fecha de <br>Vencimiento</th>
              </tr>
            </thead>
            <!--  -->
            <tbody>
            <?php foreach($fila2 as $a  => $valor){ ?>
              <tr style="background-color: #FFFF00">
                <td><?php echo $valor["id"] ?></td>
                <td><?php echo $valor["linea"] ?></td>
                <td><?php echo $valor["descripcion"] ?></td>
                <td><?php echo $valor["fecha"] ?></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
  $(".dropdown-button").dropdown({ hover: true, beloworigin: true });
  $(".button-collapse").sideNav();
  $('#tabla1').dataTable();
  $('#tabla2').dataTable();
});

  function cargar(x){
    if(x.includes("templates/inventarios")){
      $("#cuerpo").load(x);
    }else{
    var y=".php";
          $("#cuerpo").load(x+y);
        }
  }

</script>
        
</body>

</html>