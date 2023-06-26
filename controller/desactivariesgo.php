<?php

include '../conexions.php';

$identificador = $_GET['id'];

$descativariesgo = $mysqli->query("UPDATE enc_bloque_preguntas SET estado='0' WHERE identificador='$identificador'");

echo '<script language="javascript">alert("Bloque de preguntas desactivado correctamente.");
    window.location.href="../listarpreguntasrh.php"</script>';



?>