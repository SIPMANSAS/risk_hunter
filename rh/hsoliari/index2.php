<!DOCTYPE html>

<html lang="es">

<head>

	<title>::: HOROS ERP :::</title>

	<!--<meta charset="utf-8">	

    	<link rel="stylesheet" href="css/style2.css" type="text/css" media="all">-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

    <link rel="stylesheet" type="text/css" href="assets/css/style3.css" />

    <link rel="stylesheet" href="https://anandchowdhary.github.io/ionicons-3-cdn/icons.css" integrity="sha384-+iqgM+tGle5wS+uPwXzIjZS5v6VkqCUV7YQ/e/clzRHAxYbzpUJ+nldylmtBWCP0" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/stylemenuppal.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link rel="stylesheet" href="assets/css/stylem.css">

    <link rel="stylesheet" href="css/calendario.css">
    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet">
</head>



<body>

<ul class="main__menu">
  <li class="list-item">
    <a href="index2.php" class="about item--js">
      <span>DISPONIBILIDAD HABITACIONES</span>
      <i class="ion ion-ios-home"></i>
    </a>
    <ul class="drop-menu menu-1">
      <li class="drop-item">
      <?php
      	echo'<a href="home.php" class="item--3">CALENDARIO</a></li>';
        ?>
       <li class="drop-item">
       <?php
      	echo'<a href="blocklist.php" class="item--2">BLOQUE RESERVAS</a></li>';
      ?>
      <li class="drop-item"><a href="verdisponibilidad.php" class="item--3">VER DISPONIBILIDAD </a></li>
       <li class="drop-item"><a href="hbloqueada.php" class="item--2">HAB. BLOQUEADA </a></li>

    </ul>
  </li>
  <li class="list-item">
    <a href="#" class="kabobs item--js">
      <span>GESTION DE RESERVAS</span>
         <i class="ion ion-ios-paper"></i>
     </a>
    <ul class="drop-menu menu-2">
      <li class="drop-item"><a href="buscar_reservas.php" class="item--1"> RESERVAS</a></li>
      <li class="drop-item"><a href="checkin.php" class="item--3">CHECKIN</a></li>
      <li class="drop-item"><a href="modificar_checkin.php" class="item--2">GESTION CHECKIN </a></li>
      <li class="drop-item"><a href="buscar_checkoutoficial.php" class="item--3">GESTION CHECKOUT </a></li>

        </ul>
  </li>
  <li class="list-item">
    <a href="#" class="home item--js">
      <span>PUNTOS DE VENTA</span>
         <i class="ion ion-ios-basket"></i>
     </a>
       <ul class="drop-menu menu-3">
     <li class="drop-item"><a href="pagos/pos/switshtable" class="item--3">  ABRIR PUNTO VENTA </a></li>
     <li class="drop-item"><a href="pagos/sales" class="item--1">  ABONOS </a></li>
      <li class="drop-item"><a href="pagos/sales" class="item--2">  VENTAS </a></li>
        </ul>
     </li>
  <li class="list-item">
    <a href="#" class="widget item--js">
      <span>INFORMES GERENCIA</span>
         <i class="ion ion-md-stats"></i>
     </a>
   <ul class="drop-menu menu-4">
         <li class="drop-item"><a href="planificadorpedido.php" class="item--3">PLANIFICAR PEDIDOS </a></li>
          <li class="drop-item"><a href="mostrar_desayuno.php" class="item--2">LISTAR DESAYUNOS </a></li>
            <li class="drop-item"><a href="buscar_abonos1.php" class="item--3">BUSCAR ABONOS </a></li>
           <li class="drop-item"><a href="pagos/stats" class="item--1"> CONSOLIDADO </a></li>

           </ul>
  </li>
    <li class="list-item">
    <a href="contabilidad.php" class="contact item--js">
      <span>CONTABILIDAD</span>
         <i class="ion ion-ios-calculator"></i>
     </a>
    </li>
</ul>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
 <div class="containerm">
        <div class="menu-toggle">
            <span class="fa fa-plus"></span>
        </div>
        <div class="menu-line">
            <div class="btn-app">
               <a href="login/?logout=true"><div class="fa fa-sign-out"></div></a>
            </div>
            <div class="btn-app">
                <a href=""><div class="fa fa-cog"></div></a>
            </div>
             <div class="btn-app">
                <a href="login/?logout=true"><div class="fa fa-sign-in"></div></a>
            </div>
        </div>
  <script  src="js/index.js"></script>
</div>
</body>

</html>

