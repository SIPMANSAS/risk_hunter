<?php
    error_reporting(E_ERROR);
    include_once 'clases/gabriel.class.php';
    include 'conexion/conexion.php';

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
    $version_usuario = $idUsuario['usuario_version_sistema'];
    
    $consultausuario = $mysqli->query("SELECT * FROM sg_usuarios WHERE usuario LIKE '%$usuario_login%'");
    $extraerdatos = $consultausuario->fetch_array(MYSQLI_ASSOC);
    $id_usuario_ext = $extraerdatos['identificador'];
    $usaurionombresolicitante = $extraerdatos['nombre'].' '.$extraerdatos['apellidos'];
    
    $consultarolesxusuario = $mysqli->query("SELECT * FROM sg_roles_x_usuario WHERE id_usuario = '$id_menu_p'");
    while($extraerusuarioroles = $consultarolesxusuario->fetch_array()){
        $rolxusuario = $extraerusuarioroles['id_rol'];
        '<br>';
    }
    
    
    
    $fecha_solicitud =  date('Y-m-d');
    $año = date('Y');
    
    if($version_usuario == 1){
        $texto_version = "Version Premium";
    }else{
        $texto_version = "Version Free";
       
    }
    
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
      <link rel="shortcut icon" href="favicon.ico">
