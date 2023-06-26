<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Regiones</title>

    <link rel="stylesheet" href="css/regiones.css">

    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



</head>

<body>  

    <header>

        <div class="logo">

            <a href=""><i class="fa-solid fa-globe"></i> logo</a>

        </div>

        <div class="usuario">

            <a href=""><i class="fa-solid fa-user"></i></a>

        </div>

    </header>

    

    <div class="titulo_p"><div><i class="fa-solid fa-globe"></i> regiones </div></div>

    <div class="titulo2"><i class="fa-solid fa-flag"></i><a href=""> paises </a></div>

    <div class="contenedor_titulos ">

        <div class="campos titulo">cod</div>

        <div class="campos titulo">nombre</div>

        <div class="campos titulo">tipo Est</div>

        <div class="campos titulo">estado</div>      

    </div>

<?php 

    require('conexion.php');

    while($mostrar_p=pg_fetch_array($resul_pais)){?>

        <div class="contenedor">

            <div id="ID" class="campos"><?php echo $mostrar_p['codigo'];?></div>

            <div class="campos"><input type="button" class="btn_sel" value="<?php echo $mostrar_p['nombre'] ;?>" onclick="departamentos(<?php echo $mostrar_p['codigo'];?>)"></div>

            <div class="campos"><?php echo $mostrar_p['tipo_estado'];?></div>

            <div class="campos"><?php echo $mostrar_p['estado'] ;?></div>        

        </div>    

    <?php };?>

    <div class="cont_fin"></div>



        <div id="mostrar_dep" ></div>

        <div id="mostrar_ciudad"></div>

        <script>

            function departamentos(boton)

            {

            accion = boton;

            var parametros = {

             "id_pais" : accion

            };

            $.ajax({

                data: parametros,

                url:'mos_dep.php',

                type: 'POST',

                

                beforesend: function()

                {

                    $('#mostrar_dep').html("mensaje antes de enviar");

                },

                success: function(mensaje)

                {

                    $('#mostrar_dep').html(mensaje);

                }

            });

            } 

            function ciudades(boton)

            {

            accion = boton;

            var parametros = {

             "id_departamento" : accion

            };

            $.ajax({

                data: parametros,

                url:'mos_ciu.php',

                type: 'POST',

                

                beforesend: function()

                {

                    $('#mostrar_ciudad').html("mensaje antes de enviar");

                },

                success: function(mensajeb)

                {

                    $('#mostrar_ciudad').html(mensajeb);

                }

            });

            }   

         

        </script>

</body>



</html>

