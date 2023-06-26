<?php
	include('../clases/consultasbd.class.php');


   if (isset($_POST['search'])) 
        $key = $_POST['search'];
   else
       $key = "";
        $html="";
        $filtro   = "";
        $filtro = "descripcion like \"%".$key."%\"";
        $consultasbd     = new consultasbd;
        $consulta = $consultasbd->iniciarVariables();
        $xcompproyectos = $consultasbd->buscainmuebles($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $consultasbd->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['descripcion']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['descripcion']).'</a></div>';
        }
       echo $html;

?>
