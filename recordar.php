<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordar</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
      <link rel="shortcut icon" href="favicon.ico">


</head>
<?php
include "clases/Json.class.php";
    $disp="";
    $correcto="";

    function enviaremail($email,$asunto,$texto,$textof,$usuario,$remite,$cc,$link)
    {
        $destinatario = $email;
        $asunto = $asunto;
        $datossaludo = "<html>
        <head>
        <title>Recuperacion de contraseña RH+</title>
    </head>
    <body>
    <div>Estimado Usuario, </div><br>";
    $datosusuario = "<br><h2>Usuario Asignado: ". $usuario."</h2><br>";
    $linkactivacion = "<br>El link para cambiar la contraseña de su cuenta es: ".$link."</br>";
    $cuerpo = $datossaludo.$texto.$datosusuario.$linkactivacion."<br>".$textof."</body></html>";
    
    //para el env�o en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    //direcci�n del remitente
    $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <". $remite.">\r\n";
    
    //direcci�n de respuesta, si queremos que sea distinta que la del remitente
    $headers .= "Reply-To: ".$remite."\r\n";
    
    //direcciones que recibi�n copia
    $headers .= "Cc: ".$cc."\r\n";
    
    mail($destinatario,$asunto,$cuerpo,$headers) ;
}

if ((isset($_POST['guardar'])) && ($_POST['guardar'] == "enviar"))
{
    include_once  "clases/Json.class.php";
    $Json     = new Json;
    $Json->iniciarVariables();
    $email = $_POST["email"];
    $filtro = "email = '$email'";
    $xolvuser = $Json->buscauser($filtro);
    $arruser = $Json->obtener_fila($xolvuser);
    $user = $arruser["usuario"];
    $disp .= " Por favor verifique el email para cambiar su contraseñaa.";
    $idcomunicaciones = "3";
    $xinfoemail = $Json->infoemail($idcomunicaciones);
    $inforcomunicaciones = $Json->obtener_fila($xinfoemail);
    $asunto = $inforcomunicaciones["asunto"];
    $texto = $inforcomunicaciones["texto"];
    $textof = $inforcomunicaciones["textof"];
    $remite = $inforcomunicaciones["remitente"];
    $cc = $inforcomunicaciones["cc"];
    $hash = md5($email);
    $lnk = "http://rh.deshida.com.co/rh/regiones/";
            //el link se traera del archivo config cuando funcione 
    $filtro = "email = '$email'";
    $setval = "fsec='$hash'  ";
    $passupdate = $Json->cambiapassword($filtro,$setval);
    if((!isset($passupdate)) or ($passupdate == FALSE)) {              
         $correcto = "false";
                $disp .= "Se presento un error.";
                
    }
    else {
         $correcto = "true";
         $disp .= "Cuenta correcta.";            
    }
            
    $link = $lnk."primeravez.php?frase=".$hash; 
    $envioemail = enviaremail($email,$asunto,$texto,$textof,$user,$remite,$cc,$link);        
    $correcto = "true";
 
}
?>
<body>
	<?php include 'header-b.php' ?>
	<div class="titulo_p">Recordar Contraseña</div>
    <div class="link_int">
        <div class="titulo2">
            <a href="log.php">volver a inicio</a>
        </div>
    </div>
    <div class="contenedor_titulos "><div class="campos titulo">recordar contraseña</div></div>
	<div class="contenedor">
        <form class="log" action="recordar.php" method="post">
            <div class="campos"></div>
            <div class="campos">
                <label for="">E-mail</label><input id="useremail" name="email" type="text"><br>
                Digite su email y le enviaremos las instrucciones para cambiar su contraseña
            </div>
            <div class="campos"></div>
                <input class="btn_azul" type="submit" name="guardar" value="enviar" onclick="return validateEmail()" />
            </div>
        </form>        
    </div>
   <?php
   echo '<div class="cont_fin" >
<div class="inputs_r"> ' ;  
                  if ($correcto == "true")
                      echo '<div class="msj_verde"> '. $disp . '</div>'; 
                  elseif($correcto == "false") 
                       echo '<div class="msj_rojo"> '. $disp . '</div>';    
                  echo '</div></div>';
   ?>

	<?php include 'footer.php' ?>
<script type="text/javascript">
            function validateEmail(){
                // Define our regular expression.
                var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
                 // Using test we can check if the text match the pattern
                if( validEmail.test( jQuery('#useremail').val() ) ){
                    return true;
                }else{
                    alert('Email no es valido, no se puede enviar el password');
                    return false;
                }
            }
        </script>
</body>
</html>