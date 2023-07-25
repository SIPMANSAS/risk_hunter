<?php 
include "utidatos.class.php"; 

class bloques extends utidatos {

//constructor

  	function cerrar() {

	$this->con->destruir();

	}
	
	function consultalistaparametrizacion(){
	   if($this->con->conectar()==true){     
            $consulta= "SELECT * FROM ad_comunicaciones WHERE estado=1";
            return  $this->con->consulta($consulta);
        }
	}
	
	function consultalistaparametrizacioninactiva(){
	   if($this->con->conectar()==true){     
            $consulta= "SELECT * FROM ad_comunicaciones WHERE estado=0";
            return  $this->con->consulta($consulta);
        }
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
            $consulta = "SELECT * FROM ter_cruce_terceros JOIN ter_terceros ON ter_terceros.identificacion=ter_cruce_terceros.id_tercero_secundario WHERE ter_cruce_terceros.id_tercero_principal='$idcliente' AND ter_terceros.vdom_tipo_tercero=774 AND ter_cruce_terceros.estado=1 ORDER BY ter_terceros.nombres";
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
    
    function consultaciasxusuario($id_usuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT T.vdom_tipo_tercero,CL.id_cliente,CL.id_usuario,T.nombres,T.numero_identificacion FROM sg_usuarios_x_cliente CL ,ter_terceros T WHERE T.identificacion = CL.id_cliente AND CL.id_usuario = '$id_usuario' AND T.vdom_tipo_tercero = 772";
            return $this->con->consulta($consulta);
        }
    }
    
    
    function consultafirmasxusuario($id_usuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT T.vdom_tipo_tercero,CL.id_cliente,CL.id_usuario,T.nombres,T.numero_identificacion FROM sg_usuarios_x_cliente CL ,ter_terceros T WHERE T.identificacion = CL.id_cliente AND CL.id_usuario = '$id_usuario' AND T.vdom_tipo_tercero = 774";
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
    
    function buscaestado($fitlroestado){
       if($this->con->conectar()==true){
           $consulta="SELECT * FROM sg_estados WHERE tipo_estado=19 AND identificador='$fitlroestado'";
           return  $this->con->consulta($consulta);
       }
        
    }
    function tipoestadoselect($fitlroestado){
        if($this->con->conectar()==true){
            $consulta="SELECT * FROM sg_estados WHERE tipo_estado=19 AND identificador<>'$fitlroestado' ";
            return $this->con->consulta($consulta);
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
            $consulta = "SELECT * FROM v_bienes WHERE identificador='$filtrobienes'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabiendif($filtrobienes){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_bienes WHERE identificador<>'$filtrobienes'";
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
    
    function firmasasignadasB($idusuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$idusuario' AND ter_cruce_terceros.estado=1 GROUP BY ter_cruce_terceros.id_tercero_secundario";//GROUP BY ter_cruce_terceros.id_tercero_secundario
            return $this->con->consulta($consulta);
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
        }
    }
    
    function consultapreguntas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_preguntas WHERE identificador > 0 ";
            return $this->con->consulta($consulta);
        }
    }
    
    function pintaformulario(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainspectoresindependientes(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=1 ORDER BY numidentificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainspectoresindependientesinactivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 AND estado=0";
            return $this->con->consulta($consulta);
        }
    }
    
