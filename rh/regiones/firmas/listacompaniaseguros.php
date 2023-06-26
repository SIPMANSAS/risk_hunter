    <?php include '../sec_login.php'; ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Compañias de Seguros</title>
        <link rel="stylesheet" href="../css/regiones.css">
        <link rel="stylesheet" href="../css/totproyectos.css">
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
    	$.ajax({
                type: "POST",
                url: "funcionessebastian/obtienesearchfirmas2.php",
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
        <?php
    
            include "conexion/Conexion2.php";
            include_once  "clases/Json.class.php";
            $db =  connect();
            $query = $db->query("select * from rg_paises");
            $countries = array();
            while ($r = $query->fetch_object()) {
              $countries[] = $r;
            }
        ?>
        <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i>COMPAÑIAs DE SEGUROS ACTIVAS</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listacompaniasegurosdesactivadas.php"> Listar Compañia de Seguros Desactivadas</a></div>
    <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="crearcompaniaseguros.php"> Crear Compañia de Seguros</a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Compañia de Seguros..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
    
          <div class="contenedor_titulos">
        <div class=" titulo">ID</div>
        <div class=" titulo"><b>Nombre Compañia de Seguros</b></div>
        <div class= "titulo"><b>NIT / CC</b></div>
        <div class=" titulo"><b>Numero de Contacto</b></div>
        <div class=" titulo"><b>E-mail</b></div>
        <div class=" titulo"><b>Ubicación Principal</b></div>
        <div class=" titulo"><b>Acciones</b></div>
      </div>
    
          <?php
    
          $mysqli = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');
    
          $ConsultaDatos = $mysqli->query("SELECT * FROM ter_terceros F LEFT JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo WHERE F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='772' GROUP BY identificacion ASC");
    
          while ($extraerDatosFirmas = $ConsultaDatos->fetch_array()) {
    
          ?>
            <div class="contenedor">
              <div class="campos_f">
                  <form action="vercompaniaseguros.php" id="form" method="POST">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatosFirmas['identificacion'] ?>" ></div>
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatosFirmas['identificacion'] ?>">
                  </form>
              </div>
              <div class="campos_f"><?php echo $extraerDatosFirmas['nombres']; ?></div>
              <div class="campos_f"><?php echo $extraerDatosFirmas['numero_identificacion']; ?></div>
              <div class="campos_f"><?php echo $extraerDatosFirmas['telefono']; ?></div>
              <div class="campos_f"><?php echo $extraerDatosFirmas['correo_electronico']; ?></div>
              
              
              <?php
              $ciudad = $extraerDatosFirmas['ciudad'];
              
              $departamentoid=$extraerDatosFirmas['departamento'];
              
              $pais=$extraerDatosFirmas['pais'];
              $consultaPais = $mysqli->query("SELECT * FROM rg_paises WHERE codigo = '$pais'");
              $paisEx = $consultaPais->fetch_array(MYSQLI_ASSOC);
              $paisid = $paisEx['nombre'];
              
              
              $consultaDep = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' AND codigo_pais = '$pais'");
              $depEx = $consultaDep->fetch_array(MYSQLI_ASSOC);
              
              $consultaCiu = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo='$ciudad' AND codigo_pais='$pais'");
              $ciuEx = $consultaCiu->fetch_array(MYSQLI_ASSOC);
              
              echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
              echo '  <input type="hidden" id="idusuario" name="idusuario" >';
        
              
              
              ?>
                <div class="campos_f">
                  <?php echo utf8_encode($pais = $paisEx['nombre'].'-'.$depEx['nombre'].'-'.$ciuEx['nombre']); ?>
                </div>
                <div class="campos_f">
                  <form action="editarcompaniaseguros.php" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="idFirma">
                      <button class="btn_azul" type="submit" name="editar">Editar</button>
                  </form>
                  <form action="../firmas/controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="id">
                      <button class="btn_rojo" type="submit" name="desactivarCompaniaSeguros">Desactivar</button>
                  </form>
                   <form action="../asignarfirmainspectora.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="id">
                      <button class="btn_verde" type="submit">Asignar Firma Inspectora</button>
                  </form>
               </div>
            </div>   
          <?php
          }
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    
    </body>
    
    </html>