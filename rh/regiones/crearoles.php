<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<?php

include "clases/Json.class.php";

if (isset($_POST["nombre_corto"]))
    $nombre_corto = $_POST["nombre_corto"];
else
    $nombre_corto = "";
if (isset($_POST["descripcion"]))
    $descripcion = $_POST["descripcion"];
else
    $descripcion = "";
if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    include_once  "clases/Json.class.php";
    $nombre_corto = $_POST['nombre_corto'];
    $descripcion = $_POST['descripcion'];

    echo '<script language="javascript">alert("';
    echo $disp;
    echo '");</script>';
    echo '
                         <div class="contenedor">';
      echo   $disp;
      echo '<a href= "" > Regresar </a>
        </div>     '; 

}
?>
<body>  
    <header>
        <div class="logo">
            <a href=""><i class="fa-solid fa-globe"></i> logo</a>
        </div>
        <div class="usuario">
            <a href=""><i class="fa-solid fa-user"></i></a>
        </div>
    </header>
                <?php
                 echo '   
                         <div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Registro único de Roles</div></div>
                        <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Nuevo Rol</a></div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevo Rol</div>
                        </div>';
    echo '
                         <div class="contenedor">
        <form class="registro" action="crearoles.php" method="post">    
        <div>     '; 
                echo 'Nombre : <input name="nombre_corto" type="text" value="'.$nombre_corto.'"  required>';
                echo ' Descripcion: <input name="descripcion" type="text" value="'.$descripcion.'"  required>'                        
                /* Llamo a la clase */
                $Json     = new Json;
                $Json->iniciarVariables();
                /* Hago la busqueda de objetos para agregar permisos */
                $filtro = "so.id_clase like '%'";
                $xcompobj = $Json->buscaobjetos($filtro);
                $xrowobj = array();
                $xi=0;
                echo '<div class="inputs"><div >
               <legend>Objetos</legend>';
                while ($xrowrobj = $Json->obtener_fila($xcompobj)) {
                    $nombrer[$xi] = utf8_encode($xrowrobj['nombre']) ;
                    $identificadorr[$xi] = $xrowrobj['identificador'];
                    $clase[$xi] = $xrowrobj['clase'];
                
                    echo  '<input type="checkbox" name="objeto[]" value="'.$identificadorr[$xi].'"><label>'.$nombrer[$xi].'</label><br/>';
                    $xi++;
                }
                echo '</select>';
                echo "</div>";
                echo '
                <div><input class="btn_gris campos" type="reset" name="limpiar" value="limpiar">   ';
               ?>
            <input class="btn_verde campos" type="submit" name="enviar" value="Enviar" ></div>
            <br><!-- Rol -->
        </form>
    </div>
<div class="cont_fin">
</div>




     



    

</body>

</html>