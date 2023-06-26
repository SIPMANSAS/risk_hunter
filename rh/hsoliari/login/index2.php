<?php
//include "assets/login.php";
include_once 'classes/menu.class.php';
date_default_timezone_set('America/Bogota');
ini_set("session.cookie_lifetime","107200");
ini_set("session.gc_maxlifetime","107200");
@session_start();
if(isset($_SESSION['id_usuario'])){ 
	$user= $_SESSION['id_usuario'];
	$name= $_SESSION['nom_usuario'];
	$profile=$_SESSION['per_usuario'];
	$level= $_SESSION['niv_usuario'];
	$job=$_SESSION['car_usuario'];
}
else{
	$user='';
	$level='';
	$name='';
	$profile='';
	$job='';
}

if(isset($_GET['sec']))
	$XSEC=$_GET['sec'];
else
	$XSEC='';

$XOBJMNU=new menu;
$XPADRE="'HEADER'";
$XLENG="'ESP'";
$XCLASS="'".$profile."'";

$XRSMENU=$XOBJMNU->FncBuscarMenu($XLENG, $XPADRE, "'001'");
$XI=0;
while($XROWMENU=$XOBJMNU->obtener_fila($XRSMENU)){//CREA EL ARREGLO PARA EL MENU
	$XLABEL[$XI]=htmlentities($XROWMENU[0]);
	$XPAG[$XI]=$XROWMENU[2];
	$XI++;
}
//if($XSEC=='') $XACTUAL=$XDESCL[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>::: ERP - SOFTWARE HOTELERO DESHIDA :::</title>
	<!--<meta charset="utf-8">	
    	<link rel="stylesheet" href="css/style2.css" type="text/css" media="all">-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <link rel="stylesheet" type="text/css" href="css/mevais.css" />
    <link rel="stylesheet" type="text/css" href="css/style3.css" />
	<link rel="stylesheet" href="js/jquery-ui/jquery-ui.css">
	<script src="js/external/jquery/jquery.js"></script>
	<script src="js/jquery-ui/jquery-ui.js"></script>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://anandchowdhary.github.io/ionicons-3-cdn/icons.css" integrity="sha384-+iqgM+tGle5wS+uPwXzIjZS5v6VkqCUV7YQ/e/clzRHAxYbzpUJ+nldylmtBWCP0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

      <link rel="stylesheet" href="css/stylem.css">

         <link rel="stylesheet" href="css/calendario.css">
    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet">


</head>

<body>

<ul class="main__menu">
  <li class="list-item">
    <a href="#" class="about item--js">
      <span>FRONT DESK</span>
      <i class="ion ion-ios-home"></i>
    </a>
    <ul class="drop-menu menu-1">
      <li class="drop-item">
      <?php
      	echo'<a href="?sec=modulos/reservas/disponibilidad" class="item--3">Disponibilidad Habitacion</a></li>';
        ?>
       <li class="drop-item">
       <?php
      	echo'<a href="?sec=modulos/reservas/buscar_reservas" class="item--2">Gestion Reservas</a></li>';
      ?>
      <li class="drop-item"><a href="#" class="item--1">Check-in</a></li>
        <li class="drop-item"><a href="#" class="item--3">Traslado de Habitaciones</a></li>
    </ul>
  </li>
  <li class="list-item">
    <a href="#" class="kabobs item--js">
      <span>FACTURACION</span>
         <i class="ion ion-ios-paper"></i>
     </a>
    <ul class="drop-menu menu-2">
      <li class="drop-item"><a href="#" class="item--1">Cargos a Cuentas</a></li>
      <li class="drop-item"><a href="#" class="item--2">Check-out</a></li>
      <li class="drop-item"><a href="#" class="item--3">Ingresos a Caja</a></li>
         <li class="drop-item"><a href="?sec=modulos/facturacion/pventa" class="item--1">Puntos de Venta</a></li>
      </ul>
  </li>
  <li class="list-item">
    <a href="#" class="home item--js">
      <span>COMPRAS ALMACEN</span>
         <i class="ion ion-ios-basket"></i>
     </a>
      <ul class="drop-menu menu-3">
          <li class="drop-item"><a href="?sec=modulos/compras/compras" class="item--1">Ordenes de compra</a></li>
          <li class="drop-item"><a href="?sec/modulos/compras/buscar_egresos" class="item--2">Proveedores</a></li>
          <li class="drop-item"><a href="?sec/modulos/compras/buscar_intenciones" class="item--3">intenciones</a></li>
        </ul>
  </li>

  <li class="list-item">
    <a href="#" class="widget item--js">
      <span>INFORME GERENCIA</span>
         <i class="ion ion-md-stats"></i>
     </a>
   <ul class="drop-menu menu-4">
          <li class="drop-item"><a href="?sec=modulos/gerencia/consolidado" class="item--1">Consolidado</a></li>
          <li class="drop-item"><a href="?sec=modulos/gerencia/productos" class="item--2">productos</a></li>
          <li class="drop-item"><a href="?sec=modulos/gerencia/venam" class="item--3">Ambientes</a></li>
          <li class="drop-item"><a href="?sec=modulos/gerencia/venhab" class="item--3">Habitaciones</a></li>
        </ul>
  </li>

  <li class="list-item">
    <a href="#" class="contact item--js">
      <span>CONTABILIDAD</span>
           <i class="ion ion-ios-calculator"></i>
        </a>
        <ul class="drop-menu menu-2">
          <li class="drop-item"></li>
          <li class="drop-item"></li>
          <li class="drop-item"></li>
          <li class="drop-item"></li>
        </ul>
  </li>
</ul>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
 	<?php
 			if(file_exists($XSEC.".php")){
				include ($XSEC.".php");
			}

		?>



 <div class="containerm">
        <div class="menu-toggle">
            <span class="fa fa-plus"></span>
        </div>
        <div class="menu-line">
            <div class="btn-app">
               <a href="../index.php"><div class="fa fa-sign-out"></div></a>
            </div>
            <div class="btn-app">
                <a href=""><div class="fa fa-cog"></div></a>
            </div>
        </div>
  <script  src="js/index.js"></script>
</div>

</body>
</html>
