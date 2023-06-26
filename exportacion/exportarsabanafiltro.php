 <?php

//header('Content-type:application/xls');
//header('Content-Disposition: attachment; filename=Sabana.xls');
include  "clases/bloques.class.php";
require '../conexion/conexion.php';
    
if(isset($_POST['buscar'])){
    
    $fechaInicial = trim($_POST['fechaInicial']);
    $fechaFinal = trim($_POST['fechaFinal']);
    $companiaseguros = trim($_POST['companiaseguros']);
    $numeroInspeccion = trim($_POST['numeroInspeccion']);
    $firmainspectora = trim($_POST['firmainspectora']);
    $inspector = trim($_POST['inspector']);

    $consulta = $mysqli->query("SELECT * FROM v_sabana v WHERE v.fecha_inspeccion BETWEEN '$fechaInicial' AND '$fechaFinal' AND v.id_cia_seguros LIKE '$companiaseguros' AND v.id_firma_inspectora LIKE '$firmainspectora' AND v.id_inspector LIKE '$inspector' AND v.numero_inspeccion LIKE '$numeroInspeccion'");
    echo "SELECT * FROM v_sabana v WHERE v.fecha_inspeccion BETWEEN '$fechaInicial' AND '$fechaFinal' AND v.id_cia_seguros LIKE '$companiaseguros' AND v.id_firma_inspectora LIKE '$firmainspectora' AND v.id_inspector LIKE '$inspector' AND v.numero_inspeccion LIKE '$numeroInspeccion'";
    ?>
    <table border="1" >
    <tr>
		<th class="text-center"><?php echo utf8_decode ("Número Inspección");?></th>
		<th class="text-center">Fecha de Solicitud</th>
		<th class="text-center"><?php echo utf8_decode("Compañia de Seguros");?></th>
		<th class="text-center">Nombre Solicitante</th>
		<th class="text-center">Tipo Documento</th>
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
        <th class="text-center">Persona que asigna</th>
        <th class="text-center">Firma Inspectora</th>
        <th class="text-center">Contacto firma inspectora</th>
        <th class="text-center"><?php echo utf8_decode("Fecha Inspección");?></th>
        <th class="text-center"><?php echo utf8_decode("Estado");?></th>
        <th class="text-center"><?php echo utf8_decode("Pregunta");?></th>
        <th class="text-center"><?php echo utf8_decode("Respuesta");?></th>
        <th class="text-center"><?php echo utf8_decode("Suma Bienes");?></th>
    </tr>
    <?php
        while ($columna = mysqli_fetch_array($consulta)){
    ?>
        <tr>
            <td><?php echo $columna['numero_inspeccion']; ?></td>
            <td><?php echo utf8_decode($columna['fecha_solicitud']); ?></td>
            <td><?php echo utf8_decode($columna['cia_seguros']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_solicita']); ?></td>
            <td><?php echo $columna['des_td_solicitante']; ?></td>
            <td><?php echo $columna['nid_solicita']; ?></td>
            <td><?php echo utf8_decode($columna['tomador']); ?></td>
            <td><?php echo utf8_decode($columna['asegurado']); ?></td>
            <td><?php echo $columna['pais']; ?></td>
            <td><?php echo ($columna['departamento']); ?></td>
            <td><?php echo $columna['ciudad']; ?></td>
            <td><?php echo $columna['direccion']; ?></td>
            <td><?php echo utf8_decode($columna['nombre_edificacion']); ?></td>
            <td><?php echo utf8_decode($columna['nombre_persona_atiende']); ?></td>
            <td><?php echo $columna['contacto_persona_atiende']; ?></td>
            <td><?php echo $columna['nombre_asigna']; ?></td>
            <td><?php echo $columna['firma_inspectora']; ?></td>
            <td><?php echo $columna['contacto_firma']; ?></td>
            <td><?php echo $columna['fecha_inspeccion']; ?></td>
            <td><?php echo $columna['estado']; ?></td>
            <td><?php echo $columna['pregunta']; ?></td>
            <td><?php echo $columna['respuesta']; ?></td>
            <td><?php echo $columna['suma_bienes']; ?></td>
        </tr>
        <?php
        }
        ?>
</table>
  <?php
  }
  ?>