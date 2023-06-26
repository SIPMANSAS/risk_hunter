<?php
	include('../clases/gabriel.class.php');
//	include_once("clases/gabrielutidatos.class.php");

	$html="";
	$filtro   = "";
	
  if (isset($_POST['search2']) && ($_POST['search2'] <> "")) 
  {
        $key = $_POST['search2'];
       echo "Buscando... $key";
       $filtro = "nombre like \"%".$key."%\"";
        $Json     = new gabriel;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarbloquepreguntahija($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;
  }

?>
