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
          <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Grafica de Riesgos</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
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
       
        <?php //include 'header-rh.php'; ?>
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
            <center><i class="fa-solid fa-user"></i> GRAFICA DE RIESGOS</center>
        </div>
        <div class="contenedor_titulos">
            <div class=" titulo">Inmueble</div>
            <div class="titulo">Código</div>
            <div class=" titulo">Riesgo</div>
            <div class=" titulo"><?php echo ('Calificación')?></div>
          </div>
    
          <?php
           
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            'bien'.$identificadorB = $_GET['identificador'];
            'encuesta'.$id_encuesta = $_GET['id_encuesta'];
            $filtro = 'id_bien='.$identificadorB.' AND '.'id_inspeccion='.$id_encuesta;
            $consultainmuebles = $bloques->consultainmueblesR($filtro);

            while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
          ?>
              
            <div class="contenedor">
                    <form action="verinmuebles.php" id="form" method="POST">
                        <input type="hidden" value="<?php echo $extraerDatos['identificador'] ?>" name="identificador">
                        <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                        <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                    </form>
                <div class="campos_f">
                    <?php echo ($extraerDatos['descripcion']); ?>
                </div>
                <div class="campos_f">
                    <?php echo utf8_encode($extraerDatos['id_alfanumerico']); ?>
                </div>
                <div class="campos_f">
                    <?php echo ($riesgo=$extraerDatos['descripcion_riesgo']); ?>
                </div>
                <div class="campos_f">
                    <?php echo $calificacion=$extraerDatos['Calificacion']; ?>
                </div>
            </div>
        </div>    
        <?php
            }
        //$mysqli = new mysqli('localhost','u571892443_risk_hunter','#6mL0I[Jd7ZW','u571892443_risk_hunter');

        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';
        
        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Get data from database
        $result = $db->query("SELECT D.descripcion descripcion_riesgo,D.id_alfanumerico ,C.identificador,I.descripcion,C.calificacion FROM enc_inmuebles I,enc_calificacion_riesgos_inmueble C,cg_valores_dominio D WHERE id_bien='$identificadorB' AND id_inspeccion='$id_encuesta' AND id_riesgo=D.identificador AND I.identificador = C.id_bien ORDER BY D.id_alfanumerico ASC");
        ?>
        <div class="contenedor_titulos">
            <div class="titulo">Grafica</div>
        </div>
         
        <div class="contenedor">
            <div id="piechart"></div>
        </div>
         <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                  ['Language', 'Calificación'],
                  <?php
                  if($result->num_rows > 0){
                      while($row = $result->fetch_assoc()){
                        echo "['".utf8_encode($row['id_alfanumerico'])."', ".$row['Calificacion']."],";//$row['descripcion_riesgo']
                      }
                  }else{
                      echo 'SIN DATOS';
                  }
                  ?>
                ]);
        
                var options_val = {
                    title: 'Niveles de riesgo',
                    width: 1615,
                    height: 500,
                };
        
                 var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));
        
               chart.draw(data, options_val);
            }
        </script>        

    <?php include 'footer.php'; ?>
        <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
     <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
            <script>
                function close_tab(){
                    window.close();
                }
            </script>
        </div>
    </body>
    
    </html>