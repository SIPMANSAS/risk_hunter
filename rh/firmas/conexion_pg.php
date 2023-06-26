<?php 
class ConexionPgSQL{
	//declaración de variables
  	private $total_consultas;
	public $host; // para conectarnos a localhost o el ip del servidor de postgres
	public $db; // seleccionar la base de datos que vamos a utilizar	
	public $user; // seleccionar el usuario con el que nos vamos a conectar
	public $pass; // la clave del usuario
	public $conexion;
 	public $con; 

 	//creación de la función para cargar los valores de la conexión.
 	public function cargarValores(){
		$this->host='localhost';
		$this->puerto='5434';
        $this->db='sipman_risk_hunter';
        $this->user='postgres';
        $this->pass='qwe123';
        $this->conexion="host='localhost' dbname='sipman_risk_hunter' user='potgres' password='qwe123' ";
	}
 	//creación del constructor
	function conectar(){
		$this->cargarValores();
        $this->con=pg_connect($this->conexion);
        return $this->con;
    }
 
   	public function consulta($consulta){ 
    	$this->total_consultas++; 
    	$resultado = pg_query($this->conectar(), $consulta);
    	if(!$resultado)
         		return pg_last_error();
		else
	    	return $resultado;
  	}

  	public function fetch_array($consulta){
   		return pg_fetch_array($consulta);
  	}

  	public function fetch_assoc($consulta){
   		return pg_fetch_assoc($consulta);
  	}

  	public function num_rows($consulta){
   		return pg_num_rows($consulta);
  	}
  	
  	public funCtion affected_rows($consulta) {
  	    return pg_affected_rows($consulta);
    }

  	public function getTotalConsultas(){
   		return $this->total_consultas; 
  	}
	
	public function ult_codigo($consulta){
		$rows_codigo=$this->num_rows($consulta);
		if($rows_codigo>0){
			$row_codigo=$this->fetch_array($consulta);
			$ult_codigo=$row_codigo[0]+1;
		}
		else{
			$ult_codigo=1;
		}
		return $ult_codigo;
	}

	public function calc_filas($consulta){
		$row_total=$this->fetch_assoc($consulta);
		return $row_total['total'];
	}
 
    //función para destruir la conexión.
    function destruir(){
		pg_close($this->con);
    }
         
}
?>
