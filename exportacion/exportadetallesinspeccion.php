<?php
///Desde el server local aaaaaa

include '../conexion/conexion.php';

$numeroInspeccion = $_POST['numeroInspeccion'];

if(isset($_POST['buscardetalleinspeccion'])){   
    //header('Content-type:application/xls');
    //header('Content-Disposition: attachment; filename=Respuestas_Encuesta '.$numeroInspeccion.'.xls');
    
    $consultaidentificadorinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE numero_inspeccion = '$numeroInspeccion'");
    $extraerinformacion = $consultaidentificadorinspeccion->fetch_array(MYSQLI_ASSOC);
    $identificadorinspeccion = $extraerinformacion['identificador'];
        
    
        
    ?>    
    <table border="1">
        <tr>
            <th><?php echo ("Pregunta ");?></th>
            <th><?php echo ("Respuesta");?></th>
        </tr>
            <?php
            $consultadetallesinspeccion = $mysqli->query("SELECT P.nombre,D.respuesta_texto FROM enc_detalles_inspeccion D,enc_preguntas P WHERE D.id_inspeccion = '$identificadorinspeccion' AND P.identificador = D.id_pregunta;");
            while($extraerinformaciondetalleinspeccion = $consultadetallesinspeccion->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo utf8_decode($extraerinformaciondetalleinspeccion['nombre']); ?></td>
                <td><?php echo utf8_decode($extraerinformaciondetalleinspeccion['respuesta_texto']); ?></td>
            </tr>
            <?php
            }
            ?>
    </table>
<?php
}

if(isset($_POST['v_matriz_rb'])){
    //header('Content-type:application/xls');
    //header('Content-Disposition: attachment; filename=Valoración_Riesgos '.$numeroInspeccion.'.xls');
    
    $consultaidentificadorinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE numero_inspeccion = '$numeroInspeccion'");
    $extraerinformacion = $consultaidentificadorinspeccion->fetch_array(MYSQLI_ASSOC);
    $identificadorinspeccion = $extraerinformacion['identificador'];
    ?>
    <table border="1">
        <tr>
            <th><?php echo utf8_decode("Descripción Riesgo ");?></th>
            <th><?php echo ("Inmueble");?></th>
            <th><?php echo ("Nivel de Riesgo");?></th>
            <th><?php echo utf8_decode("Calificación de Riesgo");?></th>
        </tr>
            <?php
            $consultavmatrizrb = $mysqli->query("SELECT * FROM v_matriz_r_b WHERE id_inspeccion = '$identificadorinspeccion'");
            while($extraerinformacionvmatrizrb = $consultavmatrizrb->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo utf8_decode($extraerinformacionvmatrizrb['dsp_riesgo']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionvmatrizrb['inmueble']); ?></td>
                <td><?php echo round($extraerinformacionvmatrizrb['nr'],2); ?></td>
                <td><?php echo round($extraerinformacionvmatrizrb['CR'],2); ?></td>
            </tr>
            <?php
            }
            ?>
    </table>
    <?php
    
    
}

if(isset($_POST['calificacionxriesgo'])){
    //header('Content-type:application/xls');
    //header('Content-Disposition: attachment; filename=Valoración_por_Inmueble '.$numeroInspeccion.'.xls');
    
    $consultaidentificadorinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE numero_inspeccion = '$numeroInspeccion'");
    $extraerinformacion = $consultaidentificadorinspeccion->fetch_array(MYSQLI_ASSOC);
    $identificadorinspeccion = $extraerinformacion['identificador'];
    
    ?>
    <table border="1">
        <tr>
            <th><?php echo ("Riesgo ");?></th>
            <th><?php echo ("Nivel de Riesgo");?></th>
            <th><?php echo utf8_decode("Calificación de Riesgo");?></th>
        </tr>
            <?php
            $consultavrsultadomatripr = $mysqli->query("SELECT * FROM v_resultados_matriz_p_r WHERE id_inspeccion = '$identificadorinspeccion'");
            while($extraerinformacionpr = $consultavrsultadomatripr->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo utf8_decode($extraerinformacionpr['dsp_riesgo']); ?></td>
                <td><?php echo round($extraerinformacionpr['NR'],2); ?></td>
                <td><?php echo round($extraerinformacionpr['CR'],2); ?></td>
            </tr>
            <?php
            }
            ?>
    </table>
    <?php
    
}

