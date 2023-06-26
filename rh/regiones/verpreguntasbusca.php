<?php 

include 'conexion/conexion.php';


echo $busca  =$_POST['buscar'];

$consulta = $mysqli->query("SELECT * FROM enc_bloque_preguntas WHERE descripcion LIKE '%$busca%'");
$extraerDatos = $consulta->fetch_array(MYSQLI_ASSOC);
echo $identificador = $extraerDatos['identificador'];

?>