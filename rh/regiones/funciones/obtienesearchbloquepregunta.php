<?php
	include('../clases/Json.class.php');
//	include_once("clases/utidatos.class.php");

	$html="";
	$filtro   = "";
	
  if (isset($_POST['search']) && ($_POST['search'] <> "")) 
  {
        $key = $_POST['search'];
       echo "Buscando... $key";
       $filtro = "descripcion like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarbloquepregunta($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['descripcion']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['descripcion']).'</a></div>';
        }
       echo $html;
  }

?>
