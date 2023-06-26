<?php
	include('../clases/Json.class.php');
//	include_once("clases/utidatos.class.php");

	$html="";
	$filtro   = "";
	
  if (isset($_POST['search']) && ($_POST['search'] <> "")) 
  {
        $key = $_POST['searchC'];
       echo "Buscando... $key";
       $filtro = "nombre like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarbloquepreguntaB($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;
  }

?>
