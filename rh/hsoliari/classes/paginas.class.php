<?php 
include_once("conexion.php"); 
include_once("utidatos.class.php"); 
class paginas extends utidatos { 
//constructor  
	var $con;  
	function paginas(){
		$this-> iniciarVariables();
	}  

	function FncBuscarPagina ($XLENGUAJE, $XPAGINA, $XCLASS){                
		if($this->con){
			$consulta='SELECT prpagcampo.labeltxt, prauthitem.solodisplay, prauthitem.accionesautorizadas, prpagcampo.url_id FROM prauthitem INNER JOIN (prpagdefn INNER JOIN (prpagcampo INNER JOIN prdbcampo ON prpagcampo.camponombre=prdbcampo.campo_nombre) ON prpagdefn.pagnombre=prpagcampo.pagnombre) ON prauthitem.pagitemnombre=prpagdefn.pagnombre WHERE prpagcampo.pagnombre='.$XPAGINA.' AND prpagcampo.lenguaje_cd='.$XLENGUAJE.' AND prauthitem.classid='.$XCLASS.' ORDER BY prpagcampo.ordencolumn';
			return  $this->con->consulta($consulta);  		
		}        
	}  
}
?>