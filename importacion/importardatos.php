<?php

require('conexion.php');


$eliminacionprevia = "DELETE FROM cargue_archivos_planos";
mysqli_query($con,$eliminacionprevia);

$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0;


foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados =  ($cantidad_registros - 1);

    if ($i != 0) {

        $datos = explode(";", utf8_decode($linea));
       
        echo 'N'.$nombres                = (!empty($datos[0])  ? ($datos[0]) : '');
        echo 'C'.$cadena              = (!empty($datos[1])  ? ($datos[1]) : '');
        
        $insertarData = "INSERT INTO cargue_archivos_planos(tipo_estado,cadena) VALUES('17','$linea')";
        mysqli_query($con, ($insertarData));
        
        
        
        echo '<script language="javascript">alert("Cargue exitoso.");
        window.location.href="../listarcargas.php"</script>';
    }else{
        
    }

 $i++;
}

?>
