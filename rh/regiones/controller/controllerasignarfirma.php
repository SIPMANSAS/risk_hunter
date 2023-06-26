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
           $insertaDatos = $mysqli->query("INSERT INTO ter_cruce_terceros(id_tercero_principal,id_tercero_secundario,fecha_inicial,fecha_vigencia)VALUES('$companiaseguros','$firmainspectora[$i]','$fechaInicial[$i]','$fechaFinal[$i]')");
           echo '<script language="javascript">alert("Firma Inspectora Asignada.");
    window.location.href="../listacompaniaseguros.php"</script>';
        }
    }
    
}
?>