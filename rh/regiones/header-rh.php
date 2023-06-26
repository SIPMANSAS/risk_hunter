<?php
    include_once 'clases/gabriel.class.php';

    //links
    $archivo = __DIR__ . "/config/configuracion.php";
    $contenido = parse_ini_file($archivo, false);
    $LINKS = $contenido["LINK"];

    //consulta usuario
    $filtro=$usuario_login;
    $Jsonuser     = new gabriel;
    $consulta = $Jsonuser->iniciarVariables();
    $xcompproyectos = $Jsonuser->secusuario($filtro);
    $idUsuario = $Jsonuser->obtener_fila($xcompproyectos);
    $id_menu_p = $idUsuario['identificador'];
    $numerocontacto = $idUsuario['numero_telefono'];
    $companiaAsignada =$idUsuario [''];
    $idoficina =$idUsuario ['id_oficina'] ;
    $nombresolicitante = $idUsuario['nombre'].' '.$idUsuario['apellidos'];
    $email = $idUsuario['email'];
?>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">
    <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/menu_usuario.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="js/menu.js"></script>
    <script src="js/menu_usuario.js"></script>
</head>
<header>
    <div class="logo">
        <?php 
        $LINKMENU = $LINKS."menu.php";
        $LINKLOGO = $LINKS."img/logo_ies.fw.png";
        echo "<a href =" . $LINKMENU . "><img src=" . $LINKLOGO ." alt=\" \"></a>";
        ?>
    </div>
    <div class="div_m_admin">
        <div id="btnMenu"  onclick="mostrarmenu()" class="nav-bar"><i class="fa-solid fa-bars"></i>&nbsp;<span class="n_menu">Administrador</span></div>
        <nav class="main-nav">
            <ul class="menu" id="menu">
            <?php
                $filtro = $id_menu_p;
                $Jsonmenu     = new gabriel;
                $consulta = $Jsonmenu->iniciarVariables();
                $xcompproyectos = $Jsonmenu->menudinamico($filtro);                                    
                while($mostrar=$Jsonmenu->obtener_fila($xcompproyectos))              
                { ?>
                <?php                 
                echo utf8_encode($mostrar['codigo'])  ;
                 ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <div class="usuario">
    <div class="menu_u">
    <div class="nombre_u"> <?php echo "<b> Usuario: </b> ".$usuario_login;?><br><?php echo  "<b> Id: </b>". $idUsuario['identificador'].$idoficina; ?></div>
    <div><a  href="#" onclick="usuario()"><i class="fa-solid fa-user"></i></a></div>
    </div>
    <div id="user" class="sesion ver">
    <a href="cerrar_s.php">Cerrar Sesion</a>
    </div>
    </div>
</header>  
   