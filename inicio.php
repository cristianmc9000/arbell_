<?php 
require('recursos/conexion.php');


$Sql = "SELECT codigo, modelo, cantidad FROM productos WHERE estado=1 and sucursal=".$suc.""; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('cod'=>$arr['codigo'], 'modelo'=>$arr['modelo'], 'cantidad'=>$arr['cantidad']); 
    }
?>
      <div id="contenido_inicial">
        <span class="fuente col s12">
          <div class="col s4"><h3>Productos escasosss</h3></div><br>
        </span>

        <!-- TABLA -->
        <table id="tabla1" class="highlight">
          <thead>
            <tr>
                <th>Código\r(Producto)</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha de\rvencimiento</th>

            </tr>
          </thead>

          <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
            <tr>
              <td><?php echo $valor["cod"] ?></td>
              <td><?php echo $valor["modelo"] ?></td>
              <td><?php echo $valor["cantidad"] ?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>

      </div>