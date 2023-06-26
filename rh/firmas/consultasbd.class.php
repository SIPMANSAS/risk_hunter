<?php


include 'utidatos.class.php';

class consultasbd extends utidatos{
    
    function cerrar() {
        $this->con->destruir();
    }
    
    function buscapais($filtro){
        if ($this->con->conectar()==true){
            $consulta = "SELECT * FROM rg_paises";
            return $this->con->consulta($consulta);
        }
    }
    
     function buscafirmass($filtro){
        if ($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE vdom_tipo_tercero = '772' AND $filtro AND estado = 1" ;
            return $this->con->consulta($consulta);
        }
    }
    
    function buscafirmas($filtro){
        if ($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE vdom_tipo_tercero = '774' AND $filtro AND estado = 1" ;
            return $this->con->consulta($consulta);
        }
    }
    
    
     function buscarclienteusuario($filtro){
        if ($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }
    
   
    function pintarformulario(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
        }
    }
} 




?>