<?php
error_reporting(E_ERROR);
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=ListaInspecciones.xls');

require '../conexion/conexion.php';


$result = $mysqli->query("SELECT en.identificador,en.tid_solicita,en.fecha_solicitud,en.numero_inspeccion,
                          en.nombre_solicita,en.nid_solicita,en.tomador,en.asegurado,us.nombre,us.apellidos,
                          ter.nombres as Cia,pa.nombre AS Pais,ci.nombre AS ciudad,de.nombre 
                          AS departamento,en.direccion,en.nombre_edificacion,en.nombre_persona_atiende,
                          en.contacto_persona_atiende,en.id_firma_inspectora,en.id_bienes_inspeccionar,en.fecha_inspeccion,
                          en.contacto_firma FROM sg_usuarios us ,enc_inspeccion en, ter_terceros ter,rg_paises pa,
                          rg_ciudades ci,rg_departamentos de 
                          WHERE en.id_usuario = us.identificador 
                          AND ter.identificacion = en.id_cia_seguros 
                          AND pa.codigo = en.id_pais 
                          AND ci.codigo = en.id_ciudad 
                          AND de.codigo = en.id_departamento 
                          GROUP BY identificador ASC")or die();

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
        <th class="text-center">Pais </th>
        <th class="text-center">Departamento</th>
        <th class="text-center">Ciudad</th>
        <th class="text-center"><?php echo utf8_decode("Dirección");?></th>
        <th class="text-center"><?php echo utf8_decode("Nombre de la Edificación");?></th>
        <th class="text-center">Persona que atiende</th>
        <th class="text-center">Contacto quien atiende</th>
        <th class="text-center">Firma Inspectora</th>
        <th class="text-center">Contacto firma inspectora</th>
        <th class="text-center"><?php echo utf8_decode("Fecha Inspección");?></th>
        
    </tr>
    <?php
        
        while ($columna = mysqli_fetch_array( $result )){
            
    ?>
        <tr>
            <td><?php echo $columna['fecha_solicitud']; ?></td>
            <td><?php echo $columna['numero_inspeccion']; ?></td>
            <td><?php echo utf8_decode($columna['Cia']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_solicita']); ?></td>
            <td><?php echo $columna['tid_solicita']; ?></td>
            <td><?php echo $columna['nid_solicita']; ?></td>
            <td><?php echo utf8_decode($columna['tomador']); ?></td>
            <td><?php echo utf8_decode($columna['asegurado']); ?></td>
            <td><?php echo $columna['Pais']; ?></td>
            <td><?php echo ($columna['departamento']); ?></td>
            <td><?php echo $columna['ciudad']; ?></td>
            <td><?php echo $columna['direccion']; ?></td>
            <td><?php echo utf8_decode($columna['nombre_edificacion']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_persona_atiende']); ?></td>
            <td><?php echo $columna['contacto_persona_atiende']; ?></td>
            <td><?php echo $columna['id_firma_inspectora']; ?></td>
            <td><?php echo $columna['contacto_firma']; ?></td>
            <td><?php echo $columna['fecha_inspeccion']; ?></td>
        </tr>
        <?php
        }
        ?>
    

</table>