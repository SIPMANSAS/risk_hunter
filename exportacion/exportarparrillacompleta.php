

<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=Sabana.xls');

require '../conexion/conexion.php';


$result = $mysqli->query("SELECT * FROM v_sabana")or die();

?>

<table border="1">
    <tr>
        
        <th class="text-center">Fecha Solicitud</th>
		<th class="text-center"><?php echo utf8_decode ("Número Inspección");?></th>
		<th class="text-center"><?php echo utf8_decode("Compañia de Seguros");?></th>
		<th class="text-center">Nombre Solicitante</th>
		<th class="text-center"><?php echo utf8_decode("Tipo Identificación Solicitante");?></th>
		<th class="text-center"><?php echo utf8_decode("Número Identificación Solicitante");?></th>
		<th class="text-center">Tomador</th>
		<th class="text-center">Asegurado</th>
		<th class="text-center">Pais</th>
		<th class="text-center">Departamento</th>
        <th class="text-center">Ciudad</th>
        <th class="text-center"><?php echo utf8_decode("Dirección");?></th>
        <th class="text-center"><?php echo utf8_decode("Nombre de la Edificación");?></th>
        <th class="text-center">Persona que atiende</th>
        <th class="text-center">Contacto quien atiende</th>
        <th class="text-center">Firma Inspectora</th>
        <th class="text-center">Inspector Firma Inspectora</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Longitud</th>
        <th class="text-center">Latitud</th>
        <th class="text-center">Espacio Geografico</th>
        <th class="text-center">Estrato</th>
        <th class="text-center"><?php echo utf8_decode("Fecha Inspección");?></th>
        <th class="text-center"><?php echo utf8_decode("Pregunta");?></th>
        <th class="text-center"><?php echo utf8_decode("Respuesta");?></th>
        <th class="text-center"><?php echo utf8_decode("Suma Bienes");?></th>
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
        <tr>
            <td><?php echo $columna['fecha_solicitud']; ?></td>
            <td><?php echo $columna['numero_inspeccion']; ?></td>
            <td><?php echo ($columna['cia_seguros']); ?></td>
            <td><?php echo ($columna['nombre_solicita']); ?></td>
            <td><?php echo $columna['des_td_solicitante']; ?></td>
            <td><?php echo $columna['nid_solicita']; ?></td>
            <td><?php echo utf8_decode($columna['tomador']); ?></td>
            <td><?php echo utf8_decode($columna['asegurado']); ?></td>
            <td><?php echo utf8_decode($columna['pais']); ?></td>
            <td><?php echo utf8_decode($columna['departamento']); ?></td>
            <td><?php echo $columna['ciudad']; ?></td>
            <td><?php echo $columna['direccion']; ?></td>
            <td><?php echo ($columna['nombre_edificacion']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_persona_atiende']); ?></td>
            <td><?php echo $columna['contacto_persona_atiende']; ?></td>
            <td><?php echo $columna['firma_inspectora']; ?></td>
            <td><?php echo $columna['inspector_firma_inspectora']; ?></td>
            <td><?php echo $columna['estado']; ?></td>
            <td><?php echo $columna['longitud']; ?></td>
            <td><?php echo $columna['latitud']; ?></td>
            <td><?php echo $columna['espacio_geografico']; ?></td>
            <td><?php echo $columna['estrato']; ?></td>
            <td><?php echo $columna['fecha_inspeccion']; ?></td>
            <td><?php echo utf8_encode($columna['pregunta']); ?></td>
            <td><?php echo $columna['respuesta']; ?></td>
            <td><?php echo $columna['suma_bienes']; ?></td>
        </tr>
        <?php
        }
        ?>
    

</table>