<?php
    $conect = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');

    $sqlusuario = "select * from v_usuarios where usuario = '$usuario' ";    
    $resultU = mysqli_query($conect, $sqlusuario); 
    $idUsuario=mysqli_fetch_array($resultU);
    $id_menu_p= $idUsuario['identificador'];


    $sql = "select * from sg_objetos where id_clase='2' and id_objeto_padre = '100'";
    $sqlSub= "select * from sg_objetos where id_clase='2' and id_objeto_padre between 37 and 91 ";
    $result = mysqli_query($conect, $sql);
    $resultB= mysqli_query($conect, $sqlSub);   
    
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
        <a href="menu.php"><img src="img/logo_ies.fw.png" alt=""></a>
    </div>
    <div class="div_m_admin">
        <div id="btnMenu"  onclick="mostrarmenu()" class="nav-bar"><i class="fa-solid fa-bars"></i>&nbsp;<span class="n_menu">Administrador</span></div>
        <nav class="main-nav">
            <ul class="menu" id="menu">

<?php while($mostrar=mysqli_fetch_array($result)) { ?>
    <?php echo $mostrar['codigo']."</br>"; $id = $mostrar['identificador']; 
    $sub= mysqli_fetch_array($resultB); ?>
    <?php
        while($id = $sub['id_objeto_padre'] ) { ?>
            <?php             
            echo $sub['codigo'] ; break;?>
    <?php } ?>
<?php } ?>
</ul>
        </nav>
    </div>
    <div class="usuario">
    <div class="menu_u">
    <div class="nombre_u"> <?php echo "<b>Usuario: </b>".$usuario. "</br> Id:<b> ". $idUsuario['identificador']."</b>";?></div>
    <div><a  href="#" onclick="usuario()"><i class="fa-solid fa-user"></i></a></div>
    </div>
    <div id="user" class="sesion ver">
    <a href="cerrar_s.php">Cerrar Sesion</a>
    </div>
    </div>
</header>  
 