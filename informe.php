    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        //include  "clases/otrobloques.class.php";
         include 'conexion/conexion.php';
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
          <link rel="shortcut icon" href="favicon.ico">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista Encabezados</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
       
        <?php include 'header-rh.php'; ?>
        
   
        <div class="titulo_p">
            <center><i class="fa-solid fa-file"></i> SABANA COMPLETA DE INSPECCIONES</center>
        </div>
          <div class="contenedor_titulos">
            <div class=" titulo">Número de <br>Inspección</div>
            <div class=" titulo"><b>Fecha Solicitud</b></div>
            <div class=" titulo">Compañía de <br> Seguros</div>
            <div class=" titulo">Nombre de <br> Quien Asigna</div>
            <div class=" titulo"><b>Ubicación de <br>realización</b></div>
            <div class=" titulo"><b>Nombre edificación</b></div>
            <div class=" titulo"><b>Dirección del <br>bien</b></div>
            <div class=" titulo"><b>Fecha de inspección</b></div>
          </div>
    
          <?php
           if(isset($_POST['ident'])){
                'ENTRA BOTON';
                $id_inspeccion = $_POST['id'];
                $consultabuscador = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'");
                $extraerdatos = $consultabuscador->fetch_array(MYSQLI_ASSOC);
                $numero_inspeccion = $extraerdatos['numero_inspeccion'];
                $fecha_solicitud = $extraerdatos['fecha_solicitud'];
                $companiaseguros = $extraerdatos['cia_seguros'];
                $nombreasigna = $extraerdatos['nombre_asigna'];
                $pais_id = $extraerdatos['pais'];
                $departamento_id = ($extraerdatos['departamento']);
                $ciudad = $extraerdatos['ciudad'];
                $direccion = $extraerdatos['direccion']; 
                $fechainspeccion = $extraerdatos['fecha_inspeccion'];
                $identificador = $extraerdatos['identificador'];
                
                $nombresolicita = $extraerdatos['nombre_solicita'];
                $tipodocumentosolicitante = $extraerdatos['des_td_solicitante'];
                $numeroidentificacio = $extraerdatos['nid_solicita'];
                $tomador = $extraerdatos['tomador'];
                $npersonaatiende = $extraerdatos['nombre_persona_atiende'];
                $cpersonaatiende = $extraerdatos['contacto_persona_atiende'];
                $asegurado = $extraerdatos['asegurado'];
                $direccion = $extraerdatos['direccion']; 
                
                
                $inspectorasignadoF = $extraerdatos['nombre_inspector'];
                $contactofirma = $extraerdatos['contacto_firma'];
                $inspectorasignado = $extraerdatos['inspectorasignado'];
                $oficinaB = $extraerdatos['nombre_oficina'];
                $firmainspectora = $extraerdatos['firma_inspectora'];
                $nombreedificacion =$extraerdatos['nombre_edificacion'];
                $fecha_posible_inspeccion = $extraerdatos['fecha_posible_inspeccion'];
                
                $estado = $extraerdatos['estado'];
                
                $longitud = $extraerdatos['longitud'];
                $latitud = $extraerdatos['latitud'];
                $espaciogeografico = $extraerdatos['espacio_geografico'];
                $estrato = $extraerdatos['estrato'];
            
            ?>
            <div class="contenedor">
                <div class="campos_f">
                    <?php 
                    echo $identificador = $extraerdatos['numero_inspeccion'];
                ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_solicitud; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                <div class="campos_f">
                  <?php echo $nombreasigna; ?>
                </div>
                <div class="campos_f">
                  <?php echo $departamento_id.'-'.$ciudad; ?>
                </div>
                <div class="campos_f">
                  <?php echo ($nombreedificacion); ?>
                </div>
                <div class="campos_f">
                  <?php echo $direccion; ?>
                </div>
                
                <div class="campos_f">
                  <?php echo $fecha_posible_inspeccion; ?>
                </div>
            </div>   
            <br>
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-user"></i> INFORMACIÓN SOLICITANTE  </center>
            </div>
            <div class="contenedor_titulos">
            <div class=" titulo">Solicitante</div>
            <div class=" titulo">Número de <br>Identificación</div>
            <div class=" titulo"><b>Tomador</b></div>
            <div class=" titulo">Encargado de atender la inspección</div>
            <div class=" titulo"><b>Contacto del encargado</b></div>
            <div class=" titulo">Asegurado</div>
          </div>
            <div class="contenedor">
                <div class="campos_f">
                <?php echo ($nombresolicita); ?>
                </div>
                <div class="campos_f">
                  <?php echo $tipodocumentosolicitante.' '.$numeroidentificacio; ?>
                </div>
                 <div class="campos_f">
                 <?php echo utf8_decode($tomador) ?>
                </div>
                <div class="campos_f">
                  <?php echo ($npersonaatiende); ?>
                </div>
                <div class="campos_f">
                  <?php echo ($cpersonaatiende); ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_decode($asegurado); ?>
                </div>
            </div>   
            </div>

            
            <br>
             <div class="titulo_p">
                <center><i class="fa-solid fa-search"></i> INFORMACIÓN INSPECTOR - FIRMA INSPECTORA  </center>
            </div>
            <div class="contenedor_titulos">
            <div class=" titulo">Firma Inspectora</div>
            <div class=" titulo"><b>Contacto Firma</b></div>
            <div class=" titulo">Compañía de <br> Seguros</div>
             <div class=" titulo">Oficina</div>
          </div>
          <div class="contenedor">
                <div class="campos_f">
                <?php 
                    echo $firmainspectora;
                ?>
                </div>
                <div class="campos_f">
                  <?php echo $contactofirma; ?>
                </div>
                <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                <div class="campos_f">
                  <?php echo $oficinaB; ?>
                </div>
            </div> 
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-check"></i> UBICACIÓN GEOESTACIONARIA</center>
                <?php
                $bloques    = new bloques;
                    $consulta = $bloques->iniciarVariables();
                    $filtro = $id_inspeccion;
                    $consultainmuebles = $bloques->consultainmuebles($filtro);
                ?>
            </div> 
            <div class="contenedor_titulos">
                <div class=" titulo">Longitud</div>
                <div class=" titulo"><b>Latitud</b></div>
                <div class=" titulo"><b>Estrato</b></div>
                <div class=" titulo"><b>Espacio Sociogeografico</b></div>
            </div>
            <div class="contenedor">
                <div class="campos_f">
                  <?php echo $longitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $latitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $estrato; ?>
                </div>
                <div class="campos_f">
                  <?php echo $espaciogeografico; ?>
                </div>
            </div>
            <div class="contenedor">
               <iframe width="1770" height="500" src="https://maps.google.com/maps?q=<?php echo $latitud; ?>,<?php echo $longitud; ?>&output=embed"></iframe>
            </div>
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-check"></i> INFORMACIÓN DE BIENES A INSPECCIONAR</center>
            </div>    
                <div class="contenedor_titulos">
                    <div class=" titulo">Identificador</div>
                    <div class=" titulo">Bien Principal</div>
                    <div class=" titulo">Inmueble</div>
                    <div class=" titulo">Tipo de Inmueble</div>
                    <div class=" titulo">Dirección</div>
                    <div class=" titulo">Acciones</div>
                </div>
                <?php
                    
                    while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
                    ?>
                    <div class="contenedor">
                        <form action="verinmuebles.php" id="form" method="POST">
                            <input type="hidden" value="<?php echo $id=$extraerDatos['identificador'] ?>" name="identificador">
                            <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                        </form>
                        <div class="campos_f">
                          <?php echo $identificadorI=$extraerDatos['identificador']; ?>
                        </div>
                        <div class="campos_f">
                          <?php echo ($extraerDatos['bien_contenedor']); ?>
                        </div>
                        <div class="campos_f">
                          <?php echo ($extraerDatos['descripcion']); ?>
                        </div>
                        <div class="campos_f">
                          <?php echo $extraerDatos['tipo_de_bien']; ?>
                        </div>
                          <div class="campos_f">
                          <?php echo $extraerDatos['observaciones']; ?>
                        </div>
                        <div class="campos_f">
                          <form action="detalleinspeccion.php" method="POST" target="_blank">
                            <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                            <input type="hidden" value="<?php echo $id= $extraerDatos['identificador'] ?>" name="identificador">
                            <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                            <button class="btn_azul" name="inspeccionar">Consultar</button>
                          </form>
                          <form action="riesgosinmueble.php" method="GET" target="_blank" >
                            <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                            <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                            <?php /*<input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">*/?>
                             <button class="btn_verde">Calificación<br>Riesgos</button>
                          </form>

                          <?php
                          /*
                          openWindow()
                           <form action="asignarinspectores.php" method="POST">
                              <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                              <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                              <button class="btn_verde" type="submit">Asignar Inspectores</button>
                          </form>
                          */
                          ?>
                        </div>
                    </div>
                    <?php
                    }
          }else{
                $id_inspeccion = $_POST['id'];
                'ENTRA BUSQUEDA';
          
                /*$bloques    = new bloques;
                $consulta = $bloques->iniciarVariables();
                $consultasabana = $bloques->consultabuscadorsabana($id_inspeccion);
                $extraerdatos =  $bloques->obtener_fila($consultasabana);
               */
          
                $consultabuscador = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'");
                $extraerdatos = $consultabuscador->fetch_array(MYSQLI_ASSOC);
                $id_inspeccion = $extraerdatos['identificador'];
                $numero_inspeccion = $extraerdatos['numero_inspeccion'];
                $fecha_solicitud = $extraerdatos['fecha_solicitud'];
                $companiaseguros = $extraerdatos['cia_seguros'];
                $nombreasigna = $extraerdatos['nombre_asigna'];
                $pais_id = $extraerdatos['pais'];
                $departamento_id = ($extraerdatos['departamento']);
                $ciudad = $extraerdatos['ciudad'];
                $direccion = $extraerdatos['direccion']; 
                $fechainspeccion = $extraerdatos['fecha_inspeccion'];
                $identificador = $extraerdatos['identificador'];
                
                $nombresolicita = $extraerdatos['nombre_solicita'];
                $tipodocumentosolicitante = $extraerdatos['des_td_solicitante'];
                $numeroidentificacio = $extraerdatos['nid_solicita'];
                $tomador = $extraerdatos['tomador'];
                $npersonaatiende = $extraerdatos['nombre_persona_atiende'];
                $cpersonaatiende = $extraerdatos['contacto_persona_atiende'];
                $asegurado = $extraerdatos['asegurado'];
                $direccion = $extraerdatos['direccion']; 
                
                
                $inspectorasignadoF = $extraerdatos['nombre_inspector'];
                $contactofirma = $extraerdatos['contacto_firma'];
                $inspectorasignado = $extraerdatos['inspectorasignado'];
                $oficinaB = $extraerdatos['nombre_oficina'];
                $firmainspectora = $extraerdatos['firma_inspectora'];
                $nombreedificacion =$extraerdatos['nombre_edificacion'];
                $fecha_posible_inspeccion = $extraerdatos['fecha_posible_inspeccion'];
                
                $estado = $extraerdatos['estado'];
                
                $longitud = $extraerdatos['longitud'];
                $latitud = $extraerdatos['latitud'];
                $espaciogeografico = $extraerdatos['espacio_geografico'];
                $estrato = $extraerdatos['estrato'];
         ?>
         
         <div class="contenedor">
                <div class="campos_f">
                    <?php 
                    echo $identificador = $extraerdatos['numero_inspeccion'];
                ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_solicitud; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                <div class="campos_f">
                  <?php echo $nombreasigna; ?>
                </div>
                <div class="campos_f">
                  <?php echo $departamento_id.'-'.$ciudad; ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_decode($nombreedificacion); ?>
                </div>
                <div class="campos_f">
                  <?php echo $direccion; ?>
                </div>
                
                <div class="campos_f">
                  <?php echo $fecha_posible_inspeccion; ?>
                </div>
            </div>   
            <br>
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-user"></i> INFORMACIÓN SOLICITANTE  </center>
            </div>
            <div class="contenedor_titulos">
            <div class=" titulo">Solicitante</div>
            <div class=" titulo">Número de <br>Identificación</div>
            <div class=" titulo"><b>Tomador</b></div>
            <div class=" titulo">Encargado de atender la inspección</div>
            <div class=" titulo"><b>Contacto del encargado</b></div>
            <div class=" titulo">Asegurado</div>
          </div>
            <div class="contenedor">
                <div class="campos_f">
                <?php echo utf8_decode($nombresolicita); ?>
                </div>
                <div class="campos_f">
                  <?php echo $tipodocumentosolicitante.' '.$numeroidentificacio; ?>
                </div>
                 <div class="campos_f">
                 <?php echo $tomador ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_decode($npersonaatiende); ?>
                </div>
                <div class="campos_f">
                  <?php echo $cpersonaatiende; ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_decode($asegurado); ?>
                </div>
            </div>   
            </div>

            
            <br>
             <div class="titulo_p">
                <center><i class="fa-solid fa-search"></i> INFORMACIÓN INSPECTOR - FIRMA INSPECTORA  </center>
            </div>
            <div class="contenedor_titulos">
            <div class=" titulo">Firma Inspectora</div>
            <div class=" titulo"><b>Contacto Firma</b></div>
            <div class=" titulo">Compañía de <br> Seguros</div>
             <div class=" titulo">Oficina</div>
          </div>
          <div class="contenedor">
                <div class="campos_f">
                <?php 
                    echo $firmainspectora;
                ?>
                </div>
                <div class="campos_f">
                  <?php echo $contactofirma; ?>
                </div>
                <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                <div class="campos_f">
                  <?php echo $oficinaB; ?>
                </div>
            </div> 
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-check"></i> UBICACIÓN GEOESTACIONARIA</center>
                <?php
                $bloques    = new bloques;
                    $consulta = $bloques->iniciarVariables();
                    $filtro = $id_inspeccion;
                    $consultainmuebles = $bloques->consultainmuebles($filtro);
                ?>
            </div> 
            <div class="contenedor_titulos">
                <div class=" titulo">Longitud</div>
                <div class=" titulo"><b>Latitud</b></div>
                <div class=" titulo"><b>Estrato</b></div>
                <div class=" titulo"><b>Espacio Sociogeografico</b></div>
            </div>
            <div class="contenedor">
                <div class="campos_f">
                  <?php echo $longitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $latitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $estrato; ?>
                </div>
                <div class="campos_f">
                  <?php echo $espaciogeografico; ?>
                </div>
            </div>
            <div class="contenedor">
               <iframe width="1770" height="500" src="https://maps.google.com/maps?q=<?php echo $latitud; ?>,<?php echo $longitud; ?>&output=embed"></iframe>
            </div>
            <br>
            <div class="titulo_p">
                <center><i class="fa-solid fa-check"></i> INFORMACIÓN DE BIENES A INSPECCIONAR</center>
            </div>    
                <div class="contenedor_titulos">
                    <div class=" titulo">Identificador</div>
                    <div class=" titulo">Bien Principal</div>
                    <div class=" titulo">Inmueble</div>
                    <div class=" titulo">Tipo de Inmueble</div>
                    <div class=" titulo">Dirección</div>
                    <div class=" titulo">Acciones</div>
                </div>
                <?php
                    
                    while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
                    ?>
                    <div class="contenedor">
                        <form action="verinmuebles.php" id="form" method="POST">
                            <input type="hidden" value="<?php echo $id=$extraerDatos['identificador'] ?>" name="identificador">
                            <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                        </form>
                        <div class="campos_f">
                          <?php echo $identificadorI=$extraerDatos['identificador']; ?>
                        </div>
                        <div class="campos_f">
                          <?php echo $extraerDatos['bien_contenedor']; ?>
                        </div>
                        <div class="campos_f">
                          <?php echo $extraerDatos['descripcion']; ?>
                        </div>
                        <div class="campos_f">
                          <?php echo $extraerDatos['tipo_de_bien']; ?>
                        </div>
                          <div class="campos_f">
                          <?php echo $extraerDatos['observaciones']; ?>
                        </div>
                        <div class="campos_f">
                          <form action="detalleinspeccion.php" method="POST" target="_blank">
                            <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                            <input type="hidden" value="<?php echo $id= $extraerDatos['identificador'] ?>" name="identificador">
                            <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                            <button class="btn_azul" name="inspeccionar">Consultar</button>
                          </form>
                          <form action="riesgosinmueble.php" method="GET" target="_blank" >
                            <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                            <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                            <?php /*<input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                            <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">*/?>
                             <button class="btn_verde">Calificación<br>Riesgos</button>
                          </form>

                          <?php
                          /*
                          openWindow()
                           <form action="asignarinspectores.php" method="POST">
                              <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                              <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                              <button class="btn_verde" type="submit">Asignar Inspectores</button>
                          </form>
                          */
                          ?>
                        </div>
                    </div>
         <?php
          }
          }
                ?>
            </div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>