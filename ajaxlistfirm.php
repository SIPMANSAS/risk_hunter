<?php

include "bloques/bloques.class.php";

$bloques     = new bloques;
$bloques->iniciarVariables();


$html = '';
$filtro = $_POST['elegidoT'];

$xtel = $bloques->seltel($filtro);
$xrowtel = array();
$xi=0;

while ($xrowtel = $bloques->obtener_fila($xtel)) {
    $nombret[$xi] = utf8_encode($xrowtel['nombres']) ;
    $identificadort[$xi] = $xrowtel['telefono'];
    $html .=  '<option value="'.$identificadort[$xi].'">'.$nombret[$xi].'</option>';
    $xi++;           
}

echo $html;


?>