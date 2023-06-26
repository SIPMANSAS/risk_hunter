<?php 
include "utidatos.class.php"; 

class Json extends utidatos {

//constructor

  	function cerrar() {

	$this->con->destruir();

	}

	function Buscapais($filtro){

	    if($this->con->conectar()==true){

			$consulta="select p.codigo, p.nombre nombre, t.nombre tipo_estado, e.nombre estado
                       from rg_paises p, sg_tipos_estado t, sg_estados e
                       where p.tipo_estado = t.identificador and   p.tipo_estado = e.tipo_estado
                      and   p.estado      = e.identificador and $filtro
                        order by 1;   ";
                return  $this->con->consulta($consulta);

		}        

	}
	
	function Buscadepartamento($filtro) {
	    if($this->con->conectar()==true){
	        
	        $consulta="select d.codigo, d.nombre nombre, t.nombre tipo_estado, e.nombre estado
                       from rg_departamentos d, sg_tipos_estado t, sg_estados e
                       where d.tipo_estado = t.identificador and   d.tipo_estado = e.tipo_estado
                      and   d.estado      = e.identificador and $filtro
                        order by 1;   ";
	        return  $this->con->consulta($consulta);
	}
	}
	

	function Buscaciudad($filtro) {
	    if($this->con->conectar()==true){
	        
	        $consulta="select p.nombre pais,p.codigo codigop, d.nombre departamento, d.codigo codigod, c.codigo, 
                        c.nombre nombre, es_capital, t.nombre tipo_estado, e.nombre estado 
                        from rg_ciudades c, rg_departamentos d, rg_paises p, sg_tipos_estado t, 
                        sg_estados e where c.tipo_estado = t.identificador and 
                        c.tipo_estado = e.tipo_estado and c.estado = e.identificador and 
                        d.codigo_pais = p.codigo and c.codigo_pais = d.codigo_pais and 
                        c.codigo_departamento = d.codigo and $filtro
                        order by p.codigo, d.codigo, c.codigo
                        
               ";
	         return  $this->con->consulta($consulta);
	        
	    }
	    
  }
  
  function Buscagrupodominios(){
      
      if($this->con->conectar()==true){
          
          $consulta="select identificacion, nombre 
                       from cg_grupo_dominios; ";
          return  $this->con->consulta($consulta);
          
      }
      
  }

