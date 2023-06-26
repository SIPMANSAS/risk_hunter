<?php

include '../conexion/conexion.php';

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=InformaciónSabanaCompleta.xls');
$id_inspeccion = $_POST['id_inspeccion'];
?>

<table border="1">
    <thead>
        <th colspan="9"><?php echo utf8_decode("Información de la Inspección");?></th>
        <th colspan="6"><?php echo utf8_decode("Información del Solicitante");?></th>
        <th colspan="4"><?php echo utf8_decode("Información de la firma Inspectora - Inspector");?></th>
        <th colspan="4"><?php echo utf8_decode("Ubicación Geoestacionaria")?></th>
        <th colspan="2"><?php echo utf8_decode("Información de la Inspección")?></th>
    </thead>
    <tr></tr>
    <thead>
        <th><?php echo utf8_decode("Numero de Inspección");?></th>
        <th>Fecha de Solicitud</th>
        <th><?php echo utf8_decode("Compañia de Seguros");?></th>
        <th><?php echo utf8_decode("Nombre de quien asigna la inspección");?></th>
        <th><?php echo utf8_decode("Ubicación de Realización de la Inspección");?></th>
        <th><?php echo utf8_decode("Nombre de la Edificación");?></th>
        <th><?php echo utf8_decode("Dirección del bien"); ?></th>
        <th><?php echo utf8_decode("Fecha de Inspección"); ?></th>
         <th><?php echo utf8_decode("Encargado de realizar la inspección"); ?></th>
        
        <th>Solicitante</th>
         <th><?php echo utf8_decode("Número de Identificación"); ?></th>
        <th>Tomador</th>
         <th><?php echo utf8_decode("Encargado de atender la inspección"); ?></th>
        <th>Contacto del encargado</th>
        <th>Asegurado</th>
        
        <th>Inspector / Firma Inspectora</th>
        <th>Contacto Firma</th>
         <th><?php echo utf8_decode("Compañia del seguros"); ?></th>
        <th>Oficina</th>
        
        <th>Longitud</th>
        <th>Latitud</th>
        <th>Estrato</th>
        <th>Espacio Sociogeografico</th>
        
        <th>Pregunta</th>
        <th>Respuesta</th>
    </thead>
    <tr></tr>
    <tbody>
        <?php
        $consultainformacioninspeccionxsabana = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion' ");
        while($extraerinformacionsabana = $consultainformacioninspeccionxsabana->fetch_array()){
        ?>
        <td><?php echo $extraerinformacionsabana['numero_inspeccion']?></td>
        <td><?php echo $extraerinformacionsabana['fecha_solicitud']?></td>
        <td><?php echo $extraerinformacionsabana['cia_seguros']?></td>
        <td><?php echo $extraerinformacionsabana['nombre_asigna']?></td>
        <td><?php echo $extraerinformacionsabana['departamento'].'-'.$extraerinformacionsabana['ciudad']?></td>
        <td><?php echo $extraerinformacionsabana['nombre_edificacion']?></td>
        <td><?php echo $extraerinformacionsabana['direccion']?></td>
        <td><?php echo $extraerinformacionsabana['fecha_inspeccion']?></td>
        <td>
            <?php 
                $idusuarioinspctor = $extraerinformacionsabana['id_inspector'];
                $consultainspector = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$idusuarioinspctor'");
                $extraerdatosinspectorxsabana = $consultainspector->fetch_array(MYSQLI_ASSOC);
                echo $extraerdatosinspectorxsabana['nombre'].' '.$extraerdatosinspectorxsabana['apellidos'];
            ?>
        </td>
        <td><?php echo $extraerinformacionsabana['nombre_solicita']?></td>
        <td><?php echo $extraerinformacionsabana['des_td_solicitante'].'.'.$extraerinformacionsabana['nid_solicita']?></td>
        <td><?php echo $extraerinformacionsabana['tomador']?></td>
        <td><?php echo $extraerinformacionsabana['nombre_persona_atiende']?></td>
        <td><?php echo $extraerinformacionsabana['contacto_persona_atiende']?></td>
        <td><?php echo $extraerinformacionsabana['asegurado']?></td>
        <td><?php echo $extraerinformacionsabana['inspector_firma_inspectora']?></td>
        <td><?php echo $extraerinformacionsabana['contacto_firma']?></td>
        <td><?php echo $extraerinformacionsabana['cia_seguros']?></td>
        <td><?php echo $extraerinformacionsabana['nombre_oficina']?></td>
        <td><?php echo $extraerinformacionsabana['longitud']?></td>
        <td><?php echo $extraerinformacionsabana['latitud']?></td>
        <td><?php echo $extraerinformacionsabana['estrato']?></td>
        <td><?php echo $extraerinformacionsabana['espacio_geografico']?></td>
        
        <td><?php echo utf8_decode($extraerinformacionsabana['pregunta'])?></td>
        <td><?php echo utf8_decode($extraerinformacionsabana['respuesta'])?></td>
        <tr></tr>
        <?php
        }
        ?>
    </tbody>
</table>