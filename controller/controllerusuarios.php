<?php

include '../conexions.php';

if(isset($_POST['registarusuarios'])){
    echo '<script language="javascript">alert("Usuario Registrado Correctamente.");
    window.location.href="../listausuariosrh.php"</script>';
    
    $roles = $_POST['roles'];
    $cliente = $_POST['cliente'];
    $nombreusuario = $_POST['nombreusuario'];
    $apellidosusuario = $_POST['apellidosusuario'];
    $identificacion   = $_POST['identificacion'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $telefono = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $oficina = $_POST['oficina'];
    
    $consultaultimoregistro = $mysqli->query("SELECT MAX(identificador) AS Ultimo FROM sg_usuarios");
    $extraermaximo = $consultaultimoregistro->fetch_array(MYSQLI_ASSOC);
    $ultimoregistro = $extraermaximo['Ultimo']+1;
    
    
    $prapellidos = explode(" ", $apellidosusuario);
    $nombreorig = explode(" ", $nombreusuario);
    $dosdigitos = substr($numeroIdentificacion, -2);
    $user = $prapellidos[0]."_".$nombreorig[0].$dosdigitos;
    $password = $user;
    
    $destinatario = $correoElectronico;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Registro Usuario"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Registro Usuario</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$nombreusuario.' '.$apellidosusuario.',</h1> 
            <p> 
            Usted ha sido registrado en el aplicativo Risk Hunter Plus (RH+), lo invitamos a conectarse a la herramienta para que asigne su contraseña y y actualice aquellos datos necesarios para el correcto uso de la herramienta de inspección.La contraseña por usted designada deberá contener entre ocho (8) y once (11) caracteres, que incluya letras en minúscula, en mayúscula, números y signos de puntuación. Por favor guarde muy bien su contraseña, IES Consultores Group no se hace responsable del uso indebido de ésta por parte propia o de terceros sin su autorización.
            <br>
            <br>
            <h2>Usuario Asignado:'.$user.'</h2>
            <h2>Password Asignado:'.$password.'</h2>
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
    
    $insertausuario = $mysqli->query("INSERT INTO sg_usuarios(identificador,email,nombre,nombre_corto,tipo_estado,estado,apellidos,vdom_tipo_identificacion,numero_telefono,id_pais,id_departamento,id_ciudad,direccion,numidentificacion,usuario,password,flag_primera_vez,usuario_session,usuario_version_sistema)VALUES('$ultimoregistro','$correoElectronico','$nombreusuario','$nombreusuario','9','1','$apellidosusuario','$identificacion','$telefono','$paises_id','$departamento_id','$ciudad_id','$direccion','$numeroIdentificacion','$user','$password','1','','1')")or die(mysqli_error());
    
    
    
    
 
    for ($i=0;$i<=count($roles)-1;$i++){     
        //echo "<br> Roles " . ": " . $roles[$i].' Para el usuario'.$ultimoregistro;
        $fecha_efectiva = date('Y-m-d');
        $insertaroles = $mysqli->query("INSERT INTO sg_roles_x_usuario(id_rol,id_usuario,fecha_efectiva,tipo_estado,estado)VALUES('$roles[$i]','$ultimoregistro','$fecha_efectiva','12','2')");
        
    }
    
    for($j=0;$j<=count($cliente)-1;$j++){
        $fecha_efectiva = date('Y-m-d');
        echo $ultimoregistro;
        $insertaroles = $mysqli->query("INSERT INTO sg_usuarios_x_cliente(id_cliente,id_usuario,fecha_efectiva,tipo_estado,estado)VALUES('$cliente[$j]','$ultimoregistro','$fecha_efectiva','13','1')")or die(mysqli_error($mysqli));

    }
    
    

}

if(isset($_POST['guardar_pass'])){
   'US '. $usuario = $_POST['usuario'];
   '<br>';
   'Mail '. $email = $_POST['email'];
   '<br>';
   'Pass '. $password1 = $_POST['password1'];
   '<br>';
   'PAas Nuevo '.$password2 = $_POST['password2'];
   '<br>';
   'Id Usuario '. $id_usuario = $_POST['id_usuario'];
   
   $consultadatosusuario = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador ='$id_usuario'");
   $extraerinformacionusuario = $consultadatosusuario->fetch_array(MYSQLI_ASSOC);
   $nombreusuario = $extraerinformacionusuario['nombre'];
   $apellidosusuario = $extraerinformacionusuario['apellidos'];
   
   
   
   $destinatario = $email;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Actualizacion Password"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Actualizacion Password</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$nombreusuario.' '.$apellidosusuario.',</h1> <br><br>
            <p> 
            Estimado Usuario '.$nombreusuario.', 
            <br><br>
            Su password se ha actualizado correctamente; para hacer inspecciones puede ingresar al siguiente link, https://desarrollosysolucionesingenieriles.com.co/risk_hunter/log.php <br><br> <h3>Con su usuario Asignado: '.$usuario.'</h3> <br> <h3>Nuevo Password: '.$password2.'</h3>
            <br>
            <br> Muchas gracias por comunicarse con nosotros y recuerde mantener su password seguro
            <br>
            <br>
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
   
   
   $actualizapassword = $mysqli->query("UPDATE sg_usuarios SET password = '$password2' WHERE identificador ='$id_usuario'");
   "UPDATE sg_usuarios SET password = '$password2' WHERE identificador ='$id_usuario'";
   
   echo '<script language="javascript">alert("Se ha actualizado su password con éxito.");
    window.location.href="../menu"</script>';
   
}
?>