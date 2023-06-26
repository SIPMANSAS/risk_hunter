<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Actualiza password</title>
<link rel="stylesheet" href="css/regiones.css">
<script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script>
$.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
     success: function(data) {
        $('#result').text(data.disp);
      }
});
</script>

</head>
<?php
session_start();
$usuario="";
if (isset($_SESSION["usuario"])) 
    $usuario = $_SESSION["usuario"];
    $ahora = date("Y-n-j H:i:s");
    $fechaGuardada = $ahora;

if (isset($_SESSION["ultimoAcceso"]))
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

if($tiempo_transcurrido >= 60000) {
    header("Location: logout.php");
}else {
    $_SESSION["ultimoAcceso"] = $ahora;
}
include "clases/Json.class.php";
    $disp="";
    $correcto="";

    function enviaremail($email,$asunto,$texto,$textof,$usuario,$remite,$cc,$link)
    {
        $destinatario = $email;
        $asunto = $asunto;
        $datossaludo = "<html>
        <head>
        <title>Activacion de Cuenta de Usuario en RH+</title>
    </head>
    <body>
    <div>Estimado Usuario, </div><br>";
    $datosusuario = "<br><h2>Usuario Asignado: ". $usuario."</h2><br>";
    $linkactivacion = "<br>El link de Activaciones de su cuenta es: ".$link."</br>";
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

if ((isset($_POST['guardar'])) && ($_POST['guardar'] == "Guardar"))
{
    include_once  "clases/Json.class.php";
    $Json     = new Json;
    $Json->iniciarVariables();
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $email = $_POST["email"];
    $user = $_POST["usuario"];
    if (isset($_POST["olvidouser"]))
        $olvidouser = $_POST["olvidouser"];
  
    if(isset($olvidouser) && ($olvidouser == "SI"))
    {
        $filtro = "email = '$email'";
        $xolvuser = $Json->buscauser($filtro);
        $arruser = $Json->obtener_fila($xolvuser);
        $user = $arruser["usuario"];
    }

    if ($password1 == $password2)

    {
     if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/',$password1))
            {
                
        $filtro = "email = '$email'";
        $setval = "password='$password1', flag_primera_vez='1', estado='0'  ";    
        $passupdate = $Json->cambiapassword($filtro,$setval);
        if((!isset($passupdate)) or ($passupdate == FALSE)) {

            $correcto = "false";
            $disp .= "Se presento un error actualizando contrase�a";

        }
        else {
            
            $disp .= " Se actualizo correctamente el Password. <br>  Por favor verifique el email para activar su cuenta.";
            $idcomunicaciones = "2";
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
            
            $link = $lnk."activacuenta.php?frase=".$hash; 
            $envioemail = enviaremail($email,$asunto,$texto,$textof,$user,$remite,$cc,$link);
            
            $correcto = "true";
        }
            }
            else {
                $correcto = "false";
                $disp .= "El password debe contener minimo 8 caracteres, minimo una mayuscula, una minuscula, un digitos y un caracter especial";
            }
          
    }else {
        $disp .= "Los password no coinciden vuelva a intentarlo";
        $correcto = "false";
    }  
}
?>
<body>  
<header>
       
       <div class="logo">
       <a href="menu.php"><img src="img/logo_ies.fw.png" alt=""></a>
       </div>
   <div></div><div></div>
      
   </header>
    <?php
     
    
                 echo ' 
                        <div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Cambiar Password</div></div>
                        <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Actualizar Password</a></div>
                        <div class="contenedor_titulos "><div class="campos titulo">Actualiza Password</div></div>';
                echo '
                    <div class="contenedor">
                        <form class="actualiza_pass" action="primeravez.php" method="post" >'; 
               
                
                echo '          <div><label for="">usuario:</label> <input name="usuario"  type="texto" value="'.$usuario.'"></div>
                                <div><label> Olvide mi Usuario</label><input type="checkbox" id="olvidouser" name="olvidouser" value="SI"></div> ';
                    
                echo '          <div><label for="">Email: </label><input name="email" id="useremail" type="email" placeholder="Correo"  required></div> ';

                echo '          <div><label for="">Pasword:</label> <input name="password1" id="passw1" type="password" placeholder="password"  required></div> ';

                echo '          <div><label for="">Repetir Password:</label> <input name="password2" id="passw2" type="password" placeholder="Repetir password" required></div> ';

                echo '          <div>
                                    <input class="btn_gris" type="reset" name="limpiar" value="limpiar">  
                                    <input class="btn_azul" type="submit" name="guardar" value="Guardar" onclick="return validateEmail()" />
                                </div>
                                <br>';
                             
                echo '  </form>
                            
                </div>';

echo '
<div class="cont_fin" >
<div class="inputs_r"> ';   
                  if ($correcto == "true")
                      echo '<div class="msj_verde"> '. $disp . '</div>'; 
                  elseif($correcto == "false") 
                       echo '<div class="msj_rojo"> '. $disp . '</div>';    
                  echo '</div></div>';
include "footer.php";

?>
<script type="text/javascript">
            function validateEmail(){
                // Define our regular expression.
                var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
                 // Using test we can check if the text match the pattern
                if( validEmail.test( jQuery('#useremail').val() ) ){
                    return true;
                }else{
                    alert('Email no valido, no se puede continuar con la actualizacion de password');
                    return false;
                }
            }
        </script>
</body>
</html>