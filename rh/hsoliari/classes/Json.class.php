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
          
          $consulta="select * from v_tipos_dominio  where $filtro ";
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
          
          $consulta= "select c.codigo, c.nombre nombre from rg_ciudades c where $filtro";
          return  $this->con->consulta($consulta);
      }
  }
  
  
  function selrol(){
      
      if($this->con->conectar()==true){
          
          $consulta= "select identificador, nombre_corto from sg_roles";
          return  $this->con->consulta($consulta);
      }
  }
  
  function insertausuario($usuario)
  {
      if($this->con->conectar()==true){
          
     $consulta =" insert into sg_usuarios( email, nombre_corto, nombre, tipo_estado, estado, apellidos, vdom_tipo_identificacion, numero_telefono,
          id_pais, id_departamento, id_ciudad, direccion, id_oficina, numindentificacion) values ('$usuario[1]','$usuario[2]','9','1','$usuario[3]','$usuario[4]',
              '$usuario[5]','$usuario[6]','$usuario[7]','$usuario[8]','$usuario[9]','$usuario[10]','$usuario[11]','$usuario[12]' )";
          return  $this->con->consulta($consulta);    
      }
      
  }
  
  function insertarolxusuario($usuario)
  {
      if($this->con->conectar()==true){
          
      $consulta =" insert into sg_roles_x_usuario (id_rol, id_usuario, fecha_efectiva, tipo_estado, estado) values ('$usuario[0]','$usuario[1]','$usuario[2]','12','2')";
      echo "consulta es $consulta";
      return  $this->con->consulta($consulta);
      }
      
  }
  
  function buscarsequencia($XSEQUENCIA, $parametro, $filtro)
  {
      if($this->con->conectar()==true){
          
      $consulta =" select $parametro from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
      echo "consulta es $consulta";
      return  $this->con->consulta($consulta);
      }
      
  }
  
  function FncBuscarSequencia ($XSELECT){
  
          if($this->con->conectar()==true){
              
          $consulta = $XSELECT;
          
          return  $this->con->consulta($consulta);
      }
  }
  
  
  
}
?>

