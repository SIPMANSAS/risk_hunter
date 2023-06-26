<?php
    $conect = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');
    $sqlusuario = "select * from v_usuarios where usuario = '$usuario_login' and identificador ";    
    $resultU = mysqli_query($conect, $sqlusuario); 
    $idUsuario=mysqli_fetch_array($resultU);
    $id_menu_p= $idUsuario['identificador'];
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
    <script src="../js/menu.js"></script>
    <script src="../js/menu_usuario.js"></script>
</head>
<header>
    <div class="logo">
        <a href="menu.php"><img src="../img/logo_ies.fw.png" alt=""></a>
    </div>
    <div class="div_m_admin">
        <div id="btnMenu"  onclick="mostrarmenu()" class="nav-bar"><i class="fa-solid fa-bars"></i>&nbsp;<span class="n_menu">Administrador</span></div>
        <nav class="main-nav">
            <ul class="menu" id="menu">
            <?php
                $sql = "select * from v_menus_x_usuario where id_menu and id_usuario = '$id_menu_p' ORDER BY `v_menus_x_usuario`.`menu` ASC  ";
                $resultM = mysqli_query($conect, $sql);
                                    
                while($mostrar=mysqli_fetch_array($resultM))              
                { ?>
                <?php echo $mostrar['codigo']; ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <div class="usuario">
    <div class="menu_u">
    <div class="nombre_u"> <?php echo "<b>| Usuario: </b> ".$usuario_login;?><br><?php echo  "<b> Id: </b>". $idUsuario['identificador']; ?></div>
    <div><a  href="#" onclick="usuario()"><i class="fa-solid fa-user"></i></a></div>
    </div>
    <div id="user" class="sesion ver">
    <a href="../cerrar_s.php">Cerrar Sesion</a>
    </div>
    </div>
</header>  
   