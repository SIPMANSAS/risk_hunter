<?php

include "clases/bloques.class.php";

$Json     = new bloques;
$Json->iniciarVariables();


$html = '';
$filtro = $_POST['elegido'];

$xcomppais = $Json->seldepB($filtro);
$xrowpais = array();
$xi=0;

while ($xrowpais = $bloques->obtener_fila($xcomppais)) {
    $nombred[$xi] = ($xrowpais['valor_alfa_numerico']) ;
    $identificadord[$xi] = $xrowpais['identificador'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>