<?php
//header('Content-type:application/xls');
//header('Content-Disposition: attachment; filename=respuestas.xls');

include 'conexion/conexion.php';
?>
<table border="1">
    <thead>
       <th>Pregunta</th>
       <th>Respuesta</th>
       <th>Fecha Respuesta</th>
    </thead>
    <tbody>
        <?php
            $consultaDatos = $mysqli->query("SELECT * FROM v_detalle_encuestas WHERE id_encuesta=1");
            while($extraerRespuestas = $consultaDatos->fetch_array()){
            ?>
            <tr>
            <td><?php echo ($extraerRespuestas['usuario'])?></td>
            <td><?php echo $extraerRespuestas['nombre']?></td>
            <td><?php echo $extraerRespuestas['apellidos']?></td>
            </tr>
            <?php
            }
        ?>
    </tbody>
</table>