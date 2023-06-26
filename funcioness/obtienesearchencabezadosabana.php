<?php
	include('../clases/consultasbd.class.php');


   if (isset($_POST['search'])) 
        $key = $_POST['search'];
   else
       $key = "";
        $html="";
        $filtro   = "";
        $filtro = "numero_inspeccion like \"%".$key."%\"";
        $consultasbd     = new consultasbd;
        $consulta = $consultasbd->iniciarVariables();
        $xcompproyectos = $consultasbd->buscasabana($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $consultasbd->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['numero_inspeccion']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['numero_inspeccion']).'</a></div>';
        }
       echo $html;

?>