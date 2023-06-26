<?php
	include('../clases/Json.class.php');
//	include_once("clases/utidatos.class.php");

	$html="";
	$filtro   = "";
	$key = "";
	
  if (isset($_POST['key']) && ($_POST['key'] <> "")) 
  {
      echo "Buscando...$key";
        $key = $_POST['key'];
       $filtro = "descripcion like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarespuestas($filtro);
       	$xrowproyectos = array();
	    $xi=0;
	     while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['descripcion']).'" tipod="'.$xrowproyectos['vdom_tipo_dato'].'" id="'.$xrowproyectos['identificador'].'">'.utf8_encode($xrowproyectos['descripcion']).'</a></div>';
        }
       echo $html;
  }
  else 
      $html .= '<div><a class="sugerencia-element" data="No Asignada" tipod="0" id="0">No Asignada</a></div>';
      
?>
