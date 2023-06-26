<?php 

$archivo = __DIR__ . "/configuracion.php";

$contenido = parse_ini_file($archivo, false);
$BD = $contenido["BD"];
if ($BD == "mysql")
   include_once 'conexion_ms.php';
else
   include_once 'conexion_pg.php';
   
class utidatos { 
//constructor          
	var $con;       
	function iniciarVariables(){
 		$this->con = new conexion_ms;
	}

	function obtener_fila($consulta){
		if($this->con->conectar()==true){
           			return  $this->con->fetch_assoc($consulta);

		}
	}

	function numero_filas($consulta){
		if($this->con->conectar()==true){
			return $this->con->num_rows($consulta);
		}
	}
	
	function numero_filas_afectadas($consulta){
		if($this->con->conectar()==true){
			return $this->con->affected_rows($consulta);
		}
	}
	
	function obtener_codigo($consulta){
		if($this->con->conectar()==true){
			return $this->con->ult_codigo($consulta);
		}
	}

	function parametros_consulta ($consulta, $campos, $orden, $busqueda){
		if($this->con->conectar()==true){ 
			$w=0; 
			for($i=0;$i<count($busqueda);$i++){
				if(($busqueda[$i]!="")&&($busqueda[$i]!="null")){
					$w=1;
					$param.=$campos[$i]." LIKE '%".$busqueda[$i]."%' AND ";
				}
			}
			if($w==1){
				$consulta.=' WHERE ';
				$consulta.=$param;
				$consulta=substr($consulta,0,-5);
				$offset=explode('OFFSET',$orden);
				$orden=$offset[0];
			}
			$consulta.=$orden;			
			return $consulta;  		
		}
	}

}
?>
