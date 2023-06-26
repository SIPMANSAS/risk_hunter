<?php
	include('../clases/consultasbd.class.php');


   if (isset($_POST['search'])&& ($_POST['search'] <> "")) 
        $key = $_POST['search'];
   else
       $key = "";
        $html="";
        $filtro   = "";
        $filtro = "nombres like \"%".$key."%\"";
        $consultasbd     = new consultasbd;
        $consulta = $consultasbd->iniciarVariables();
        $xcompproyectos = $consultasbd->buscapreguntasB($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $consultasbd->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.utf8_encode($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;

?>
