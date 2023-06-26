<?php
	include('../clases/consultasbd.class.php');
//	include_once("clases/utidatos.class.php");


   if (isset($_POST['key'])) 
        $key = $_POST['key'];
   else
       $key = "";
        $html="";
        $filtro   = "";
        $filtro = "nombre like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarclienteusuario($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;

?>
