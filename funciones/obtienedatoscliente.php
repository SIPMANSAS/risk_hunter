<?php
	include('../clases/json.class.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idcliente'])) 
    	$idcliente  = $_GET["idcliente"];
    else
        $idcliente = 1;
   $filtro = "A.idcliente = ". $idcliente;
   $Json     = new Json;
   $consulta = $Json->iniciarVariables();
   $xcomcliente = $Json->Buscaclientes($filtro);
   $xrowcliente = array();
	    $xi=0;
        $xrowcliente = $Json->obtener_fila($xcomcliente);
        if ( $xrowcliente['nombres'])
        {
             $actualrespuestas = $xrowcliente['actualrespuestas'];
             $maxrespuestas = $xrowcliente['maxrespuestas'];
             $nombrecliente = $xrowcliente['nombres'];
             $apellidocliente = $xrowcliente['apellidos'];
           $jsonproyecto["estado"] = "1";
           $jsonproyecto["actualrespuestas"] = $actualrespuestas;
           $jsonproyecto["maxrespuestas"] = $maxrespuestas;
           $jsonproyecto["nombrecliente"] = $nombrecliente;
           $jsonproyecto["apellidocliente"] = $apellidocliente;



           print json_encode($jsonproyecto);
//           header('Content-type: image/jpeg');
//           echo pg_unescape_bytea($foto[1]);

        }
        else {
         // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }
        $Json->cerrar();
    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }

?>
