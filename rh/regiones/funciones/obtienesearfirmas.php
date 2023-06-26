<?php
	include('../clases/Json.class.php');
  if (isset($_POST['search']) && ($_POST['search'] <> ""))
  {     
      
        $key = $_POST['search'];
        echo "Buscando... $key";
        
        $html="";
        $filtro   = "";
        $filtro = "nombre_completo like \"%".$key."%\"";
        $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->buscarfirmas($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
           
           $html .= '<div><a class="sugerencia-element" data="'.utf8_encode($xrowproyectos['nombre_completo']).'" id="'.$xrowproyectos['identificador'].'">'.$xrowproyectos['identificador']."-".utf8_encode($xrowproyectos['nombre_completo'])."- Usuario: ".$xrowproyectos['identificador'].'</a></div>';
        }
       echo $html;
    }
?>