  function Buscadominios($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta="select * from v_tipos_dominio  where $filtro order by clasificacion, valor_padre, valor, id_alfanumerico, nombre";
           return  $this->con->consulta($consulta);
          
      }
      
  }
  
  function seltipoident(){
      
        if($this->con->conectar()==true){
            
          $consulta= "select identificador, nombre from cg_valores_dominio where id_dominio=18";
           return  $this->con->consulta($consulta);
      }
  }
  
  function selpais(){
      
      if($this->con->conectar()==true){
          
          $consulta= "select p.codigo, p.nombre nombre from rg_paises p";
          return  $this->con->consulta($consulta);
      }
  }
  
  function seldep($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select d.codigo, d.nombre nombre from rg_departamentos d where codigo_pais = $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  

  function selciudad($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select c.codigo codigo, c.nombre nombre from rg_ciudades c where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  
  function selrol(){
      
      if($this->con->conectar()==true){
          
          $consulta= "select identificador, nombre_corto, descripcion, tipo_estado, estado from sg_roles";
          return  $this->con->consulta($consulta);
      }
  }
  
  function selclientes(){
      
      if($this->con->conectar()==true){
          
          $consulta= "select identificador, nombre from v_cliente";
            return  $this->con->consulta($consulta);
      }
  }
  
  function insertausuario($usuario)
  {
      if($this->con->conectar()==true){
          
     $consulta =" insert into sg_usuarios( email, nombre_corto, nombre, tipo_estado, estado, apellidos, vdom_tipo_identificacion, numero_telefono,
          id_pais, id_departamento, id_ciudad, direccion, id_oficina, numidentificacion, usuario, password) values ('$usuario[1]','$usuario[2]','$usuario[3]','9','1','$usuario[4]',
              '$usuario[5]','$usuario[6]','$usuario[7]','$usuario[8]','$usuario[9]','$usuario[10]','$usuario[11]','$usuario[12]', '$usuario[13]','$usuario[14]' )";
     return  $this->con->consulta($consulta);    
      }
      
  }
  
  function insertarolxusuario($usuario)
  {
      if($this->con->conectar()==true){
          
      $consulta =" insert into sg_roles_x_usuario (id_rol, id_usuario, fecha_efectiva, tipo_estado, estado) values ('$usuario[0]','$usuario[1]','$usuario[2]','12','2')";
       return  $this->con->consulta($consulta);
      }
      
  }
  
  function buscarsequenciausuario()
  {
      if($this->con->conectar()==true){
          
      $consulta =" select max(identificador) maximo from sg_usuarios";
       return  $this->con->consulta($consulta);
      }
      
  }
  
  function insertaclientexusuario($usuario)
  {
      if($this->con->conectar()==true){
          
          $consulta =" insert into sg_usuarios_x_cliente (id_cliente, id_usuario, fecha_efectiva, tipo_estado, estado) values ('$usuario[0]','$usuario[1]','$usuario[2]','13','1')";
          return  $this->con->consulta($consulta);
      }
      
  }
  
  function infoemail($idcomunicaciones){
      
      if($this->con->conectar()==true){
          
          $consulta= "select asunto, texto , textof, remitente, cc from ad_comunicaciones where identificador = '$idcomunicaciones'";
          return  $this->con->consulta($consulta);
      }
  }
  
  function validarlogin($usuario,$password){
      
      if($this->con->conectar()==true){
          
          $consulta= "select flag_primera_vez from sg_usuarios where usuario='$usuario' and password='$password' and estado='1'";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscarusuarios($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select * from v_usuarios where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscarrolusuario($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select * from v_rol_x_usuario where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscarclienteusuario($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select * from v_clientes_x_usuario where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function cambiapassword($filtro,$setval){
      
      if($this->con->conectar()==true){
          
          $consulta= "update sg_usuarios set $setval  where $filtro";
          return  $this->con->consulta($consulta);
      }
  }

  function activausuario($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "update sg_usuarios set estado='1'  where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscauser($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select usuario from sg_usuarios where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscaobjetos(){
      
      if($this->con->conectar()==true){
          
          $consulta= "select sc.identificador id_clase, sc.nombre nom_clase, so.identificador id_objeto, so.nombre nom_objeto from sg_clases sc , sg_objetos so 
                    where sc.identificador = so.id_clase and sc.estado = 1 and so.estado = 1";
          return  $this->con->consulta($consulta);
      }
  }

  function insertarol($info){
      
      if($this->con->conectar()==true){
          
          $consulta= "insert into sg_roles(identificador, nombre_corto, descripcion, tipo_estado, estado) values ('$info[0]', '$info[1]', '$info[2]', 7, 1)";
          $disp = "consulta es $consulta";
          echo $disp;
          return  $this->con->consulta($consulta);
      }
  }
  
  function insertarolxobjeto($info){
      
      if($this->con->conectar()==true){
         
          $consulta= "insert into sg_permisos(id_rol, id_clase, id_objeto, tipo_permiso, tipo_estado, estado) values ('$info[0]', '$info[1]', '$info[2]', 'X', 5, 1)";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscarsequenrol()
  {
      if($this->con->conectar()==true){
          
          $consulta =" select max(identificador) maximo from sg_roles";
          return  $this->con->consulta($consulta);
      }
      
  }
  
  function buscarol($filtro)
  {
      if($this->con->conectar()==true){

            
          $consulta = "select sr.identificador, sr.descripcion , sr.nombre_corto , ste.nombre tipo_estado, se.nombre estado from  
      sg_roles sr, sg_tipos_estado ste , sg_estados se where ste.identificador  = sr.tipo_estado and se.tipo_estado = sr.tipo_estado 
        and se.identificador = sr.estado and $filtro";
          return  $this->con->consulta($consulta);
      }
      
  }
  
  function buscarrolpermiso($filtro)
  {
      if($this->con->conectar()==true){
          
          $consulta ="select * from v_permisos_del_rol where $filtro";
          return  $this->con->consulta($consulta);
      }
      
  }
  
  function seltipoestados($filtro)
  {
      if($this->con->conectar()==true){
          
          $consulta ="select identificador, nombre from sg_tipos_estado where $filtro";
           return  $this->con->consulta($consulta);
      } 
  }
  
  function buscarsecuenciaglobal($tabla, $identificador)
  {
      if($this->con->conectar()==true){
          $consulta =" select max($identificador) maximo from $tabla";
          return  $this->con->consulta($consulta);
      }
      
  }
  
  function insertabloquep($info){
      
      if($this->con->conectar()==true){
          
          $consulta= "INSERT INTO enc_bloque_preguntas (identificador, descripcion, tipo_estado, estado) VALUES( '$info[0]', '$info[1]', '$info[2]', '$info[3]')";
          return  $this->con->consulta($consulta);
      }
  }
  
  function insertapregunta($info){
      
      if($this->con->conectar()==true){
          
          $consulta= "INSERT INTO enc_preguntas (identificador, nombre, tipo_estado, estado, fecha_efectiva, id_pregunta_padre, id_valor_res_cierre, id_bloque_preguntas, id_valor_resp_activa_riesgo, id_respuesta) 
                        VALUES( '$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]')";
          return  $this->con->consulta($consulta);
      }
  }
  
  function insertarespuesta($info){
      
      if($this->con->conectar()==true){
          
          $consulta= "INSERT INTO enc_respuestas (identificador, descripcion, vdom_tipo_dato, tipo_estado, estado) VALUES( '$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]')";
          return  $this->con->consulta($consulta);
      }
  }
  
  function insertalistavalores($info){
      
      if($this->con->conectar()==true){
          
          $consulta= "INSERT INTO enc_lista_valores (identificador, valor_numerico, valor_alfa_numerico, vdom_unidad_medida, id_respuesta, tipo_estado, estado)
                    VALUES('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]')";
          return  $this->con->consulta($consulta);
      }
  }
  
  function seltipodato($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select * from cg_valores_dominio cvd where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function actualizausuario($filtro, $info){
      
      if($this->con->conectar()==true){
          
          $consulta= "update sg_usuarios set $info where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  function buscaidrolxusuario($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select id_rol sg_roles_x_usuario where $filtro";
          return  $this->con->consulta($consulta);
      }
  }

function borrarolusuario($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "delete from sg_roles_x_usuario where $filtro";
        return  $this->con->consulta($consulta);
    }
}

function buscarespuestas($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select identificador, descripcion , vdom_tipo_dato from enc_respuestas where $filtro";
        return  $this->con->consulta($consulta);
    }
}

function buscapadres($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select identificador, nombre from enc_preguntas where $filtro";
        return  $this->con->consulta($consulta);
    }
}

function buscaenclistavalores($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select identificador, valor_alfa_numerico from enc_lista_valores where $filtro";
         return  $this->con->consulta($consulta);
    }
}

function buscarbloquepregunta($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select identificador, descripcion, tipo_estado, estado from enc_bloque_preguntas where $filtro";
        return  $this->con->consulta($consulta);
    }
}

function buscarpreguntas($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select p.identificador, p.nombre, p.id_pregunta_padre padre, p.id_valor_res_cierre respcierre, p.id_valor_resp_activa_riesgo respriesgo , p.fecha_efectiva, p.estado, p.id_respuesta, r.descripcion nomrespuesta
from enc_preguntas p, enc_respuestas r where r.identificador = p.id_respuesta and $filtro";
         return  $this->con->consulta($consulta);
    }
}

function buscariesgo($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select id_riesgo, clasificacion, nombre, ramo from v_riesgos where $filtro";
        return  $this->con->consulta($consulta);
    }
}

function buscaestado($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select nombre from sg_estados where $filtro";
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

function buscariesgopreg($filtro){
    
    if($this->con->conectar()==true){
        
        $consulta= "select DISTINCT r.id_riesgo id_riesgo , v.nombre nombre from enc_riesgo_a_activar r JOIN v_riesgos v ON v.id_riesgo = r.id_riesgo WHERE $filtro";
        return  $this->con->consulta($consulta);
    }
}


}



?>

