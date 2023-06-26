    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        ////include  "clases/otrobloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle Bienes</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <link rel="shortcut icon" href="favicon.ico">
      
    

    </head>
    <body>
        
        <?php //include 'header-rh.php'; ?>
        
         <div class="titulo_p">
            <center><i class="fa-solid fa-check"></i> BIENES ASIGNADOS</center>
        </div>
        <div class="contenedor_titulos">
            <?php
            include 'conexion/conexion.php';
            $j == 0;
            'PREGUNTA'.$id_preg = $_GET['id_pregunta']; // Id pregunta
            'INSPECCION'.$id_inspeccion = $_GET['id_inspecion']; ///// Id Inspeccion
            '<br>';
            'BLOQUE'.$id_bloque = $_GET['bloque_inspeccion']; ////// Id bloque Inspeccion
            '<br>';
            'RESPUESTA'.$id_respuesta = $_GET['idres']; ///////////// Id respuesta
            '<br>';
            'DETALLE'.$id_detalle_inspeccion  = $_GET['consecutivo']; //// Id detalle inspeccion
            '<br>';
            
            /**************************** IMPRIMO LOS ENCABEZADOS DEL FORMULARIO DINAMICO ****************************************************/
            $cantidadDatos= $mysqli->query("SELECT COUNT(*) AS Canti FROM enc_columnas_bienes WHERE id_pregunta='$id_preg'");
            $extraerDatos = $cantidadDatos->fetch_array(MYSQLI_ASSOC);
            $cantidadDatosExtraidos = $extraerDatos['Canti'];
          
            $consultencabezadostabla = $mysqli->query("SELECT * FROM enc_columnas_bienes WHERE id_pregunta='$id_preg'");
            while($extraeDatos = $consultencabezadostabla->fetch_array()){
            ?>
            <div class="titulo"><?php echo $encabezados = $extraeDatos['nombre'];?></div>
            <?php
            }
            /************************** FINALIZA ENCABEZADO DEL FORM DINAMICO ******************************************************************/
            ?>
            <!--<div class="titulo">Acciones</div>-->
        </div>
        
            <?php
            include 'conexion/conexion.php';
            
            //echo "SELECT identificador,id_valor_respuesta,valor_numerico,texto1,texto2,texto3,texto4,texto5 id_inspeccion,id_bloque_inspeccion,id_detalle_inspeccion FROM enc_lista_bienes WHERE valor_numerico > 0 || texto1 <> NULL || texto2 <> NULL || texto3 <> NULL || texto4 <> NULL || texto5 <> NULL || texto6 <> NULL || texto6 = valor_numerico AND id_valor_respuesta='$id_respuesta' AND id_inspeccion='$id_inspeccion' AND id_bloque_inspeccion='$id_bloque' AND id_detalle_inspeccion='$id_detalle_inspeccion'";
            
            //echo "SELECT * FROM enc_lista_bienes WHERE id_detalle_inspeccion = '$id_detalle_inspeccion' AND id_pregunta = '$id_preg' AND id_inspeccion='$id_inspeccion' AND id_bloque_inspeccion='$id_bloque'"; 
            $consulta = $mysqli->query("SELECT * FROM enc_lista_bienes WHERE id_detalle_inspeccion = '$id_detalle_inspeccion' AND id_inspeccion='$id_inspeccion' AND id_bloque_inspeccion='$id_bloque'");
            while($extraerDatos = $consulta->fetch_array()){
                ?>

                <div class="contenedor">
                    <?php 
                        $datoA = $extraerDatos['texto1'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                   
                    <?php 
                        $datoB = $extraerDatos['valor_numerico'];
                        if($datoB != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoB ?>
                        </div>
                         <?php
                        }
                        ?>
                    <?php 
                        $datoA = $extraerDatos['texto2'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                    <?php 
                        $datoA = $extraerDatos['texto3'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                     <?php 
                        $datoA = $extraerDatos['texto4'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                     <?php 
                        $datoA = $extraerDatos['texto5'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                    <?php 
                       /* $datoA = $extraerDatos['texto6'];
                        if($datoA != NULL){
                        ?>
                        <div class="campos_f">
                            <?php echo $datoA ?>
                        </div>
                         <?php
                        }
                        ?>
                        
                    <?php
                    /*
                    <div class="campos_f">
                        <form action="" method="POST">
                             <input type="hidden" value="<?php echo $id_preg ?>" name="id_pregunta">
                             <input type="hidden" value="<?php echo $id_inspeccion ?>" name="identificador_inspeccion">
                             <input type="hidden" value="<?php echo $id_bloque ?>" name="id_bloque">
                             <input type="hidden" value="<?php echo $id_respuesta ?>" name="id_respuesta">
                             <input type="hidden" value="<?php echo $id_detalle_inspeccion ?>" name="id_det_inspeccion">
                             <input type="hidden" value="<?php echo $datoA?>" name="dataA">
                             <input type="hidden" value="<?php echo $datoB?>" name="dataB">
                             <input type="hidden" value="<?php echo $datoC?>" name="dataC">
                             
                             <button id="btn_azul" type="submit" class="btn_azul" name="editar">Editar</button>
                        </form>
                    </div>
                    */
                    ?>
                </div>    
            <?php  
                
            }
            if(isset($_POST['editar'])){
                echo 'EDITAR';
                $dataA = $_POST['dataA'];
            ?>
            <div class="titulo_p">
            <center><i class="fa-solid fa-check"></i> EDITAR DETALLE BIENES</center>
            <?php
             $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultacantidadB = $bloques->consultacantidadB($id_inspeccion,$id_bloque,$id_detalle_inspeccion);
            $extraerCantidad = $bloques->obtener_fila($consultacantidadB);
            $cantidad = $extraerCantidad['Cantidad'];
            
            while ($extraerDatos =  $bloques->obtener_fila($consultacantidadB)){
                $j = $j+1;
                
                if($j <> $cantidad){
                ?>
                    <div class=" titulo"><?php echo utf8_encode($extraerDatos['nombre'])?></div> 
                    
                <?php
                }else{
                    $valornumerico = $extraerDatos['nombre'];
                }
            }
            ?>
        </div>
        </div>
        <div class="contenedor">
            <form class="registro" action="controller/controlleBienes.php" method="POST">
                
                 <input type="hidden" value="<?php echo $id_preg ?>" name="id_pregunta">
                 <input type="hidden" value="<?php echo $id_inspeccion ?>" name="identificador_inspeccion">
                 <input type="hidden" value="<?php echo $id_bloque ?>" name="id_bloque">
                 <input type="hidden" value="<?php echo $id_respuesta ?>" name="id_respuesta">
                 <input type="hidden" value="<?php echo $id_detalle_inspeccion ?>" name="id_det_inspeccion">
                    <?php
                         
                        $consultvalorrespuesta = $mysqli->query("SELECT * FROM enc_columnas_bienes WHERE id_pregunta='$id_preg'");//WHERE id_pregunta='$id'
                        
                        $contador = 1;
                        while($extraerDatos = $consultvalorrespuesta->fetch_array()){
                            $nombre = $extraerDatos['nombre'];
                    ?>
                        <div class="inputs_r">
                        <label><?php echo ($nombre) ?></label>
                        <input class="inp_med" type='text' name='dato<?php echo $contador++;?>' placeholder="Ingrese <?php echo $nombre ?>"  value="<?php echo $dataA?>"required>
                    </div>
                    <?php
                        }
                    ?>
                <button id="btn_azul" type="submit" class="btn_azul" name="registradetallesbienes">Actualizar</button>
            </form>
        </div>
        <?php
        
        }else{
        ?>
        <div class="titulo_p">
            <center><i class="fa-solid fa-check"></i> AGREGAR DETALLE BIENES</center>
        </div>
        <?php
   

        $bloques    = new bloques;
        $consulta = $bloques->iniciarVariables();
        $consultacantidadB = $bloques->consultacantidadB($id_inspeccion,$id_bloque,$id_detalle_inspeccion);
        $extraerCantidad = $bloques->obtener_fila($consultacantidadB);
        $cantidad = $extraerCantidad['Cantidad'];
        
        while ($extraerDatos =  $bloques->obtener_fila($consultacantidadB)){
            $j = $j+1;
            
            if($j <> $cantidad){
            ?>
                <div class=" titulo"><?php echo utf8_encode($extraerDatos['nombre'])?></div> 
                
            <?php
            }else{
                $valornumerico = $extraerDatos['nombre'];
            }
        }
        
        ?>
        
         
        <div class="contenedor_titulos">
            <div class=" titulo"><b>Registro Información</b></div>
        </div>
        
        <div class="contenedor">
             <form class="registro" action="controller/controlleBienes.php" method="POST">
                 <input type="hidden" value="<?php echo $id_preg ?>" name="id_pregunta">
                 <input type="hidden" value="<?php echo $id_inspeccion ?>" name="identificador_inspeccion">
                 <input type="hidden" value="<?php echo $id_bloque ?>" name="id_bloque">
                 <input type="hidden" value="<?php echo $id_respuesta ?>" name="id_respuesta">
                 <input type="hidden" value="<?php echo $id_detalle_inspeccion ?>" name="id_det_inspeccion">
                    <?php
                         
                        $consultvalorrespuesta = $mysqli->query("SELECT * FROM enc_columnas_bienes WHERE id_pregunta='$id_preg'");//WHERE id_pregunta='$id'
                        
                        $contador = 1;
                        while($extraerDatos = $consultvalorrespuesta->fetch_array()){
                            $nombre = $extraerDatos['nombre'];
                    ?>
                        <div class="inputs_r">
                        <label><?php echo ($nombre) ?></label>
                        <input class="inp_med" type='text' name='dato<?php echo $contador++;?>' placeholder="Ingrese <?php echo $nombre ?>"  required>
                    </div>
                    
                    <?php
                        }
                    ?>
                    <button id="btn_azul" type="submit" class="btn_azul" name="registradetallesbienes">Agregar</button>
                    <?php
                        }
                    ?>
                
            </form>
        </div>
        </div>
            
                
         
          <a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
            <?php include 'footer.php'; ?>
        <script>
            function vermenu(){
                document.getElementById('m_ad').classList.toggle('ver');
            }
        </script>
       
        <script>    
            function close_tab() {
                window.close();
            }
        </script>
        <style>
            .scroll{
                overflow-x:scroll;
                overflow-y:hidden;
            }
        </style>
    </body>
    
    </html>