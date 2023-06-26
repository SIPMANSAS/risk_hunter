<?php

include "clases/Json.class.php";

$Json     = new Json;
$Json->iniciarVariables();


$html = '';
$filtro = $_POST['elegido'];

$xcomppais = $Json->seldep($filtro);
$xrowpais = array();
$xi=0;

while ($xrowpais = $Json->obtener_fila($xcomppais)) {
    $nombred[$xi] = ($xrowpais['nombre']) ;
    $identificadord[$xi] = $xrowpais['codigo'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>