if(isset($_POST['V_matriz_p_r'])){
    header('Content-type:application/xls');
    header('Content-Disposition: attachment; filename=Riesgos_Vs_Respuestas '.$numeroInspeccion.'.xls');
    
    $consultaidentificadorinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE numero_inspeccion = '$numeroInspeccion' ");
    $extraerinformacion = $consultaidentificadorinspeccion->fetch_array(MYSQLI_ASSOC);
    $identificadorinspeccion = $extraerinformacion['identificador'];
    
    ?>
    <table border="1">
        <tr>
            <th><?php echo ("Pregunta");?></th>
            <th><?php echo ("Riesgo");?></th>
            <th><?php echo ("Respuesta Inspector");?></th>
            <th><?php echo ("Respuesta Activa Riesgo");?></th>
        </tr>
            <?php
            $consultavrsultadomatripr = $mysqli->query("SELECT * FROM v_matriz_p_r WHERE id_inspeccion ='$identificadorinspeccion' ORDER BY `v_matriz_p_r`.`pregunta` ASC");
            while($extraerinformacionpr = $consultavrsultadomatripr->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo utf8_decode($extraerinformacionpr['pregunta']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['dsp_riesgo']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['respuesta_inspector']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['respuesta_activa_riesgo']); ?></td>
            </tr>
            <?php
            }
            ?>
    </table>
    <?php
    
}

if(isset($_POST['r_matriz_pr'])){
    header('Content-type:application/xls');
    header('Content-Disposition: attachment; filename=Resultado_Matriz_PR '.$numeroInspeccion.'.xls');
    

    $consultaidentificadorinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE numero_inspeccion = '$numeroInspeccion' ");
    $extraerinformacion = $consultaidentificadorinspeccion->fetch_array(MYSQLI_ASSOC);
    $identificadorinspeccion = $extraerinformacion['identificador'];
    
    ?>
    <table border="1">
        <tr>
            <th><?php echo utf8_decode("Descripción Riesgo");?></th>
            <th><?php echo utf8_decode("Inmueble");?></th>
            <th><?php echo ("PR");?></th>
            <th><?php echo ("PA");?></th>
            <th><?php echo ("PNA");?></th>
            <th><?php echo ("Delta");?></th>
            <th><?php echo ("NR");?></th>
            <th><?php echo ("1_NR");?></th>
            <th><?php echo ("1_N");?></th>
            <th><?php echo ("N_1");?></th>
            <th><?php echo ("CR");?></th>
        </tr>
            <?php
            $consultavrsultadomatripr = $mysqli->query("SELECT * FROM v_resultados_matriz_p_r WHERE id_inspeccion = '$identificadorinspeccion' ORDER BY v_resultados_matriz_p_r.riesgo ASC");
            while($extraerinformacionpr = $consultavrsultadomatripr->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo utf8_decode($extraerinformacionpr['dsp_riesgo']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['inmueble']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['PR']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['PA']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['PNA']); ?></td>
                <td><?php echo round($extraerinformacionpr['dELTA'],2); ?></td>
                <td><?php echo round($extraerinformacionpr['NR'],2); ?></td>
                <td><?php echo round($extraerinformacionpr['1_NR'],2); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['1_N']); ?></td>
                <td><?php echo utf8_decode($extraerinformacionpr['N_1']); ?></td>
                <td><?php echo round($extraerinformacionpr['CR'],2); ?></td>
            </tr>
            <?php
            }
            ?>
    </table>
    <?php
}




































?>
