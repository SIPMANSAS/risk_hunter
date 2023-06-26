<?php 
include_once("conexion.php"); 
class utidatos { 
//constructor          
	var $con;       
	function iniciarVariables()
	{
		$this->con=new ConexionSQL; 
	}
	function obtener_fila($consulta){
	   return  $this->con->fetch_array($consulta);
	}
	
	function numero_filas($consulta){
	   return $this->con->num_rows($consulta);
	}
	
    function insertid()
      {
          return mysqli_insert_id($this->con);
      }


 	function numero_filas_afectadas($consulta){
			return $this->con->exec($consulta);
		}
	
	function obtener_codigo($consulta){
		return $this->con->ult_codigo($consulta);
	}

	function obtener_listado ($consulta){
		return $this->con->calc_filas($consulta);
	}

	function parametros_consulta ($consulta, $campos, $orden, $busqueda){
		$w=0; 
		$param='';
		if(count($campos)==count($busqueda)){
			for($i=0;$i<count($busqueda);$i++){
				if(($busqueda[$i]!="")&&($busqueda[$i]!="null")){
					$w=1;
					if(is_numeric($busqueda[$i])){
						$param.=$campos[$i]." = '".$busqueda[$i]."' AND ";
					}
					else{
						$param.=$campos[$i]." LIKE '%".$busqueda[$i]."%' AND ";
					}
				}
			}
		}
		else{
			if(($busqueda[0]!="")&&($busqueda[0]!="--")&&($busqueda[1]!="")&&($busqueda[1]!="--")){
				$w=1;
				$param.=$campos[0]." BETWEEN '".$busqueda[0]."' AND '".$busqueda[1]."' AND ";
			}
			for($i=2;$i<count($busqueda);$i++){
				if(($busqueda[$i]!="")&&($busqueda[$i]!="null")){
					$w=1;
					if(is_numeric($busqueda[$i])){
						$param.=$campos[$i-1]." = '".$busqueda[$i]."' AND ";
					}
					else{
						$param.=$campos[$i-1]." LIKE '%".$busqueda[$i]."%' AND ";
					}
				}
			}
		}
		if($w==1){
			$consulta.=' WHERE ';
			$consulta.=$param;
			$consulta=substr($consulta,0,-5);
			$limit=explode('LIMIT',$orden);
			$orden=rtrim($limit[0]);
		}
		$consulta.=$orden;			
		return $consulta;  		
	}

}


?>
