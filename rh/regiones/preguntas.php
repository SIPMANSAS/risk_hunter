
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<body>
<?php include 'header.php';?>
<div class="titulo_p">Preguntas</div>
<div class="titulo2">Información sobre la inspección</div>
<!---titulos ---> 
<div class="contenedor_titulos">
<div class="titulo">pregunta</div><div class="titulo">Respuesta</div></div>
<!---titulos contenido ---> 
<div class="contenedor">
    <div class="campos-p pregunta">fecha de solicitud</div>
    <div class="campos-p"><input type="date"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">numero de inspeccion</div>
    <div class="campos-p ">ejemplo</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Compañia de seguros</div>
    <div class="campos-p">ejemplo</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">oficina</div>
    <div class="campos-p">ejemplo</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Nombre de quien asigna la inspección</div>
    <div class="campos-p">ejemplo</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Número de contacto de quien asigna la
inspección</div>
    <div class="campos-p">2342341234</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Solicita la inspección</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Tipo de identificación de quién solicita la
inspección</div>
    <div class="campos-p">
        <select name="" id="">
            <option value="">Carné diplomatico</option>
            <option value="">Cedula de ciudadania</option>
            <option value="">Cedula de extrangeria</option>
            <option value="">Documento extranjero</option>
            <option value="">Pasaporte</option>
        </select>
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Número de identificación de quién
solicitó la inspección</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Tomador</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Asegurado</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">País donde se realizará la inspección</div>
    <div class="campos-p">
        <select name="" id="">
            <option value="">1</option>
        </select>
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Departamento donde se realizará la inspección</div>
    <div class="campos-p"> 
        <select name="" id="">
            <option value="">1</option>
        </select>
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">ciudad donde se realizará la inspección</div>
    <div class="campos-p">
    <select name="" id="">
            <option value="">1</option>
        </select>
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Dirección del bien a inspeccionar</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Nombre de la Edificación (Propiedad horizontal)</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Número de contacto de quien atenderá la inspección</div>
    <div class="campos-p"><input type="text"></div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Firma inspectora asignada</div>
    <div class="campos-p">
    <select name="" id="">
            <option value="">1</option>
        </select>
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Número de contacto de la Firma Inspectora</div>
    <div class="campos-p">ejemplo</div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Lista de bienes a inspeccionar</div>
    <div class="campos-p">
    <select name="" id="">
            <option value="">1</option>
        </select>
        <input type="file">
    </div>
</div>
<div class="contenedor">
    <div class="campos-p pregunta">Posible fecha de Inspección</div>
    <div class="campos-p"><input type="date"></div>
</div>
<div class="contenedor">
    <div class="campos"><input class=btn_verde" type="submit"></div>
</div>
<div class="cont_fin"></div>







<?php include 'footer.php';?>    
</body>
</html>
