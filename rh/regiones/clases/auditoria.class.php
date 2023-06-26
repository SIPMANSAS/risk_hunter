<?php 
include "utidatos.class.php"; 

class gabriel extends utidatos {

//constructor

  	function cerrar() {

	$this->con->destruir();

	}


//conexion gabriel auditoria
    function buscaauditoria($filtro) {
        if($this->con->conectar()==true){
            
            $consulta="select * from v_detalle_seguridad where $filtro";
            return  $this->con->consulta($consulta);
    }
    }
    function buscacaracteristica($filtro) {
        if($this->con->conectar()==true){
            
            $consulta="select * from enc_caracteristicas where $filtro";
            return  $this->con->consulta($consulta);
    }
    }




}

?>

