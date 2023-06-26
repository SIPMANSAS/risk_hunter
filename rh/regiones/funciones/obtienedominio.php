<?php
include "../clases/Json.class.php";

         if (isset($_GET['codigo']))
         {
                $codigo  = $_GET["codigo"];
                $identificador = $_GET["identificador"];
                $nombre="";
         }
         else
         { 
             if (isset($_GET['nombre']))
             {
                 $nombre  = $_GET["nombre"];
                 $identificador = $_GET["identificador"];
                 $codigo="";
             }
             else {
                    $codigo = "";
                    $identificador ="p";
                    $nombre="";
             }
        }
        if(isset($_GET["codigodep"]))
        {
            $codigodep = $_GET["codigodep"];
        }
         
         
                                        
                   $Json     = new Json;              
                    $Json->iniciarVariables();
                    if ($identificador == "p")
                    {
                        $filtro = $identificador.".codigo like \"%".$codigo."%\" and ".
                            $identificador.".nombre like \"%".$nombre."%\"";
                            $xcompdominios = $Json->Buscapais($filtro);
                            
                    }
                        
                      elseif ($identificador == "d")
                      {
                          $filtro = $identificador.".codigo_pais = ".$codigo;
                         $xcompdominios = $Json->Buscadepartamento($filtro);
                          
                      }
                      else 
                      {
                          $filtro = $identificador.".codigo_pais = ".$codigo .
                          " and $identificador.codigo_departamento =".$codigodep;
                         $xcompdominios = $Json->Buscaciudad($filtro);  
                      }
                   
                    $xrowdominios = array();
                    $xi=0;
                    while ($xrowdominios = $Json->obtener_fila($xcompdominios)) {
                        $iddominio[$xi] = $xrowdominios['codigo'];
                        $nombredominio[$xi] = utf8_encode($xrowdominios['nombre']) ;
                        $tipoestado[$xi] = $xrowdominios['tipo_estado'];
                        $estadodominio[$xi] = $xrowdominios['estado']; 
                        if (isset($xrowdominios['es_capital']))
                            $escapital[$xi] = $xrowdominios['es_capital'];
                        else 
                            $escapital[$xi] = "";
                        if (isset($xrowdominios['codigop']))
                                $codigop[$xi] = $xrowdominios['codigop'];
                         else
                                $codigop[$xi] = "";
                        if (isset($xrowdominios['codigod']))
                             $codigod[$xi] = $xrowdominios['codigod'];
                         else
                             $codigod[$xi] = "";
                         if (isset($xrowdominios['pais']))
                             $pais[$xi] = utf8_encode($xrowdominios['pais']);
                         else
                                $pais[$xi] = "";
                         if (isset($xrowdominios['codigod']))
                             $departamento[$xi] = utf8_encode($xrowdominios['departamento']);
                         else
                                $departamento[$xi] = "";
                                        
                        $xi++;
                    }
                    if (isset($iddominio[0])) {
                        $jsonproyecto["estado"] = "1";
                        $jsonproyecto["totald"] = $xi++;
                        $jsonproyecto["iddominio"] = $iddominio;
                        $jsonproyecto["nombre"] = $nombredominio;
                        $jsonproyecto["tipo_estado"] = $tipoestado;
                        $jsonproyecto["estadodominio"] = $estadodominio;   
                        $jsonproyecto["escapital"] = $escapital;
                        $jsonproyecto["codigop"] = $codigop;
                        $jsonproyecto["codigod"] = $codigod;
                        $jsonproyecto["pais"] = $pais;
                        $jsonproyecto["departamento"] = $departamento;
                          
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

?>
