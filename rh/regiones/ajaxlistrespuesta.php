<?php

echo "entre a ajasx";
$entre = "entre alist";
echo '<script language="javascript">alert(";
echo $entre;
echo "); </script>';

include "clases/Json.class.php";
$Json     = new Json;
$Json->iniciarVariables();

$entre = "entre alist22222";
echo '<script language="javascript">alert(";
echo $entre;
echo "); </script>';


$html = '';
if (isset($_POST['elegido']))
    $elegido = $_POST['elegido'];
else 
    $elegido = 1;

$filtro = "id_respuesta = '$elegido'";

echo '<script language="javascript">alert(";
echo $filtro; 
echo "); </script>';
$xcompencval = $Json->buscaenclistavalores($filtro);
$xrowlistval = array();
$xi=0;


while ($xrowlistval = $Json->obtener_fila($xcompencval)) {
    $nombred[$xi] = utf8_encode($xrowlistval['valor_alfa_numerico']) ;
    $identificadord[$xi] = $xrowpais['identificador'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
    $xi++;           
}

echo $html;


?>