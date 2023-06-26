<?php
	include('../clases/gabriel.class.php');
//	include_once("clases/utidatos.class.php");

$html="";
$filtro   = "";
$key = "";
if (isset($_POST['key']) && ($_POST['key'] <> ""))
{
    echo "<span class='buscando'>Buscando...".$key." </span>"; 
        $key = $_POST['key'];
        $filtro = "nombre like \"%".$key."%\"";
        $Json     = new gabriel;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscaauditoria($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombre']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['nombre'])."- Usuario: ".$xrowproyectos['usuario'].'</a></div>';
        }
       echo $html;
    }
       else
       $html .= '<div><a class="sugerencia-element" data="No Asignada" tipod="0" id="0">No Asignada</a></div>';
?>