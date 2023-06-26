<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=encuestas.xls');

include 'conexion/conexion.php';

$idencuesta=$_POST['idencuesta'];
$consultaDatos = $mysqli->query("SELECT * FROM v_detalle_encuestas WHERE id_encuesta='$idencuesta'");
?>

<table border="1">
    <tr>
        <th><?php echo utf8_encode('N°')?></th>
        <th>Usuario</th>
        <th>Nombres Inspector</th>
        <th>Fecha Registro</th>
        <th><?php echo utf8_decode('Fecha Creación')?></th>
        <th>Fecha Respuesta</th>
        <th>Pregunta</th>
        <th>Respuesta</th>
    </tr>
    <?php
    
    while($extraerData = $consultaDatos->fetch_assoc()){
        $count=1; echo $count++ .'</td>';
        $usario = $extraerData['usuario'].'</td>';
        $nombresUsuario = $extraerData['nombre'].' '.$extraerData['apellidos'].'</td>';
        $fecha = $extraerData['fecha_registro'].'</td>';
        $pregunta = $extraerData['nom_pregunta'].'</td>';
        $fechacreacion = $extraerData['fecha_creacion'].'</td>';
        $fecharespuesta = $extraerData['fecha_registro'].'</td>';
        $respuesta = $extraerData['respuesta_texto'].'</td>';
    ?>
    <tr>
        <td><?php $count=1; echo $count++;?></td>
        <td><?php echo $usario ?></td>
        <td><?php echo $nombresUsuario ?></td>
        <td><?php echo $fecha ?></td>
        <td><?php echo $fechacreacion ?></td>
        <td><?php echo $fecharespuesta ?></td>
        <td><?php echo $pregunta ?></td>
        <td><?php echo $respuesta ?></td>
    </tr>
    <?php
}
?>
</table>




