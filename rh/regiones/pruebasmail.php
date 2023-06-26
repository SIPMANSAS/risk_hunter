<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
   
</head>
<?php

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
    $headers .= "From:Risk Hunter prueba gabriel Gabriel <". $remite.">\r\n";
    
    //direcci�n de respuesta, si queremos que sea distinta que la del remitente
    $headers .= "Reply-To: ".$remite."\r\n";
    
    //direcciones que recibi�n copia
    $headers .= "Cc: ".$cc."\r\n";
    
    mail($destinatario,$asunto,$cuerpo,$headers) ;
}
?>
<body>
    <?php
	$email="tatocalifa@gmail.com";
    $asunto= "prueba de email";
    $texto="este es el cuerpo del envio del email";
    $textof="muchas gracias por contactarnos atentamente administracion deshida";
    $usuario="gabriel_califa";
    $remite="admin@rh.deshida.com.co";
    $cc="admin@rh.deshida.com.co";
    $link="rh.deshida.co/rh/regiones/log.php";

    echo "voy a llamar la funcion de envio <br>";

    enviaremail($email,$asunto,$texto,$textof,$usuario,$remite,$cc,$link);

    echo "finalizo el envio <br>";
    ?>
</body>
</html>