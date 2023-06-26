<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Activar Cuenta</title>
<link rel="stylesheet" href="css/regiones.css">
<link rel="shortcut icon" href="favicon.ico">
</head>

<?php
include "clases/Json.class.php";
$disp="";
$correcto = "";
$frasesecreta = $_GET["frase"];

if ((isset($_POST['activar'])) && ($_POST['activar'] == "Activar"))
{
    include_once  "clases/Json.class.php";
    $Json     = new Json;
    $Json->iniciarVariables();
    $user = $_POST["usuario"];
    $frasesecreta = $_POST["fsec"];
    $filtro = "usuario='$user' and fsec='$frasesecreta'";
    $xolvuser = $Json->buscauser($filtro);
    $arruser = $Json->obtener_fila($xolvuser);
        if(isset($arruser["usuario"]))   
        {   
            $xupdateuser = $Json->activausuario($filtro);
            if((!isset($xupdateuser)) or ($xupdateuser == FALSE)) {
                $correcto = "false";
                $disp .= "Se presento un error activando el usuario";
            }
            else {
            $disp .= " <div>Se Activo el usuario correctamente, puede ingresar a la plataforma con usuario y Password.</div>";
            $correcto = "true";
            }
        }
        else{
            $disp .= "<div> Se presento un error activando el usuario, verifique o pongase en contacto con servicio al cliente. </div>" ;      
            $correcto = "false";
        }
}
?>
<body>
<?php
    include 'header-rh.php';         
    echo '   
        <div class="titulo_p">
            <i class="fa-solid fa-user"></i>&nbsp;<div>Activa Cuenta</div>
        </div>
        <div class="titulo2">
            <i class="fa-solid fa-user"></i><a href=""> Activa Cuenta</a>
        </div>
        <div class="contenedor_titulos ">
            <div class="campos titulo">Activa Cuenta</div>
        </div>';
    echo '
        <div class="contenedor">
        <form  action="activacuenta.php" method="post">'; 
          echo '<div class="campos"><label for="">Usuario: </label>
                <input name="usuario" type="texto" value="'.$usuario.'"  required> ';                 
          echo '<div class="campos">
                    <input class="btn_gris campos" type="reset" name="limpiar" value="limpiar">  
                    <input class="btn_oscuro" type="submit" name="activar" value="Activar" >
                </div>';
          echo '<input type="hidden" name="fsec" value="'.$frasesecreta.'" ></div><br>';
    echo '
        </form>
        <div class="inputs_r"><div id="result">';
        if ($correcto=="true"){
           echo '<div class="msj_verde"> '. $disp . '</div>'; 
        }elseif($correcto=="false") {
            echo '<div class="msj_rojo"> '. $disp . '</div>'; 
        }
            echo '</div>
        <a class="btn_oscuro" href="log.php"> Ingrese a la plataforma aquí </a> 
    </div>
        </div>';
 ?>

<div class="cont_fin"></div>
<?php include 'footer.php' ?>
</body>
</html>