</head>
<header>
    <div class="logo">
        <?php 
        //$LINKMENU = $LINKS."menu.php";
        $LINKMENU = "menu.php";
        $LINKLOGO = $LINKS."img/logo_ies.fw_2.png";
        //echo "<a href =" . $LINKMENU . "><img src=" . $LINKLOGO ." alt=\" \"></a>";
        ?>
        <a href="<?php echo $LINKMENU ?>"><img src="img/logo_ies.fw_2.png" alt="Girl in a jacket"></a>
    </div>
    <div class="div_m_admin">
        <div id="btnMenu"  onclick="mostrarmenu()" class="nav-bar"><i class="fa-solid fa-bars"></i>&nbsp;<span class="n_menu">Administrador</span></div>
        <nav class="main-nav">
            <ul class="menu" id="menu">
                
            <?php
            /*
            switch($rolxusuario){
                case 1:
                    
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-dollar-sign"></i>&nbsp; Facturación</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="facturacion.php" class="menu__link">Facturación</a>
                                    </li>
                                </ul>
                            </li>';
                    break;
                    
                case 2:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Administrar Usuarios</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listausuariosrh.php" class="menu__link">Lista de Usuarios</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="registrousuarios.php" class="menu__link">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Administrar Inspecciones</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Asignar Inspector</a>
                                    </li>
                                </ul>
                            </li>
                            ';
                    break; 
                
                case 14:
                    echo '<script>alert("Tecnico Aplicativo");</script>';
                    break;
                    
                case 4:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-dollar-sign"></i>&nbsp; Facturación</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="facturacion.php" class="menu__link">Facturación</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Consulta Informes</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Asignar Inspector</a>
                                    </li>
                                </ul>
                            </li>';
                    break;
                    
                case 5:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Administrar Usuarios</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listausuariosrh.php" class="menu__link">Lista de Usuarios</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="registrousuarios.php" class="menu__link">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="menu__item container-submenu">
                                <a href="#" class="menu__link submenu-btn">
                                    <i class="fa-solid fa-user-tie"></i>Procesos</a>
                                    <ul class="submenu">
                                        <li class="menu__item">
                                            <a href="listarencabezadocompaniaseguros.php" class="menu__link">Desde  la compañia aseguradora</a>
                                        </li>
                                        <li class="menu__item">
                                            <a href="listarencabezadofirmas.php" class="menu__link">Desde  la firma inspectora</a>
                                        </li>
                                        <li class="menu__item">
                                            <a href="listarencabezadoinspector.php" class="menu__link">Desde Inspectores</a>
                                        </li>
                                        </li>
                                        <li class="menu__item">
                                            <a href="exportacion/exportarparrillacompleta.php" class="menu__link">Generar Sabana</a>
                                        </li>
                                        <li class="menu__item">
                                            <a href="listasabana.php" class="menu__link">Consultar Sabana</a>
                                        </li>
                                    </ul>
                            </li>
                            <li class="menu__item">
                                <a href="exportacion/exportarparrillacompleta.php" class="menu__link"></a>
                            </li>
                            <li class="menu__item"></li>';
                    break;
                    
                case 6:
                    //echo '<script>alert("Tecnico CIA Seguros");</script>';
                     echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Administrar Usuarios</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listausuariosrh.php" class="menu__link">Lista de Usuarios</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="registrousuarios.php" class="menu__link">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Administrar Inspecciones</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Asignar Inspector</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadoinspector.php" class="menu__link">Desde Inspectores</a>
                                    </li>
                                    <li class="menu__item">
                                            <a href="listasabana.php" class="menu__link">Consultar Sabana</a>
                                        </li>
                                </ul>
                            </li>
                            ';
                    break;
                    
                case 7:
                     echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-dollar-sign"></i>&nbsp; Facturación</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="facturacion.php" class="menu__link">Facturación</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Consulta Informes</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                </ul>
                            </li>';
                    break;
                    
                case 8:
                    //echo '<script>alert("Facilitador FI");</script>';
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Procesos</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listarencabezadocompaniaseguros.php" class="menu__link">Desde la compañia aseguradora</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Desde la firma inspectora</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadoinspector.php" class="menu__link">Desde Inspectores</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    
                                </ul>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                             <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Administrar Usuarios</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listausuariosrh.php" class="menu__link">Lista de Usuarios</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="registrousuarios.php" class="menu__link">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                           
                            ';
                    break; 
                    
                case 9:
                    //echo '<script>alert("Inspector FI");</script>';
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-user"></i>&nbsp; Administrar Usuarios</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listausuariosrh.php" class="menu__link">Lista de Usuarios</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="registrousuarios.php" class="menu__link">Crear Usuario</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Administrar Inspecciones</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Asignar Inspector</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Desde la firma inspectora</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadoinspector.php" class="menu__link">Desde Inspectores</a>
                                    </li>
                                    <li class="menu__item">
                                            <a href="listasabana.php" class="menu__link">Consultar Sabana</a>
                                        </li>
                                </ul>
                            </li>
                            ';
                    break;
                    
                case 10:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-dollar-sign"></i>&nbsp; Facturación</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="facturacion.php" class="menu__link">Facturación</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Consulta Informes</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes De Inspección</a>
                                    </li>
                                </ul>
                            </li>';
                    break;
                    
                case 11:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Administrar Inspecciones</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Asignar Inspector</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadofirmas.php" class="menu__link">Desde la firma inspectora</a>
                                    </li>
                                    <li class="menu__item">
                                        <a href="listarencabezadoinspector.php" class="menu__link">Desde Inspectores</a>
                                    </li>
                                    <li class="menu__item">
                                            <a href="listasabana.php" class="menu__link">Consultar Sabana</a>
                                        </li>
                                </ul>
                            </li>';
                    break;
                    
                case 12:
                    echo '<li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-dollar-sign"></i>&nbsp; Facturación</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="facturacion.php" class="menu__link">Facturación</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu__item container-submenu">
                            <a href="#" class="menu__link submenu-btn">
                                <i class="fa-solid fa-file-contract ">
                                </i>&nbsp; Consulta Informes</a>
                                <ul class="submenu">
                                    <li class="menu__item">
                                        <a href="listasabana.php" class="menu__link">Consulta Informes De Inspección</a>
                                    </li>
                                </ul>
                            </li>';
                    break;
                    
                case 13:
                    echo '<script>alert("Usuario FR");</script>';
                    break;
                    
            }
            */
            if($version_usuario == 1){
                $filtro = $id_menu_p;
                $Jsonmenu     = new gabriel;
                $consulta = $Jsonmenu->iniciarVariables();
                $xcompproyectos = $Jsonmenu->menudinamico($filtro);                                    
                while($mostrar=$Jsonmenu->obtener_fila($xcompproyectos))              
                { ?>
                <?php                 
                echo ($mostrar['codigo'])  ;
                 ?>
                <?php 
                } 
            }else{
                ?>
               
                <?php
                $año = date('Y');
                
                
                $consultaexistencia = $mysqli->query("SELECT COUNT(1) AS existe FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND origen LIKE '%FR%' AND fecha_terminacion IS NULL");
                $extraerexistencia = $consultaexistencia->fetch_array(MYSQLI_ASSOC);
                $existedatos = $extraerexistencia['existe'];
                
 
                if($existedatos == 0){
                    
                    $consultamaximofreemium = $mysqli->query("SELECT IFNULL(MAX(consecutivo),0) AS Ultimo FROM enc_inspeccion WHERE origen LIKE '%FR%'");//id_usuario='$id_usuario_ext'
                    $extraerDatos = $consultamaximofreemium->fetch_array(MYSQLI_ASSOC);
                    $ultimomaximofreemium = $extraerDatos['Ultimo']+1;
                    $consecutivocodigofreemium = 'FR-'.$año.'-'.$ultimomaximofreemium;
                    ?>
                    <input type="hidden" value="<?php echo $consecutivocodigofreemium?>" >
                    <?php

                    $insertaencabezadofreemium = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,estado,nombre_edificacion,origen,numero_inspeccion,nombre_solicita,consecutivo)VALUES('$id_usuario_ext','$fecha_solicitud','1','Edificacion Freemium','FR','$consecutivocodigofreemium','$usaurionombresolicitante','$ultimomaximofreemium')");
                    
                    $consultamaximo = $mysqli->query("SELECT IFNULL(MAX(identificador),0) AS Ultimo FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND origen LIKE '%FR%' AND fecha_terminacion IS NULL");
                    $extraerDatos = $consultamaximo->fetch_array(MYSQLI_ASSOC);
                    $ultimomaximo = $extraerDatos['Ultimo'];
                    
                    $insertainmuebles = $mysqli->query("INSERT INTO enc_inmuebles(id_encuesta,descripcion,tipo_bien,observaciones)VALUES('$ultimomaximo','Inmueble Freemium','816','Inmueble Freemium')");
                }else{
                    
                    $consultamaximo = $mysqli->query("SELECT (identificador) AS Ultimo FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND origen LIKE '%FR%' AND fecha_terminacion IS NULL");
                    $extraerDatos = $consultamaximo->fetch_array(MYSQLI_ASSOC);
                    $ultimomaximo = $extraerDatos['Ultimo'];
                    "SELECT (identificador) AS Ultimo FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND origen LIKE '%FR%' AND fecha_terminacion IS NULL";
                    ?>
                    <input type="hidden" value="<?php echo $ultimomaximo +1?>" >
                    <?php
                   
                }
                
                
                $consultautultimoinmueble = $mysqli->query("SELECT identificador AS UltimoInmueble FROM enc_inmuebles WHERE id_encuesta ='$ultimomaximo'");
                $extraeridentificadorinmueble = $consultautultimoinmueble->fetch_array(MYSQLI_ASSOC);
                $identificador_inmueble_ultimo = $extraeridentificadorinmueble['UltimoInmueble'];
                
                '<br><br>';
                "SELECT f_primer_pregunta_bloque($ultimomaximo,$identificador_inmueble_ultimo) primer_pregunta";
                $consultapregunta = $mysqli->query("SELECT f_primer_pregunta_bloque($ultimomaximo,$identificador_inmueble_ultimo) primer_pregunta");
                $extraerprimerpregunta = $consultapregunta->fetch_array(MYSQLI_ASSOC);
                $primerpregunta =  $extraerprimerpregunta['primer_pregunta'];
                
                /*$consultapregunta = $mysqli->query("SELECT MIN(identificador) AS primera_pregunta FROM enc_preguntas WHERE id_bloque_preguntas ='$identificador_inmueble_ultimo'");
                $extraerdatosinmuebles = $consultapregunta->fetch_array(MYSQLI_ASSOC);
                $identificador_pregunta = $extraerdatosinmuebles['primera_pregunta'];*/
                
                
                ?>
                <li class="menu__item container-submenu">
                    <form action="PruebaTextDevp" method="">
                        <input type="hidden" name="id_encuesta" value="<?php echo $ultimomaximo?>">
                        <input type="hidden" name="id_bloque" value="<?php echo $identificador_inmueble_ultimo?>">
                        <input type="hidden" name="id_pregunta" value="<?php echo $primerpregunta ?>">
                        <input type="hidden" name="usuario_id" value=<?php echo $id_usuario_ext?>>
                        <input type="hidden" name="tipo_proceso" value="FR">
                        <button style="background-color:#222; border:0" type="submit" class="menu__link submenu-btn"><i class="fa fa-battery-quarter"></i>&nbsp;&nbsp;Encuesta Freemium</button>
                    </form>
                </li>
                <li class="menu__item container-submenu">
                    <form action="listarinspeccionesfree.php" method="POST">
                        <input type="hidden" name="id_encuesta" value="<?php echo $ultimomaximo?>">
                        <input type="hidden" name="id_bloque" value="<?php echo $identificador_inmueble_ultimo?>">
                        <input type="hidden" name="id_pregunta" value="<?php echo $primerpregunta ?>">
                        <input type="hidden" name="usuario_id" value=<?php echo $id_usuario_ext?>>
                        <input type="hidden" name="tipo_proceso" value="FR">
                        <button style="background-color:#222; border:0" type="submit" class="menu__link submenu-btn"><i class="fa fa-list"></i>&nbsp;&nbsp;Listar Inspecciónes</button>
                    </form>
                </li>
                
                <?php
                echo ($mostrar['codigo']);
            }    
                ?>
            </ul>
            
        </nav>
        <?php
          
        
        ?>
    </div>
    <div class="usuario">
    <div class="menu_u">
    <div class="nombre_u"> <?php echo "<b> Usuario: </b> ".$usuario_login;?><br><?php echo  "<b> Id: </b>". $id_usuario_ext; ?></div>
    <div><a  href="#" onclick="usuario()"><i class="fa-solid fa-user"></i></a></div>
    </div>
    <div id="user" class="sesion ver">
    <a href="cerrar_s.php">Cerrar Sesion</a>
    </div>
    </div>
</header>  
   