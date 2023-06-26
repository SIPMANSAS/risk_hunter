<?php 
include "utidatos.class.php"; 

class bloques extends utidatos {

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
    
    
    function buscarbloquepregunta($filtro){
    
        if($this->con->conectar()==true){
            
            $consulta= "select * from enc_preguntas";
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
    
    function buscadepartamentos($filtropais){
        if($this->con->conectar()==true){
            $consulta = "select * from rg_departamentos WHERE codigo_pais = '$filtropais'";
            return $this->con->consulta($consulta);
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
            $consulta = "SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 ORDER BY cvd.nombre ASC ";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function buscapaises(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM rg_paises";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscafirmasI($idcliente){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_cruce_terceros JOIN ter_terceros ON ter_terceros.identificacion=ter_cruce_terceros.id_tercero_secundario WHERE ter_cruce_terceros.id_tercero_principal='$idcliente' AND ter_terceros.vdom_tipo_tercero=774 AND ter_cruce_terceros.estado=1";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscafirmasIB($idcliente){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_cruce_terceros JOIN ter_terceros ON ter_terceros.identificacion=ter_cruce_terceros.id_tercero_secundario WHERE ter_cruce_terceros.id_tercero_principal='$idcliente' AND ter_terceros.vdom_tipo_tercero=774 AND ter_cruce_terceros.estado=1";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function seltel($filtro){
      
      if($this->con->conectar()==true){
          
          $consulta= "select * from ter_terceros ";
          return  $this->con->consulta($consulta);
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
    
    function buscainspectoresindependientes($filtro){
        $consulta = "SELECT * FROM sg_usuarios WHERE $filtro";
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
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion DESC";
            return $this->con->consulta($consulta);
            //SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.identificacion= 27 AND F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' GROUP BY identificacion ASC
        }
    }
    
    
    function consultafirmasinactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=0 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultacompaniasactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='772' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion ORDER BY `F`.`numero_identificacion` ASC";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function consultacompaniasinactivas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=0 AND vdom_tipo_tercero='772' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultafirmas($id){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion AND identificacion NOT IN (SELECT id_tercero_secundario FROM ter_cruce_terceros WHERE id_tercero_principal='$id' AND estado=1) GROUP BY identificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscadoctipo($filtrodoc){
        if($this->con->conectar()==true){            
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND cvd.identificador='$filtrodoc'";
            return  $this->con->consulta($consulta);
        }
    }
    
    
    function buscacomp($filtrocomp){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM ter_terceros WHERE identificacion='$filtrocomp'";
            return  $this->con->consulta($consulta);
        }
    }
    
     function buscafirmaB($filtrofirma){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM ter_terceros WHERE vdom_tipo_tercero='774' AND estado=1'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultacompaniasasignadas($filtrocompania){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$filtrocompania'";
            return $this->con->consulta($consulta);
        } 
    }
    
    function buscacompanias($filtrocompania){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion ='$filtrocompania'";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultacompaniasdif($filtrocompania){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion <> '$filtrocompania' AND vdom_tipo_tercero='772' AND estado='1'";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscafirmasinspectoras($filtrofirmainspectora){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion ='$filtrofirmainspectora'";
            return $this->con->consulta($consulta);
        } 
    }
    
    function buscainspectoresasignados($filtroinspector){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=1 AND identificador='$filtroinspector'";
        }
    }

    function consultafirmasdif($filtrofirmainspectora){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion <> '$filtrofirmainspectora' AND vdom_tipo_tercero='774' AND estado='1'";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscabienes($filtrobienes){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM `v_bienes` WHERE identificador='$filtrobienes'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabiendif($filtrobienes){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM `v_bienes` WHERE identificador<>'$filtrobienes'";
            return $this->con->consulta($consulta);
        }
    }
    
    function tipodocuselect($filtrodoc){
        if($this->con->conectar()==true){
            $consulta="SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND cvd.identificador <> '$filtrodoc' ";
            return $this->con->consulta($consulta);
        }
    }
    
    function tipofirmaselect($filtrofirma){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM ter_terceros WHERE identificacion = '$filtrofirma' ";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscatipo($filtrotipo){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM cg_valores_dominio WHERE id_dominio=25 AND identificador='$filtrotipo'";
            return  $this->con->consulta($consulta);
        }  
    }
    
