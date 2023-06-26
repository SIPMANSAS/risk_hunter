<?php
	include('../clases/json.class.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idcliente'])) 
    	$idcliente  = $_GET["idcliente"];
    else
        $idcliente = 1;
    if (isset($_GET['idproyecto'])) 
    	$idproyecto  = $_GET["idproyecto"];
    else
        $idproyecto = "";
         $filtro = "A.idcliente = ". $idcliente . " and A.idproyecto like \"%".$idproyecto."%\"";
         $Json     = new Json;
        $consulta = $Json->iniciarVariables();
        $xcompproyectos = $Json->Buscaproyectos($filtro);
       	$xrowproyectos = array();
	    $xi=0;
       while ($xrowproyectos = $Json->obtener_fila($xcompproyectos)) {
             $idproyecto[$xi] = $xrowproyectos['idproyecto'];
             $nombreproyecto[$xi] = $xrowproyectos['nombreproyecto'] ;
             $fechacreacion[$xi] = $xrowproyectos['fechacreacion'];
             $numerorespuestas[$xi] = $xrowproyectos['numerorespuestas'];
             $foto[$xi] = $xrowproyectos['foto'];
             $actualrespuestas[$xi] = $xrowproyectos['actualrespuestas'];
             $maxrespuestas[$xi] = $xrowproyectos['maxrespuestas'];
             $nombrecliente[$xi] = $xrowproyectos['nombres'];
             $apellidocliente[$xi] = $xrowproyectos['apellidos'];
             $numrespuestas[$xi] = $xrowproyectos['numerorespuestas'];

             $xi++;
        }
        if (isset($idproyecto[0])) {
           $jsonproyecto["estado"] = "1";
           $jsonproyecto["idproyecto"] = $idproyecto;
           $jsonproyecto["nombreproyecto"] = $nombreproyecto;
           $jsonproyecto["foto"] = $foto;
           $jsonproyecto["numrespuestas"] = $numerorespuestas;
           $jsonproyecto["totproyectos"] = $xi;
           $jsonproyecto["fechacreacion"] = $fechacreacion;
           $jsonproyecto["actualrespuestas"] = $actualrespuestas;
           $jsonproyecto["maxrespuestas"] = $maxrespuestas;
           $jsonproyecto["nombrecliente"] = $nombrecliente;
           $jsonproyecto["apellidocliente"] = $apellidocliente;
           $jsonproyecto["numrespuestas"] = $numrespuestas;



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
