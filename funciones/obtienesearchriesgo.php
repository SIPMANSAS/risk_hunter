<?php
	include('../clases/Json.class.php');
	$html="";
	$filtro   = "";
	
  if (isset($_POST['key']) && ($_POST['key'] <> "")) 
  {
        $key = $_POST['key'];
       echo "Buscando... $key";
       $filtro = "nombre like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscariesgo($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.($xrowproyectos['nombre']).'" id="'.$xrowproyectos['id_riesgo'].'">'.($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;
  }

?>
