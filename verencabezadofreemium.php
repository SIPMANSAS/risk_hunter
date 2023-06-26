<?php

include 'conexion/conexion.php';


$identificador = $_POST['identificador'];

$consultainspeccion = $mysqli->query("SELECT * FROM enc_inspecciones WHERE identificador='$identificador'");
$extraerinformacioninspeccion = $consultainspeccion->fetch_array(MYSQLI_ASSOC);

$id_usuario_ex_ins = $extraerinformacioninspeccion['id_usuario'];
$fecha_solicitud_ex = $extraerinformacioninspeccion['fecha_solicitud'];
$numero_inspeccion_ex = $extraerinformacioninspeccion['numero_inspeccion'];
$nombre_solicita_ex = $extraerinformacioninspeccion['nombre_solicita'];
$nombre_edificacion_ex = $extraerinformacioninspeccion['nombre_edificacion'];
$origen_inspeccion_ex = $extraerinformacioninspeccion['origen'];
$consecutivo_inspeccion_ex = $extraerinformacioninspeccion['consecutivo'];

?>