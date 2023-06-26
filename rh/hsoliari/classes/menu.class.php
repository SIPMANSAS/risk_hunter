<?php 
include_once("conexion.php"); 
include_once("utidatos.class.php"); 
class menu extends utidatos { 
//constructor  
	var $con;  
	function menu(){
		$this-> iniciarVariables();
	}  

	function FncBuscarMenu ($XLENGUAJE, $XPADRE, $XCLASS){                
		if($this->con){ 
			$consulta='SELECT prmenuitem.barlabel, prauthitem.barnombre, prpagdefn.linkpag FROM prmenuitem INNER JOIN (prauthitem INNER JOIN prpagdefn ON prauthitem.pagitemnombre=prpagdefn.pagnombre) ON prmenuitem.barnombre=prauthitem.barnombre WHERE prmenuitem.menunombre='.$XPADRE.' AND prmenuitem.lenguaje_cd='.$XLENGUAJE.' AND prmenuitem.estado=1 AND prauthitem.classid='.$XCLASS.' ORDER BY prmenuitem.itemnum';
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function verMenus ($XLENGUAJE, $XPADRE){                
		if($this->con){ 
			$consulta='SELECT DISTINCT(prmenuitem.barlabel), prauthitem.barnombre, prpagdefn.pagnombre, prmenuitem.menunombre FROM prmenuitem INNER JOIN (prauthitem INNER JOIN prpagdefn ON prauthitem.pagitemnombre=prpagdefn.pagnombre) ON prmenuitem.barnombre=prauthitem.barnombre WHERE prmenuitem.menunombre='.$XPADRE.' AND prmenuitem.lenguaje_cd='.$XLENGUAJE.' AND prmenuitem.estado=1 ORDER BY prmenuitem.itemnum';
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function verAutorizados ($XOPCION, $XPERFIL){                
		if($this->con){ 
			$consulta='SELECT barnombre, solodisplay, accionesautorizadas, id FROM prauthitem WHERE barnombre='.$XOPCION.' AND classid='.$XPERFIL.'';
			return  $this->con->consulta($consulta);  		
		}        
	}  

}
?>