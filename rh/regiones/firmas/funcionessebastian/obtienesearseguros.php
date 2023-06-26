<?php
	include('../clases/consultasbd.class.php');


   if (isset($_POST['search'])) 
        $key = $_POST['search'];
   else
       $key = "";
        $html="";
        $filtro   = "";
        $filtro = "nombres like \"%".$key."%\"";
        $consultasbd     = new consultasbd;
        $consulta = $consultasbd->iniciarVariables();
        $xcompproyectos = $consultasbd->buscafirmas($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $consultasbd->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombres']).'" id="'.$xrowproyectos['identificacion'].'">'.$xrowproyectos['numero_identificacion']."-".utf8_encode($xrowproyectos['nombres']).'</a></div>';
        }
       echo $html;

?>
