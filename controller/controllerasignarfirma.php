<?php

include '../conexions.php';

if(isset($_POST['asignarfirmasinspectoras'])){
    'Compañia Seguros: '.$companiaseguros = $_POST['companiaseguros'];
    'Fecha Inicial: '.$fechaInicial = $_POST['fechaInicial'];
    '<br>';
    'Fecha Final: '.$fechaFinal = $_POST['fechaFinal'];
    '<br>';
    'Firma Id: '.$idfirma = $_POST['identificador'];
    'Firma Inspectora Check:'.$firmainspectora = $_POST['firmainspectora'];
    '<br>';
    
    
    for($i=0; $i <= count($firmainspectora);$i++){
        $fechaInicial[$i];
        $fechaFinal[$i];
        if($firmainspectora == 0){
            echo '<script>alert("Algunos Campos estan vacios")
             window.location.href="../listacompaniaseguros.php"</script>';
            
        }else{
            $consultaconsecutivo = $mysqli->query("SELECT MAX(consecutivo) AS ultimo FROM ter_cruce_terceros");
            $extraerDatos = $consultaconsecutivo->fetch_array(MYSQLI_ASOCC);
            $ultimoregistro = $extraerDatos['ultimo'];
            $consecutivonuevo = $ultimoregistro[$i];
            $eliminarvacio = $mysqli->query("DELETE FROM ter_cruce_terceros WHERE id_tercero_secundario = 0");
           $insertaDatos = $mysqli->query("INSERT INTO ter_cruce_terceros(id_tercero_principal,id_tercero_secundario,consecutivo,fecha_inicial,fecha_vigencia)VALUES('$companiaseguros','$firmainspectora[$i]','$consecutivonuevo','$fechaInicial[$i]','$fechaFinal[$i]')")or die(mysqli_error($mysqli));
           echo '<script language="javascript">alert("Firma Inspectora Asignada.");
    window.location.href="../listacompaniaseguros.php"</script>';
        }
    }
    
}
?>