<?php 
    include 'sec_login.php'; 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Información Particular</title>
        <link rel='stylesheet' href='../pages/css/estilosSebastian.css'>
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/regiones.css">
    </head>

    <body>
        <?php include 'header-rh.php';?>
        <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO INFORMACIÓN PARTICULAR</div>
        <div class="link_int">
            <div class="titulo2">  
                <a href="">+Listar</a>
            </div>
        </div>
        <div class="contenedor_titulos">
            <div class="titulo">Información Particular</div>
        </div>
        <div class="contenedor">
            <form class="registro" action="" method="POST">
                 <div class="inputs_r">
                    <label>Seleccione Un bien</label>
                    <input type="checkbox">Piscina
                </div>
                <div class="inputs_r">
                    <label style="color:transparent">Seleccione Un bien</label>
                    <input type="checkbox">Habitacion
                </div>
                <div class="inputs_r">
                    <label style="color:transparent">Seleccione Un bien</label>
                    <input type="checkbox">Cocina
                </div>
                <div class="inputs_r">
                    <label style="color:transparent">Seleccione Un bien</label>
                    <input type="checkbox" style="text-align:right;">Garage
                    
                </div>
                <div class="inputs_r">
                    <label>Ubicación</label>
                    <input class="inp_med" type="text">
                </div>
                <div class="inputs_r">
                    <label>Estrato</label>
                    <select class="inp_med">
                        <option value="0">Seleccionar Estrato</option>
                        <option value="1">Estrato 1</option>
                        <option value="1">Estrato 2</option>
                        <option value="1">Estrato 3</option>
                        <option value="1">Estrato 4</option>
                        <option value="1">Estrato 5</option>
                    </select>
                </div>
                <div class="inputs_r">
                    <label>Zona</label>
                    <select class="inp_med">
                        <option value="0">Seleccionar Zona</option>
                        <option value="1">Urbana</option>
                        <option value="1">Rural</option>
                    </select>
                </div>
                <div class="inputs_r">
                    <label>Respuesta</label>
                    <textarea class="inp_med"></textarea>
                </div>
                <div class="inputs_r">
                    <input class="btn_azul" type='submit' name="" value="Avanzar">
                </div>
            </form>
        </div>
        <div class="cont_fin"></div>
        <?php include '../footer.php';?>
    </body>
</html>