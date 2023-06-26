<?php 
class ConexionSQL{
	//declaración de variables
  	private $conexion; 
  	private $total_consultas;

	public $host; // para conectarnos a localhost o el ip del servidor de postgres
	public $db; // seleccionar la base de datos que vamos a utilizar	
	public $user; // seleccionar el usuario con el que nos vamos a conectar
	public $pass; // la clave del usuario
	public $url; //dirección de la conexión que se usara para destruirla mas adelante
 
 	//creación de la función para cargar los valores de la conexión.
 	public function cargarValores(){
		$this->host='localhost';
        $this->db='bd_mevais';
        $this->user='root';
        $this->pass='';
/*		$this->host='50.62.209.116:3306';
        $this->db='mevais';
        $this->user='enrique';
        $this->pass='790715';*/
	}
 	//creación del constructor
 	function __construct(){
		$this->cargarValores();
    	if(!isset($this->conexion)){
      		$this->conexion = new mysqli($this->host,$this->user,$this->pass,$this->db);
//      		$this->url = mysql_select_db($this->db,$this->conexion) or die(mysql_error());
    	}
        return $this->url;
    }
 
  	public function consulta($consulta){ 
    	$this->total_consultas++; 
    	$resultado = $this->conexion->query($consulta);
    	if(!$resultado){ 
	      	exit;
    	}
    	return $resultado;
  	}

  	public function fetch_array($consulta){
   		return $consulta->fetch_array();
  	}

  	public function fetch_assoc($consulta){
   		return $consulta->fetch_assoc();
  	}

  	public function num_rows($consulta){
   		return $consulta->num_rows;
  	}

  	public function getTotalConsultas(){
   		return $this->total_consultas; 
  	}
	
	public function ult_codigo($consulta){
		$rows_codigo=$this->num_rows($consulta);
		if($rows_codigo>0){
			$row_codigo=$this->fetch_array($consulta);
			$ult_codigo=(int) $row_codigo[0]+1;
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
	
   public function insertid()
      {
           return mysqli_insert_id($this->conexion);
      }

	
    //función para destruir la conexión.
    function destruir(){
		$this->conexion->close();
    }
         
}
?>
