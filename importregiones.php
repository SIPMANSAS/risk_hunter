<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Improtar regiones</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link href="css/styledynam2.css" rel="stylesheet">
      <link rel="shortcut icon" href="favicon.ico">
</head>
<body>  
    <?php /*agreho el header*/ include 'header-rh.php'; ?>
    <div class="titulo_p">
        <i class="fa-solid fa-upload"></i>
        &nbsp;importar archivo
    </div>
    <div class="contenedor_titulos ">
        <div class="campos titulo">importar datos a regiones</div>
    </div>
    <div class="contenedor">
        <div class="campos">A continuación seleccione el archivo de CS para ser importado a la base de datos <br>porfavor seleccione el archivo</div>
    </div> 
    <div class="contenedor">
        <form class="import" action="import/import_reg.php" method="post" name="formexelimport" id="formexelimport" enctype="multipart/form-data">
            <div class="f_import">
                <div>
                    <label for="">ciudades</label>
                </div>
                <div>
                    <input class="btn_verde" name="sel_file" type="file" accept=".csv">
                    <input type="hidden" name="envio" id="envio" value="1">
                </div>
                <button type="submit" class="btn_azul" name="grabar" id="enviar" value="ciudad">
                    <i class="fa-solid fa-upload"></i>
                    &nbsp;Importar
                </button>
            </div>           
        </form>   
    </div>
    
    <div class="contenedor">
        <div class="campos">
            div para mensajes de exito o error
        </div>
    </div>
    <div class="cont_fin"></div>
    <?php include /*agreho el footer*/   'footer.php';?>
</body>
</html>