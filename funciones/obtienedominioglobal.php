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
 /*       if(isset($_GET["codigodep"]))
        {
            $codigodep = $_GET["codigodep"];
        }
 */        
         
                                        
        
                   $Json     = new Json;  
                    $Json->iniciarVariables();
                    if ($identificador == "p")
                    {
                      /*  $filtro = $identificador.".codigo like \"%".$codigo."%\" and ".
                            $identificador.".nombre like \"%".$nombre."%\"";*/
                      //      $xcompdominios = $Json->Buscagrupodominios($filtro);
                            $xcompdominios = $Json->Buscagrupodominios();
                            
                    }
                        
                      else
                      {
                          echo $filtro = "grupo = ".$codigo;
                         $xcompdominios = $Json->Buscadominios($filtro);
                       }
                    
                   
                    $xrowdominios = array();
                    $xi=0;
                    while ($xrowdominios = $Json->obtener_fila($xcompdominios)) {
                        if ($identificador == "d")
                        {
                            $iddominio[$xi] = $xrowdominios['grupo'];
                            $grupo_dominio[$xi] = utf8_encode($xrowdominios['grupo_dominio']);
                        }
                        else    
                            $iddominio[$xi] = $xrowdominios['identificacion'];
                        $nombredominio[$xi] = utf8_encode($xrowdominios['nombre']) ;
                        if (isset($xrowdominios['descripcion']))
                            $descripcion[$xi] = utf8_encode($xrowdominios['descripcion']);
                        if (isset($xrowdominios['clasificacion']))       
                            $clasificacion[$xi] = utf8_encode($xrowdominios['clasificacion']); 
                        if (isset($xrowdominios['id_alfanumerico']))
                            $id_alfanumerico[$xi] = $xrowdominios['id_alfanumerico'];
                        if (isset($xrowdominios['valor_padre']))
                            $valor_padre[$xi] = utf8_encode($xrowdominios['valor_padre']);
                                
                        $xi++;
                      
                    }
                    if (isset($iddominio[0])) {
                        $jsonproyecto["estado"] = "1";
                        $jsonproyecto["totald"] = $xi++;
                        $jsonproyecto["iddominio"] = $iddominio;
                        $jsonproyecto["nombre"] = $nombredominio;
                        $jsonproyecto["grupo_dominio"] = $grupo_dominio;
                        $jsonproyecto["descripcion"] = $descripcion;
                        $jsonproyecto["clasificacion"] = $clasificacion;   
                        $jsonproyecto["id_alfanumerico"] = $id_alfanumerico;
                        $jsonproyecto["valor_padre"] = $valor_padre;
                        
                         print json_encode($jsonproyecto);
                         //           header('Content-type: image/jpeg');
                        //           echo pg_unescape_bytea($foto[1]);
                         $Json->cerrar();
                         
                        
                    }
                    else {
                        // Enviar respuesta de error general
                         print json_encode(
                            array(
                                'estado' => '2',
                                'mensaje' => 'No se obtuvo el registro'
                            )
                            );
                         $Json->cerrar();
                         
                    }
                    $Json->cerrar();

?>
