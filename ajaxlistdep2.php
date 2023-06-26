<?php

include "clases/bloques.class.php";

$bloques     = new bloques;
$bloques->iniciarVariables();


$html = '';
$filtro = $_POST['elegido'];

$xcomppais = $bloques->seldepB($filtro);
$xrowpais = array();
$xi=0;

while ($xrowpais = $bloques->obtener_fila($xcomppais)) {
    $nombred[$xi] = ($xrowpais['valor_alfa_numerico']) ;
    $identificadord[$xi] = $xrowpais['identificador'];
    $html .=  '<option value="'.$identificadord[$xi].'">'.($nombred[$xi]).'</option>';
    $xi++;           
}
?>
<option value="0">NULL</option>
<?php
echo $html;


?>