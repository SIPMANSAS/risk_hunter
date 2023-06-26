<?php

require('conexion.php');
$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0;


foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados =  ($cantidad_registros - 1);

    if ($i != 0) {

        echo $datos = explode(";", utf8_decode($linea));
       
        $nombres                = utf8_decode(!empty($datos[0])  ? ($datos[0]) : '');
        $cadena              = utf8_decode(!empty($datos[1])  ? ($datos[1]) : '');
        
        $insertarData = "INSERT INTO cargue_archivos_planos(tipo_estado,cadena) VALUES('17','$linea')";
        mysqli_query($con, $insertarData);
        
        
        
        //echo '<script language="javascript">alert("Cargue exitoso.");
        //window.location.href="../pruebacarga.php"</script>';
    }else{
        
    }

 $i++;
}

?>
