<?php 
include_once "gabrielutidatos.class.php"; 

class gabriel extends gabrielutidatos {
//----------------------------
  	function cerrar() {
	$this->con->destruir();
	}
    function secusuario($filtro) {        
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_usuarios WHERE usuario = '$filtro' AND identificador";
            return  $this->con->consulta($consulta);
        }
    }
    function menudinamico($filtro) {        
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_menus_x_usuario WHERE id_menu AND id_usuario = '$filtro' GROUP BY menu ORDER BY `v_menus_x_usuario`.`menu` ASC  ";
            return  $this->con->consulta($consulta);
        }
    }

    function listaauditoria($filtro) {        
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_detalle_seguridad WHERE $filtro";
            return  $this->con->consulta($consulta);
        }
    }

    function buscaauditoria($filtro) {
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_detalle_seguridad WHERE $filtro";
            return  $this->con->consulta($consulta);
        }
    }

    function resulauditoria($filtro) {
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_detalle_seguridad WHERE identificador ='$filtro'";
            return  $this->con->consulta($consulta);
        }
    }
    function buscacaracteristicaactiva($filtro) {
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM enc_caracteristicas WHERE $filtro and estado =1";
            return  $this->con->consulta($consulta);
        }
    }
    function resbuscacaracteristicaactiva($filtro) {
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM enc_caracteristicas WHERE identificador = $filtro and estado =1";
            return  $this->con->consulta($consulta);
        }
    }
    function listacaracteristicainactiva() {
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM enc_caracteristicas WHERE   estado =0 ";
            return  $this->con->consulta($consulta);
        }
    }
   
    function listavalorcaracteristica(){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_bienes";
            return  $this->con->consulta($consulta);
        }
    }
    function creacaracteristica($info){
        if($this->con->conectar()==true){            
            $consulta="INSERT INTO enc_caracteristicas(nombre,tipo_estado,estado,cod_dominio)values('$info[0]','$info[1]','$info[2]','$info[3]')";
            return  $this->con->consulta($consulta);
        }
    }
    function updatecaracteristica($info){
        if($this->con->conectar()==true){            
            $consulta="UPDATE enc_caracteristicas SET nombre = '$info[0]' , cod_dominio = '$info[1]' WHERE identificador = '$info[2]'";
            return  $this->con->consulta($consulta);
        }
    }
    function activacacteristica($info){
        if($this->con->conectar()==true){            
            $consulta="UPDATE enc_caracteristicas SET estado='1' WHERE identificador='$info'";
            return  $this->con->consulta($consulta);
        }
    }
    function desactivacaracteristica($info){
        if($this->con->conectar()==true){            
            $consulta="UPDATE enc_caracteristicas SET estado='0' WHERE identificador='$info'";
            return  $this->con->consulta($consulta);
        }
    }
    function listabienes($filtrob){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_bienes WHERE identificador= '$filtrob'";
            return  $this->con->consulta($consulta);
        }
    }
    function tipobienes($con){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM v_bienes WHERE identificador= '$con'";
            return  $this->con->consulta($consulta);
        }
    }
    function buscarbloquepreguntahija($filtro){
    
        if($this->con->conectar()==true){
            
            $consulta= "select * from enc_preguntas where $filtro";
            return  $this->con->consulta($consulta);
        }
    }

//---------------------------
}
?>

