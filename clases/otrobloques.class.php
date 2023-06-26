<?php 
include "utidatos.class.php"; 

class otrobloques extends utidatos {

//constructor

  	function cerrar() {

	$this->con->destruir();

	}
	
	function buscadetalleencuesta(){
        
        if($this->con->conectar()==true){     
            $consulta= "SELECT * FROM `v_detalle_encuestas` GROUP BY id_encuesta";
            return  $this->con->consulta($consulta);
        }
    }
    
	
	function insertariesgopreg($info){
        
        if($this->con->conectar()==true){
            
            $consulta= "INSERT INTO enc_riesgo_a_activar (id_riesgo, id_pregunta, fecha_activa, tipo_estado, estado)
                        VALUES('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]')";
             return  $this->con->consulta($consulta);
        }
    }


    function buscacgvaloresdominio($filtro){
        
        if($this->con->conectar()==true){     
            $consulta= "select nombre, descripcion from cg_valores_dominio WHERE $filtro";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultainputs(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
        }
    }

    function borrarvalores($filtro) {
        
        if($this->con->conectar()==true){
            $consulta= "delete from enc_lista_valores where $filtro";
            return  $this->con->consulta($consulta);
        }
    }

    function actualizarespuesta($filtro, $info){
        
        if($this->con->conectar()==true){   
            $consulta= "update enc_respuestas set $info where $filtro";
             return  $this->con->consulta($consulta);
        }
    }
    
    function buscartipodocumento(){
        if($this->con->conectar()==true){
            $consulta = "SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function buscapaises(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM rg_paises";
             return $this->con->consulta($consulta);
        }
    }
    
    
    function buscacompania($filtro){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE $filtro";
            //echo $consulta;
            return $this->con->consulta($consulta);
        }
    }
    
    function buscafirmas(){
        
        if($this->con->conectar()==true){     
            $consulta= "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo WHERE F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' GROUP BY identificacion ASC";
            return  $this->con->consulta($consulta);
        }
    }
    
    
    
    function registrafirmas($info){
        if($this->con->conectar()==true){
            $consulta= "INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente)
                        VALUES('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]','$info[5]','$info[6]','$info[7]','$info[8]','$info[9]','$info[10]','$info[11]')";
            return  $this->con->consulta($consulta);  
        }
        
    }
    
    function consultafirmasactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
            //SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.identificacion= 27 AND F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' GROUP BY identificacion ASC
        }
    }
    
    
    function consultafirmasinactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=0 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultacompaniasactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='772' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function consultacompaniasinactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=0 AND vdom_tipo_tercero='772' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultafirmas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=0 AND F.tipoCliente=0 AND vdom_tipo_tercero='772' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscadoctipo($filtrodoc){
        if($this->con->conectar()==true){            
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND cvd.identificador='$filtrodoc'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function tipodocuselect($filtrodoc){
        if($this->con->conectar()==true){
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND cvd.identificador <> '$filtrodoc' ";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscatipo($filtrotipo){
        if($this->con->conectar()==true){            
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 25 AND cvd.identificador='$filtrotipo'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function tiposelect($filtrotipo){
        if($this->con->conectar()==true){
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 25 AND cvd.identificador <> '$filtrotipo' ";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscapaisesasignados($filtropais){
        if($this->con->conectar()==true){
            $consula = "select * from rg_departamentos WHERE codigo_pais = '$filtropais'";
             return $this->con->consulta($consulta);
        }
        
    }
    
    function firmasasignadas($id){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM ter_cruce_terceros INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function traerinfoformulario(){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function consultapreguntas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_preguntas WHERE identificador > 0 ";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function buscadepartamentos($filtropais){
        if($this->con->conectar()==true){
            $consulta = "select * from rg_departamentos WHERE codigo_pais = '$filtropais'";
            return $this->con->consulta($consulta);
        }
        
    }
    
    function buscaciudades($paisid, $departamentoid){
        if($this->con->conectar()==true){
            $consulta = "select * from rg_ciudades WHERE codigo_pais = '$paisid' AND codigo_departamento= '$departamentoid' ";
            return $this->con->consulta($consulta);
        }
        
    }
    
    function tipoinforme($tipo_informe){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM cg_valores_dominio WHERE identificador = $tipo_informe ";
            return  $this->con->consulta($consulta);
        }
}
}

?>