    function tiposelect($filtrotip){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM cg_valores_dominio WHERE id_dominio=25 AND identificador<>'$filtrotipo'";
            return  $this->con->consulta($consulta);
        } 
    }
    
    function tipo(){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM cg_valores_dominio WHERE id_dominio=25";
            return  $this->con->consulta($consulta);
        } 
    }
    
    function inspectorasignado($filtrinsp){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1 AND identificador='$filtrinsp'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function inspectorselect($filtrinsp){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1 AND identificador<>'$filtrinsp'";
            return  $this->con->consulta($consulta);
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
            $consulta="SELECT * FROM ter_cruce_terceros INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' AND estado <> 2";//GROUP BY ter_cruce_terceros.id_tercero_secundario
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function personasignada($identificador){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM sg_usuarios WHERE identificador = '$identificador'";
            return $this->con->consulta($consulta);
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
    
    function pintaformulario(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function consultainspectoresindependientes(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=1 ORDER BY numidentificacion";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function consultainspectoresindependientesinactivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=0";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
     function consultainspectoresfirmainspectora(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function consultainspectoresfirmainspectorainactivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=0";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }
    }
    
    function consultainspectoresfirmas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1";
            return $this->con->consulta($consulta);
            //$firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$id' GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
        }  
    }
    
    function consultainspectorindependiente(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE (tipo_estado=28 AND estado=1) OR tipo_estado=9";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultaencabezado(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_inspeccion";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultaencabezadofirmas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_inspeccion WHERE descripcion=2";
            return $this->con->consulta($consulta);
        } 
    }
    
    
    function consultaencabezadocompanias(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_inspeccion E LEFT JOIN sg_usuarios U ON E.id_usuario = U.identificador JOIN ter_terceros T ON E.id_cia_seguros= T.identificacion WHERE descripcion=1";
            return $this->con->consulta($consulta);
        } 
    }
    
   
    
    function buscaciudades($paisid, $departamentoid){
        if($this->con->conectar()==true){
            $consulta = "select * from rg_ciudades WHERE codigo_pais = '$paisid' AND codigo_departamento= '$departamentoid' ";
            return $this->con->consulta($consulta);
        }
        
    }
    
    function clientesxusuario($id_menu_p){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios_x_cliente where id_usuario='$id_menu_p'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaencabezadoxusuarios($id_menu_p){
        if($this->con->conectar()==true){
             $consulta = "SELECT * FROM enc_inspeccion WHERE id_usuario='$id_menu_p'";
            return $this->con->consulta($consulta);
        } 
    }
    
    function ultimoregistro(){
        if($this->con->conectar()==true){
            $consulta = "SELECT IFNULL (MAX(consecutivo),0)+1 AS Ultimo FROM enc_inspeccion WHERE origen='CA' AND YEAR(fecha_solicitud)=YEAR(NOW())";
            return $this->con->consulta($consulta);
        }
    }
    
    function ultimoregistrofi(){
        if($this->con->conectar()==true){
            $consulta = "SELECT IFNULL (MAX(consecutivo),0)+1 AS Ultimo FROM enc_inspeccion WHERE origen='FI' AND YEAR(fecha_solicitud)=YEAR(NOW())";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultafirmasactivasselect(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.estado=1 AND vdom_tipo_tercero='774' AND cvd.identificador = vdom_tipo_identificacion GROUP BY identificacion ORDER BY nombres";
            return $this->con->consulta($consulta);
            //SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.identificacion= 27 AND F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' GROUP BY identificacion ASC
        }
    }
    
    function consultatelefonofirma($filtro){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM ter_terceros WHERE identificacion=$filtro";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabienes(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_bienes";
            return $this->con->consulta($consulta);
            //SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo JOIN cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND F.identificacion= 27 AND F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' GROUP BY identificacion ASC
        }
    }
    
    function consultadominioselect(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM `cg_valores_dominio` WHERE id_dominio=25";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultadomnitipofirmotec(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM `cg_valores_dominio` WHERE id_dominio='24' AND (identificador=772 OR identificador=774)";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultausuarioxrolinspectores(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=1";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaencfirmas2(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_firma_inspectora";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaencfirmas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_firma_inspectora";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function consultaenccompanias(){
         if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_cias_seguros";
            return $this->con->consulta($consulta);
        }
    }
    
     function consultaencabezadoinspector(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_inspectores";
            return $this->con->consulta($consulta);
        } 
    }
    
    
    function extraercompaniaseguros($idusuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT uc.id_cliente,ter.nombres,ter.apellidos nombre FROM sg_usuarios_x_cliente uc,ter_terceros ter WHERE	uc.id_cliente = ter.identificacion AND uc.id_usuario = '$idusuario' AND ter.tipocliente = 772";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscainspectoreslist($id_menu_p){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios_x_cliente U ,sg_roles_x_usuario R,sg_usuarios C WHERE U.id_cliente='$id_menu_p' AND R.id_usuario = U.id_usuario AND R.id_rol IN (11,9) AND U.id_usuario = C.identificador";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscauserxtecnicos(){
        if($this->con->conectar()==true){
            $consulta  = "SELECT * FROM v_rol_x_usuario WHERE rol='Tecnico compa'";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscapreguntasB(){
        if($this->con->conectar()==TRUE){
            $consulta = "SELECT * FROM enc_preguntas";
            return $this->con->consulta($consulta);
        }
    }
    
    function preguntashijas($id_pregunta_padre){
        if($this->con->conectar()==true){
            $consulta  = "SELECT P.nombre, R.descripcion respuesta,E.nombre estado,
                                           (SELECT valor_alfa_numerico FROM enc_lista_valores V1 WHERE V1.identificador = P.id_valor_res_cierre) RespuestaCierre,
                                           (SELECT valor_alfa_numerico FROM enc_lista_valores V1 WHERE V1.identificador = P.id_valor_resp_activa_riesgo) RespuestaActivaCierre
                                            FROM enc_preguntas P ,enc_respuestas R,sg_estados E
                                            WHERE id_pregunta_padre='$id_pregunta_padre' AND R.identificador = P.id_respuesta 
                                            AND E.tipo_estado = P.tipo_estado 
                                            AND E.identificador = P.estado";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultarespuestas($filtro){
          if($this->con->conectar()==true){
              $consulta = "SELECT * FROM enc_respuestas WHERE identificador='$filtro' AND estado='1' ";
              return $this->con->consulta($consulta);
          }
    }
    
    function consultavaloresrespuesta($filtro){
         if($this->con->conectar()==true){
              $consulta = "SELECT * FROM enc_lista_valores 
                           JOIN sg_estados ON enc_lista_valores.estado = sg_estados.identificador 
                           WHERE enc_lista_valores.id_respuesta='$filtro' 
                           GROUP BY enc_lista_valores.identificador";
              return $this->con->consulta($consulta);
          }
    }
    /*
    function consultadatosfirma($filtrotel){
        if($this->con->conectar()=true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$filtrotel'";
            return $this->con->consulta($consulta);
        }
    }
    */
   
}

?>

