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

		$this->puerto='3306';

        $this->db='sipman_risk_hunter';

        $this->user='risk_hunter';

        $this->pass='Kaliman01*';

        $this->conexion="\"$this->user\",\"$this->pass\",\"$this->db\"";

        echo "cargue valores";

        

	}

 	//creación del constructor

	function conectar(){

		$this->cargarValores();
        $this->con=mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die('Error conectando a la Base de Datos');
        return $this->con;

    }

 

   	public function consulta($consulta){ 

    	$this->total_consultas++; 

       	$resultado = mysqli_query($this->conectar(), $consulta);

    	if(!$resultado)

         		return mysqli_connect_error();

		else {

         	return $resultado;

        }

  	}



  	public function fetch_array($consulta){

       if (isset($consulta))

   		return mysqli_fetch_array($consulta);

    }



  	public function fetch_assoc($consulta){

   		return mysqli_fetch_assoc($consulta);

  	}



  	public function num_rows($consulta){

   		return mysqli_num_rows($consulta);

  	}

  	

  	public funCtion affected_rows($consulta) {

  	    return mysqli_affected_rows($consulta);

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

		mysqli_close($this->con);

    }

         

}

?>

