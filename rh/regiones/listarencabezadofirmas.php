    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        //include  "clases/otrobloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista Encabezados</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      
        <script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var search = $(this).val();	
            var dataString = 'search='+search;
            var parametros = {
          "search": search,
         }
         //url: "funcioness/obtienesearchfirmas.php",
    	$.ajax({
                type: "POST",
                url: "funcioness/obtienesearchencabezadofirmas.php",
                data: parametros,
               success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#sugerencia').fadeIn(1000).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.sugerencia-element').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var id = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#search').val($('#'+id).attr('data'));
    			            
                            //Hacemos desaparecer el resto de sugerencias
                            $('#sugerencia').fadeOut(1000);
                            $('#identificau').val(id);
                            $('#idusuario').val(id);
                            $('#identifu').val('d');
                            $('#ident').val(id);
                            
                            
    			document.getElementById('form').submit();
    	                  return false;
                    });
                }
            });
        });
    }); 
    </script>

    </head>
    <body>
        <?php
        /*
            include "conexion/Conexion2.php";
            include_once  "clases/Json.class.php";
            $db =  connect();
            $query = $db->query("select * from rg_paises");
            $countries = array();
            while ($r = $query->fetch_object()) {
              $countries[] = $r;
            }*/
        ?>
       
        <?php include 'header-rh.php'; ?>
         <?php 
        
        if (isset($_POST["identificau"]))
            $identificador = $_POST["identificau"];
        elseif (isset($_POST["idusuario"]))
            $identificador = $_POST["idusuario"];
        else
            $identificador = "1";
        $filtro = "1";
    if(isset($_POST["identificau"]) or (isset($_POST["idusuario"])))
    {
        /* entrada al metodo post para mostrar informacion de usuario y actualizar */
        
        if (isset($_POST["identificau"]))
             $identificador = $_POST["identificau"];
        elseif (isset($_POST["idusuario"]))
            $identificador = $_POST["idusuario"];
        
    }    
        ?>
   
        <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i> INSPECCIONES FIRMAS INSPECTORAS</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class=""></i><a href=""></a></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="crearencabezadofirmainspectora.php"> Crear Encabezado</a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Encabezado..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo">Número de <br>Inspección</div>
            <div class=" titulo">Compañía de <br> Seguros</div>
             <div class=" titulo">Nombre de <br> Quien Asigna</div>
            <div class=" titulo"><b>Fecha Solicitud</b></div>
            <div class=" titulo"><b>Ciudad de <br>realización</b></div>
            <div class=" titulo"><b>Dirección del <br>bien</b></div>
            <div class=" titulo"><b>Nombre Persona <br>que atendera</b></div>
            <div class=" titulo"><b>Número <br>Contacto</b></div>
            <div class=" titulo"><b>Inspector<br> Asignado</b></div>
            <div class= "titulo"><b>Fecha<br> Inspección</b></div>
            <div class=" titulo"><b>Estado</b></div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultaencfirmas = $bloques->consultaencfirmas2();//$id_menu_p
    
            while ($extraerDatos =  $bloques->obtener_fila($consultaencfirmas)){
                $id = $extraerDatos['identificador'];
                $numero_inspeccion = $extraerDatos['numero_inspeccion'];
                $fecha_solicitud = $extraerDatos['fecha_solicitud'];
                $idcompaniaseguros = $extraerDatos['id_cia_seguros'];
                $companiaseguros = $extraerDatos['cia_seguros'];
                $ciudad = $extraerDatos['ciudad'];
                $fechainspeccion = $extraerDatos['fecha_inspeccion'];
                $direccion = $extraerDatos['direccion'];
                $tipodoc = $extraerDatos['tid_solicita'];
                $numeroidentificacio = $extraerDatos['nid_solicita'];
                $nombresolicita = $extraerDatos['nombre_solicita'];
                $tomador = $extraerDatos['tomador'];
                $asegurado = $extraerDatos['asegurado'];
                $npersonaatiende = $extraerDatos['nombre_persona_atiende'];
                $cpersonaatiende = $extraerDatos['contacto_persona_atiende'];
                $firmainspectora = $extraerDatos['firma_inspectora'];
                $idfirma = $extraerDatos['id_firma_inspectora'];
                $nombreedificacion =$extraerDatos['nombre_edificacion'];
                $facturacion = $extraerDatos['facturacion'];
                $pais_id = $extraerDatos['id_pais'];
                $departamento_id = $extraerDatos['id_departamento'];
                $ciudad_id = $extraerDatos['id_ciudad'];
                $fecha_posible_inspeccion = $extraerDatos['fecha_posible_inspeccion'];
                $nombreasigna = $extraerDatos['nombre_asigna'];
                $facturacion = $extraerDatos['estado'];
                $inspectorasignado = $extraerDatos['nombre_inspector'];
                $lista_biene = $extraerDatos['lista_bienes'];
            
            
            ?>
            <div class="contenedor">
                    <form action="verinspeccionfirmas.php" id="form"  method="POST">
                        <input  type="hidden" value="<?php echo $lista_biene;  ?>" name="bienes">
                        <input  type="hidden" value="<?php echo $id;  ?>" name="identificador">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tipodoc;  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $idfirma;  ?>" name="firmainspectora">                      
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $departamento_id;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad_id;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $idcompaniaseguros;  ?>" name="id_cia_seguros">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombre_persona_atiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contacto_persona_atiende">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_posible_inspeccion">
                     </form>
                      <div class="campos_f">
                    <?php 
                    echo $identificador = $extraerDatos['numero_inspeccion'];
                    ?>
                </div>
                <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $nombreasigna; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_solicitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $ciudad; ?>
                </div>
                <div class="campos_f">
                  <?php echo $direccion; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $npersonaatiende; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $cpersonaatiende; ?>
                </div>
                 <div class="campos_f">
                  <?php echo $inspectorasignado; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_posible_inspeccion; ?>
                </div>
                <div class="campos_f">
                  <?php echo $facturacion; ?>
                </div>
                <div class="campos_f">
                     <form action="editarencabezado.php" method="POST">
                         <input  type="hidden" value="<?php echo $lista_biene;  ?>" name="bienes">
                        <input  type="hidden" value="<?php echo $id;  ?>" name="identificador">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tipodoc;  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $idfirma;  ?>" name="firmainspectora">                      
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $departamento_id;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad_id;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $idcompaniaseguros;  ?>" name="id_cia_seguros">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombre_persona_atiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contacto_persona_atiende">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_posible_inspeccion">
                        <button class="btn_azul" type="submit" name="editarEncabezado">Asignar Inspector</button>
                     </form>
                     <form action="verinspeccionfirmas.php" method="POST">
                          <input  type="hidden" value="<?php echo $lista_biene;  ?>" name="bienes">
                        <input  type="hidden" value="<?php echo $id;  ?>" name="identificador">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tipodoc;  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $idfirma;  ?>" name="firmainspectora">                      
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $departamento_id;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad_id;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $idcompaniaseguros;  ?>" name="id_cia_seguros">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombre_persona_atiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contacto_persona_atiende">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="fecha_posible_inspeccion">
                          <button class="btn_verde" type="submit">Consultar</button>
                     </form>
                </div>
            </div>
                
            </div>
            <?php
            }
    
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>