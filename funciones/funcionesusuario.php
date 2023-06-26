<?php

        
         
                                        
  include "../clases/Json.class.php";
                   $Json     = new Json;  
                    $Json->iniciarVariables();
                    $xcompdominios = $Json->seltipoident();
                    $xrowdominios = array();
                    $xi=0;
                    while ($xrowdominios = $Json->obtener_fila($xcompdominios)) {
                           $nombre[$xi] = utf8_encode($xrowdominios['nombre']) ;
                           $identificador[$xi] = $xrowdominios['identificador'];
                        $xi++;
                    }
                    
                    if (isset($identificador[0])) {
                        $jsonproyecto["estado"] = "1";
                        $jsonproyecto["totald"] = $xi++;
                        $jsonproyecto["identificador"] = $identificador;
                        $jsonproyecto["nombre"] = $nombre;   
                        print json_encode($jsonproyecto);
                         //           header('Content-type: image/jpeg');
                        //           echo pg_unescape_bytea($foto[1]);
                 //        $Json->cerrar();
                //         var_dump($jsonproyecto);
                         return $jsonproyecto;
                        
                    }
                    else {
                        // Enviar respuesta de error general
                         print json_encode(
                            array(
                                'estado' => '2',
                                'mensaje' => 'No se obtuvo el registro'
                            )
                            );
                   //      $Json->cerrar();
                   $estado=2;
                   return $estado;
                         
                    }
                 //   $Json->cerrar();


?>
