<!DOCTYPE html>
<html lang="en">
    <!--- Header --->
    <head>
        <!---- Librerias y codificacion --->
        
        <meta charset="UTF-8">
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href='https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
        <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
        <link href='https://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
        <!-----END Librerias------>
        
        <title>CRM - Leads</title>
        
    </head>
    <!----END Header ------>
    <body>
        
        <section class="home-section">
            <div class="content"></div>
            <div class="home-content"></div>
            <div class='container'>
                <div class='panel panel-primary dialog-panel'>
                    <div class='panel-body'>
                        <form class='form-horizontal' action="controlador/controllerReuniones" method="POST" role='form'>
                            <div class='form-group'>
                                <label class='control-label col-md-2 col-md-offset-2' for='id_email'>Firma Inspectora</label>
                                <div class='col-md-8'>
                                    <div class='col-md-5'>
                                        <div class='form-group internal'>
                                            <?php
                                                include 'conexion/conexion.php';
                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $query = "SELECT * FROM ter_terceros WHERE vdom_tipo_tercero='774' ORDER BY nombres";
                        						$resultado=$mysqli->query($query);
                                            ?>
                                            <select class="form-control" type="text"  id="contact" name="contacto" onkeyup="PasarValor();" required>
                                                <option value="">Seleccionar....</option>
                                                  	<?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                                        <option value="<?php echo $columna['telefono']; ?>"><?php echo $columna['numero_identificacion'].'-'.utf8_decode($columna['nombres']); ?> </option>
                                                    <?php } ?>
                                                 <!-- <option value="0">No aplica</option>-->
                                            </select>
                                            <script>
                                                document.getElementById('contact').onchange = function() {
                                                      /* Referencia al option seleccionado */
                                                      var mOption = this.options[this.selectedIndex];
                                                      /* Referencia a los atributos data de la opción seleccionada */
                                                      var mData = mOption.dataset;
                                        
                                                    /* Referencia a los input */
                                                      var elId = document.getElementById('id');
                                                      var elNombre = document.getElementById('nombre');
                                                      var eltelefono = document.getElementById('telefono');
                                            
                                            
                                                    /* Asignamos cada dato a su input*/
                                                      elId.value = this.value;
                                                      elNombre.value = mOption.text; /*Se usará el valor que se muestra*/
                                                
                                                
                                                };
                                            </script>
                                        
                                        <input id="id" name="id" type="" placeholder="telefono">
                                        <input id="telefono" name="telefono" type="" placeholder="id">
                                        <input id="nombre" type="" placeholder="nombre">
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>    
        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
        <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
        <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
        <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
    </body>
</html>
