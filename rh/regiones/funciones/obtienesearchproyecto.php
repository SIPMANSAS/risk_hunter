<?php
	include('../clases/json.class.php');
//	include_once("clases/utidatos.class.php");

    if (isset($_POST['idcliente'])) 
    	$idcliente  = $_POST["idcliente"];
   else
        $idcliente = "1";
    if (isset($_POST['search'])) 
        $key = $_POST['search'];
   else
       $key = "";
        $html="";
        $filtro   = "";
       $filtro = "idcliente = ". $idcliente . " and nombreproyecto like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->Buscaproyectosearch($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
               $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombreproyecto']).'" id="'.$xrowproyectos['idproyecto'].'">'.utf8_encode($xrowproyectos['nombreproyecto']).'</a></div>';
        }
       echo $html;

?>
