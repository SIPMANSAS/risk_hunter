<?php

include "clases/Json.class.php";

$Json     = new Json;
$Json->iniciarVariables();


$html = '';
if (isset($_POST['elpais']))
    $pais = $_POST['elpais'];
else 
    $pais = 1;
if (isset($_POST['eldep']))        
    $dep = $_POST['eldep'];
else
    $dep = 1;
$filtro = "codigo_pais = ". $pais . " and codigo_departamento = ". $dep;

$xcomppais = $Json->selciudad($filtro);
$xrowpais = array();
$xi=0;

while ($xrowpais = $Json->obtener_fila($xcomppais)) {
    $nombred[$xi] = utf8_encode($xrowpais['nombre']) ;
    $identificadord[$xi] = $xrowpais['codigo'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>