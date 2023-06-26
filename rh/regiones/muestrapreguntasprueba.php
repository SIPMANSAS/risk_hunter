<?php

include ('conexion/conexion.php');
$consulta = $mysqli->query("SELECT * FROM cargue_archivos_planos");
while($extraerData=$consulta->fetch_array()){
    echo $datos = $extraerData['cadena'];
    echo '<br>';
}


?>