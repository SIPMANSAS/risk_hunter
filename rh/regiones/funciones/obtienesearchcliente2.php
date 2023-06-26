<?php
	include('../clases/Json.class.php');
//	include_once("clases/utidatos.class.php");

   if (isset($_POST['key']) && ($_POST['key'] <> "")) 
  {

        $key = $_POST['key'];
        echo "key es" . $key;
        $html="";
        $filtro   = "";
       $filtro = "nombre like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->selclientesfil($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia2-element" data="'.utf8_encode($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['nombre']).'</a></div>';
        }
       echo $html;
}
?>