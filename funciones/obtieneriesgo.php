<?php

include('../clases/Json.class.php');

$Json     = new Json;
$Json->iniciarVariables();

$html = '';

$xcompencval = $Json->buscariesgo();
$xrowlistval = array();
$xi=0;

while ($xrowlistval = $Json->obtener_fila($xcompencval)) {
    $nombred[$xi] = utf8_encode($xrowlistval['nombre']) ;
    $identificadord[$xi] = $xrowlistval['id_riesgo'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>