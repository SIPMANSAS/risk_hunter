  <?php 
    include 'sec_login.php'; 
    include  "clases/bloques.class.php";
    ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Registro Compañia de Seguros</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
  <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php 
    include 'header-rh.php';
    $id_usuario_ext;
   ?>
  <div class="titulo_p"><i class="fa-solid fa-user"></i>&nbsp; CAMBIAR PASSWORD</div>
  <div class="link_int">
      <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Actualizar Password</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">actualiza password</div>
    </div>
  <div class="contenedor">
          <form class="actualiza_pass" action="controller/controllerusuarios.php" method="post" >
               <?php
               //echo $id_menu_p;
               //echo "SELECT * FROM sg_usuarios WHERE usuario LIKE '%$id_menu_p%'";
                include 'conexion/conexion.php';
                $consultapreviacorreo = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador ='$id_usuario_ext'");
                $extraerDatosPrevios = $consultapreviacorreo->fetch_array(MYSQLI_ASSOC);
                $correo_usuario = $extraerDatosPrevios['email'];
                $nombre_usuaio = $extraerDatosPrevios['nombre'].' '.$extraerDatosPrevios['apellidos'];
                $password = $extraerDatosPrevios['password'];
                $usuario = $extraerDatosPrevios['usuario'];
                
                echo '          <div><label for="">usuario:</label> <input name="usuario"  type="texto" value="'.$usuario.'"></div>
                                <div><label> Olvide mi Usuario</label><input type="checkbox" id="olvidouser" name="olvidouser" value="SI"></div> ';
                    
                //echo '          <div><label for="">Email: </label><input name="email" id="useremail" type="email" placeholder="Correo"  value="'.$correo_usuario.'" required></div> ';
                
                echo '          <input name="email" id="useremail" type="hidden" placeholder="Correo"  value="'.$correo_usuario.'" required> ';
                 echo '          <input name="id_usuario" id="useremail" type="hidden" placeholder="Correo"  value="'.$id_usuario_ext.'" required> ';
                    
                echo '          <div><label for="">Pasword:</label> <input name="password1" id="passw1" type="text" placeholder="password" value="'.$password.'" required></div> ';

                echo '          <div><label for="">Ingrese nuevo Password:</label> <input name="password2" id="passw2" type="password" placeholder="Nuevo password" required></div> ';

                echo '          <div>
                                    <input class="btn_gris" type="reset" name="limpiar" value="limpiar">  
                                    <input class="btn_azul" type="submit" name="guardar_pass" value="Guardar" onclick="return validateEmail()" />
                                </div>
                                <br>';
            ?>             
            </form>
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>