<?php

include('../clases/Json.class.php');

$Json     = new Json;
$Json->iniciarVariables();

$html = '';
if (isset($_POST['idrespuesta']))
    $elegido = $_POST['idrespuesta'];
else 
    $elegido = 1;

$filtro = "id_respuesta = '$elegido'";

$xcompencval = $Json->buscaenclistavalores($filtro);
$xrowlistval = array();
$xi=0;

$html .=  '<option value="NULL"> (NULL) NO SE SELECCIONA NINGUNA OPCI&Oacute;N DE LA LISTA </option>';
while ($xrowlistval = $Json->obtener_fila($xcompencval)) {
    $nombred[$xi] = utf8_encode($xrowlistval['valor_alfa_numerico']) ;
    $identificadord[$xi] = $xrowlistval['identificador'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>