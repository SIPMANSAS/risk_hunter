<?php
	include('../clases/Json.class.php');
//	include_once("clases/utidatos.class.php");

   if (isset($_POST['key'])) 
  if (isset($_POST['key']) && ($_POST['key'] <> "")) 
  {

        $key = $_POST['key'];
         $html="";
        $filtro   = "";
       $filtro = "sr.descripcion like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarol($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia2-element" data="'.utf8_encode($xrowproyectos['descripcion']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['descripcion']).'</a></div>';
        }
       echo $html;
}
?>