     function consultainspectoresfirmainspectora(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainspectoresfirmainspectorainactivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=0";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainspectoresfirmas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=27 AND estado=1";
            return $this->con->consulta($consulta);
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
            $consulta = "SELECT * FROM v_bienes ORDER BY nombre";
            return $this->con->consulta($consulta);
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
            $consulta = "SELECT * FROM sg_usuarios WHERE tipo_estado=28 || tipo_estado=9 AND estado=1 ORDER BY numidentificacion";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaencfirmas2($id_menu_p){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_firma_inspectora WHERE id_usuario = '$id_menu_p'";
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
            //$consulta = "SELECT * FROM v_parrilla_inspectores_B";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultaencabezadoinspectorfree(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_parrilla_inspectores_B WHERE identificador = 4";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultaparrillacompleta(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_sabana";
            return $this->con->consulta($consulta);
        } 
    }
    
    
    function extraercompaniaseguros($idusuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT uc.id_cliente,ter.nombres,ter.apellidos nombre FROM sg_usuarios_x_cliente uc,ter_terceros ter WHERE	uc.id_cliente = ter.identificacion AND uc.id_usuario = '$idusuario' AND ter.tipocliente = 772 ";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscainspectoreslist($id_menu_p){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios_x_cliente U ,sg_roles_x_usuario R,sg_usuarios C WHERE U.id_cliente='$id_menu_p' AND R.id_usuario = U.id_usuario AND R.id_rol IN (11,9) AND U.id_usuario = C.identificador";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscauserxtecnicosB(){
        if($this->con->conectar()==true){
            $consulta  = "SELECT * FROM v_rol_x_usuario WHERE rol LIKE '%Tecnico compa%'";
            return $this->con->consulta($consulta);
        }
    }
    
    function buscauserxtecnicosC($idusuario){
        if($this->con->conectar()==true){
            $consulta  = "SELECT * FROM v_rol_x_usuario WHERE rol='Tecnico CIA Seguros'";
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
    
    function consultainspecciones(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_detalles_inspeccion D JOIN enc_inspeccion E ON D.id_inspeccion = E.identificador";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultasabana(){
        if($this->con->conectar()==true){
            $consulta = "SELECT distinct origen,usuario_actualizacion,fecha_terminacion,fecha_actualizacion,bloque_inspeccion,longitud,des_td_solicitante,latitud,estrato,espacio_geografico,departamento,pais,inspector_firma_inspectora,contacto_firma,nombre_inspector,nombre_oficina,nombre_asigna,identificador,numero_inspeccion,fecha_solicitud,cia_seguros,ciudad,fecha_inspeccion,direccion,tid_solicita,nid_solicita,nombre_solicita,tomador,asegurado,nombre_persona_atiende,contacto_persona_atiende,firma_inspectora,id_firma_inspectora,estado,nombre_edificacion,facturacion,id_pais,fecha_posible_inspeccion,lista_bienes FROM v_sabana ORDER BY numero_inspeccion ASC";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultasabanafreemium($id_usuario_ext){
        if($this->con->conectar()==true){
            $consulta = "SELECT distinct id_usuario,origen,usuario_actualizacion,fecha_terminacion,fecha_actualizacion,bloque_inspeccion,longitud,des_td_solicitante,latitud,estrato,espacio_geografico,departamento,pais,inspector_firma_inspectora,contacto_firma,nombre_inspector,nombre_oficina,nombre_asigna,identificador,numero_inspeccion,fecha_solicitud,cia_seguros,ciudad,fecha_inspeccion,direccion,tid_solicita,nid_solicita,nombre_solicita,tomador,asegurado,nombre_persona_atiende,contacto_persona_atiende,firma_inspectora,id_firma_inspectora,estado,nombre_edificacion,facturacion,id_pais,fecha_posible_inspeccion,lista_bienes FROM v_sabana WHERE origen LIKE '%FR%' AND id_usuario='$id_usuario_ext' ORDER BY identificador DESC";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainmuebles($filtro){
        if($this->con->conectar()==true){
            $consulta = "SELECT e2.*,v1.descripcion tipo_de_bien,id_dominio, ( SELECT descripcion FROM enc_inmuebles e1 WHERE e1.identificador=e2.id_bien_principal) bien_contenedor FROM enc_inmuebles e2, cg_valores_dominio v1 WHERE v1.identificador=tipo_bien AND id_encuesta='$filtro'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainmueblefiltro($filtro){
       if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_inmuebles WHERE identificador=$filtro";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultabienestipo($id_inspeccion){
        if($this->con->conectar()==true){
            $consulta = "SELECT e2.*,v1.descripcion tipo_de_bien, ( SELECT descripcion FROM enc_inmuebles e1 WHERE e1.identificador=e2.id_bien_principal) bien_contenedor FROM enc_inmuebles e2, cg_valores_dominio v1 WHERE v1.identificador=tipo_bien AND v1.id_dominio IN (7,8,9) AND id_encuesta = '$id_inspeccion' ORDER BY e2.descripcion ASC";
             return $this->con->consulta($consulta);
        }
    }
    
    function selecttipobien(){
        if($this->con->conectar()==true){
            $consulta = "SELECT DISTINCT VD.* FROM cg_valores_dominio VD,enc_bloque_preguntas B WHERE VD.id_dominio IN (4,7,8,9) AND VD.identificador = B.id_bien ORDER BY VD.nombre ASC";
             return $this->con->consulta($consulta);
        }
    }
    
    function tipobien(){
        if($this->con->conectar()==true){
            $consulta = "SELECT tipo bien FROM enc_inmuebles";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainmueblesB($filtro){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_inmuebles WHERE identificador='$filtro'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainmueblesR($filtro){
        if($this->con->conectar()==true){
            $consulta= "SELECT D.descripcion descripcion_riesgo,D.id_alfanumerico,C.identificador,I.descripcion,C.calificacion FROM enc_inmuebles I,enc_calificacion_riesgos_inmueble C,cg_valores_dominio D 
                        WHERE $filtro
                        AND id_riesgo=D.identificador 
                        AND I.identificador = C.id_bien ORDER BY D.id_alfanumerico ASC";

                      
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaexistencia(){
        if($this->con->conectar()==true){
            $consulta = "SELECT COUNT(identificador) AS Cantidad FROM enc_inmuebles";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabloquesinactivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_bloque_preguntas WHERE estado=0";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultanivelprioridad(){
       if($this->con->conectar()==true){
            $consulta = "SELECT * FROM cg_valores_dominio WHERE id_dominio = 27";
            return $this->con->consulta($consulta);
        } 
    }
    
    function consultariesgosgraficas(){
        if($this->con->conectar()==true){
            $consulta = "SELECT I.identificador Encuesta,I.descripcion Inmueble,D.descripcion Riesgo, D.id_alfanumerico Av,C.calificacion FROM enc_calificacion_riesgos_inmueble C, cg_valores_dominio D, enc_inmuebles I WHERE I.identificador = C.id_bien AND D.identificador = C.id_riesgo";
             return $this->con->consulta($consulta);
        }
    }
    
    function consultadetalleinspeccion($id_encuesta,$identificador){
        if($this->con->conectar()==true){
            $consulta = "       SELECT (SELECT B.descripcion 
                                FROM enc_bloque_preguntas B ,enc_preguntas P 
                                WHERE P.identificador = D.id_pregunta 
                                AND B.identificador=P.id_bloque_preguntas) bloque_pregunta, 
                                (SELECT nombre FROM enc_preguntas WHERE identificador=id_pregunta) pregunta, respuesta_texto, archivos,V.valor_alfa_numerico 
                                FROM enc_detalles_inspeccion D ,enc_lista_valores V
                                WHERE D.id_inspeccion = '$id_encuesta' 
                                AND D.bloque_inspeccion = '$identificador'
                                AND D.id_respuesta = V.identificador";
            return $this->con->consulta($consulta);
        }
    }
    
     function consultadetalleinspeccionB($id_encuesta){
        if($this->con->conectar()==true){
            $consulta = "      SELECT R.nombre,D.id_inspeccion,D.id_pregunta,D.id_respuesta,D.respuesta_texto 
                               FROM `enc_detalles_inspeccion` D ,enc_preguntas R 
                               WHERE id_inspeccion = '$id_encuesta' 
                               AND D.id_respuesta = R.identificador;";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultamatriz(){
         if($this->con->conectar()==true){
             $consulta= "SELECT * FROM v_matriz_p_r ORDER BY identificador";
             return $this->con->consulta($consulta);
         }
    }

    
    function consultaexistenciaB($id_inspeccion){
        if($this->con->conectar()==true){
            $consulta = "SELECT COUNT(identificador) AS Cantidad FROM enc_inmuebles WHERE id_encuesta='$id_inspeccion'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaDataMatriz($identificador_bien,$id_encuesta){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_matriz_p_r WHERE identificador='$identificador_bien' AND id_inspeccion='$id_encuesta'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaoficinaB($idusuario){
        if($this->con->conectar()==true){
            $consulta = "SELECT T.identificador,T.nombre FROM sg_usuarios U, ter_oficinas T WHERE U.identificador= '$idusuario' AND T.identificador = U.id_oficina";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultatelefono($idcliente){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$idcliente'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabieneslista(){
       if($this->con->conectar()==true){
            $consulta = "SELECT * FROM cg_valores_dominio WHERE id_dominio BETWEEN 4 AND 8 ORDER BY nombre";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultacantidadB($id_inspeccion,$id_bloque,$id_detalle_inspeccion){
        if($this->con->conectar()==true){
            $consulta = "SELECT COUNT(id_inspeccion) AS Cantidad FROM enc_detalles_inspeccion WHERE id_inspeccion = '$id_inspeccion' AND consecutivo = '$id_detalle_inspeccion' AND id_valor_respuesta = id_valor_respuesta";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaenclistabienes($id){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_lista_bienes WHERE id_inspeccion = '$id'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaprevia($id){
        if($this->con->conectar()==true){
            $consulta = "SELECT C.nombre FROM enc_detalles_inspeccion I , enc_columnas_bienes C WHERE I.id_inspeccion = '$id' AND I.consecutivo = 100 AND C.id_valor_respuesta = I.id_valor_respuesta";
            return $this->con->consulta($consulta);
        }
    }
    
    function realizasuma($id){
        if($this->con->conectar()==true){
            $consulta = "SELECT SUM(valor_numerico) AS total FROM enc_lista_bienes WHERE id_inspeccion='$id'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultacompB($filtrocomp){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$filtrocomp'";
            return $this->con->consulta($consulta);
        }
        
    }
    
    function consultadatosfirma($filtrotel){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$filtrotel'";
            return $this->con->consulta($consulta);
        }
    }
    
    function parrillainmuebles($id_inspeccionB,$id_inspeccion){
        if($this->con->conectar()==true){
            $consulta = "SELECT COUNT(identificador) AS Cantidad FROM enc_inmuebles WHERE id_encuesta='$id_inspeccionB' or id_encuesta='$id_inspeccion'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultainspectorenc($firmainspectora){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_usuarios_x_cliente U ,sg_roles_x_usuario R,sg_usuarios C WHERE U.id_cliente='$firmainspectora' ";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaestratos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM cg_valores_dominio WHERE id_dominio =28";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaespaciogeografico(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM cg_valores_dominio WHERE id_dominio =29";
            return $this->con->consulta($consulta);
        }
    }
    
    function insertafirmas($tipoDoc,$firmaInspectora,$tipoTercer,$tipoEstado,$numeroIdentificacion,$paises_id,$departamento_id,$ciudad_id,$direccion,$correoElectronico,$numeroContacto,$tipoinspector,$inspector){
        if($this->con->conectar()==true){
            $consulta = "INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente,id_tercero)
            VALUES('$tipoDoc','$firmaInspectora','$tipoTercer','$tipoEstado','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','$tipoinspector','$inspector')";
            return $this->con->consulta($consulta);
        }
    }
    
    function insertaciaseguros($tipoDoc,$firmaInspectora,$tipoTercer,$tipoEstado,$numeroIdentificacion,$paises_id,$departamento_id,$ciudad_id,$direccion,$correoElectronico,$numeroContacto,$tipoinspector,$inspector){
        if($this->con->conectar()==true){
            $consulta = "INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente,id_tercero)
            VALUES('$tipoDoc','$firmaInspectora','$tipoTercer','$tipoEstado','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','$tipoinspector','$inspector')";
            return $this->con->consulta($consulta);
        }
    }
    
    function desasignarfirma($tercero,$id){
        if($this->con->conectar()==true){
            $consulta = "UPDATE ter_cruce_terceros SET estado = '2' WHERE id_tercero_principal = '$id' AND id_tercero_secundario='$tercero' AND estado=1";
            return $this->con->consulta($consulta);
        }
    }
    
    function insertapadre($nombre_edificacion,$constante,$direccion,$id_inspeccion){
        if($this->con->conectar()==true){
            $consulta = "INSERT INTO enc_inmuebles(descripcion,tipo_bien,observaciones,id_encuesta)VALUES('$nombre_edificacion','$constante','$direccion','$id_inspeccion')";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabuscadorsabana($id_inspeccion){
         if($this->con->conectar()==true){
            $consulta = "SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultabuscadorfirmas($id){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion = '$id'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultatipodoc($tipoidentificacion){
        if($this->con->conectar()==true){
            $consulta = "SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND cvd.identificador='$tipoidentificacion'";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaarchivoscantidad(){
        if($this->con->conectar()==true){
            $consulta = "SELECT COUNT(*) AS Cantidad FROM cargue_archivos_planos";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultaarchivos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT *  FROM cargue_archivos_planos";
            return $this->con->consulta($consulta);
        }
    }
    
    function consultanumero($filtrotel){
       if($this->con->conectar()==true){
            $consulta = "SELECT * FROM ter_terceros WHERE identificacion='$filtrotel'";
            return $this->con->consulta($consulta);
        } 
    }
    
    function tiporespuesta(){
       if($this->con->conectar()==true){
            $consulta = "SELECT identificador,descripcion FROM enc_respuestas ";
            return $this->con->consulta($consulta);
        } 
    } 
    
    function seldepB($val_cierre){
        if($this->con->conectar()==true){
            $consulta= "SELECT * FROM enc_lista_valores WHERE id_respuesta='$val_cierre'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function seldepC($id_resp_riesgo){
        if($this->con->conectar()==true){
            $consulta= "SELECT * FROM enc_lista_valores WHERE identificador='$id_resp_riesgo'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function seldepD($id_resp_riesgo){
        if($this->con->conectar()==true){
            $consulta= "SELECT * FROM enc_lista_valores WHERE identificador='$id_resp_riesgo'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function textorespuesta(){
        if($this->con->conectar()==true){
            $consulta= "SELECT * FROM cg_valores_dominio WHERE id_dominio = 30";
            return  $this->con->consulta($consulta);
        }
    }
    
    function buscatipores($filtrodoc){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM cg_valores_dominio WHERE id_dominio = 30 AND identificador<>$filtrodoc";
            return  $this->con->consulta($consulta);
        }
    }
    
    function buscatiporesB(){
        if($this->con->conectar()==true){            
            $consulta="SELECT identificador,descripcion FROM enc_respuestas";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultalistariesgos(){
        if($this->con->conectar()==true){            
            $consulta="SELECT * FROM cg_valores_dominio WHERE id_dominio=10;";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultaestadoriesgos(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM sg_estados WHERE tipo_estado=19;";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultapregunta($id_pregunta){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM enc_preguntas WHERE identificador='$id_pregunta'";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultariesgoasignado($id_pregunta){
        if($this->con->conectar()==true){
            //$consulta = "SELECT * FROM enc_riesgo_a_activar WHERE id_pregunta='$id_pregunta'";
            $consulta = "SELECT CONCAT(V.id_alfanumerico,' ',V.nombre) Riesgo,V.identificador, ES.nombre,E.texto_informe,E.id_pregunta,E.estado 
                         FROM enc_riesgo_a_activar E , sg_estados ES ,cg_valores_dominio V 
                         WHERE V.identificador = E.id_riesgo 
                         AND ES.tipo_estado = E.tipo_estado 
                         AND ES.identificador = E.estado 
                         AND E.id_pregunta = '$id_pregunta' 
                         ORDER BY V.nombre;";
            return  $this->con->consulta($consulta);
        }
    }
    
    function consultardatoscargamasiva(){
        if($this->con->conectar()==true){
            $consulta = "SELECT * FROM carga_masiva WHERE identificador > 1";
            return  $this->con->consulta($consulta);
        }
    }   
}
?>