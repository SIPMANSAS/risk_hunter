<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaInspecciones.xls');

require '../conexion/conexion.php';


$result = $mysqli->query("SELECT * FROM `v_parrilla_inspectores`")or die();

?>

<table border="1">
    <tr>
        
        <th class="text-center">Fecha Solicitud</th>
		<th class="text-center"><?php echo utf8_decode ("Número Inspección");?></th>
		<th class="text-center"><?php echo utf8_decode("Nombre Inspector");?></th>
		<th class="text-center">Nombre Solicitante</th>
		<th class="text-center"><?php echo utf8_decode("Tipo Identificación Solicitante");?></th>
		<th class="text-center"><?php echo utf8_decode("Número Identificación Solicitante");?></th>
        <th class="text-center">Ciudad</th>
        <th class="text-center"><?php echo utf8_decode("Dirección");?></th>
        <th class="text-center"><?php echo utf8_decode("Nombre de la Edificación");?></th>
        <th class="text-center">Persona que atiende</th>
        <th class="text-center">Contacto quien atiende</th>
        <th class="text-center">Firma Inspectora</th>
        <th class="text-center">Quien Aigna </th>
        <th class="text-center">Telefono Quien Aigna </th>
        <th class="text-center">Estado</th>
        <th class="text-center"><?php echo utf8_decode("Fecha Inspección");?></th>
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
        <tr>
            <td><?php echo $columna['fecha_solicitud']; ?></td>
            <td><?php echo $columna['numero_inspeccion']; ?></td>
            <td><?php echo utf8_decode($columna['nombre_inspector']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_solicita']); ?></td>
            <td><?php echo $columna['tid_solicita']; ?></td>
            <td><?php echo $columna['nid_solicita']; ?></td>
            <td><?php echo $columna['ciudad']; ?></td>
            <td><?php echo $columna['direccion']; ?></td>
            <td><?php echo utf8_decode($columna['nombre_edificacion']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_persona_atiende']); ?></td>
            <td><?php echo $columna['contacto_persona_atiende']; ?></td>
            <td><?php echo $columna['firma_inspectora']; ?></td>
            <td><?php echo $columna['nombre_asigna']; ?></td>
            <td><?php echo $columna['telefono_asigna']; ?></td>
            <td><?php echo $columna['estado']; ?></td>
            <td><?php echo $columna['fecha_inspeccion']; ?></td>
        </tr>
        <?php
        }
        ?>
    

</table>