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
      <span>RECEPCION</span>
      <i class="ion ion-ios-home"></i>
    </a>
    <ul class="drop-menu menu-1">
      <li class="drop-item">
      <?php
      	echo'<a href="home.php" class="item--3">Disp. Habitacion</a></li>';
        ?>
       <li class="drop-item">
       <?php
      	echo'<a href="buscar_reservas.php" class="item--2">Gestion Reservas</a></li>';
      ?>
      <li class="drop-item"><a href="checkin.php" class="item--1">Check-in</a></li>
    </ul>
  </li>
  <li class="list-item">
    <a href="#" class="kabobs item--js">
      <span>FACTURACION</span>
         <i class="ion ion-ios-paper"></i>
     </a>
    <ul class="drop-menu menu-2">
      <li class="drop-item"><a href="http://http://www.deshida.com.co/soliari/puntoventa/zarest/" class="item--1">Cargos a Cuentas</a></li>
      <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/checkout/" class="item--2">Check-out</a></li>
         <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/pos/switshtable" class="item--3">Puntos de Venta</a></li>
         <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/sales" class="item--1">Ingresos a Caja</a></li>
      </ul>
  </li>
  <li class="list-item">
    <a href="#" class="home item--js">
      <span>COMPRAS ALMACEN</span>
         <i class="ion ion-ios-basket"></i>
     </a>
      <ul class="drop-menu menu-3">
          <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/expences" class="item--1">Ordenes de compra</a></li>
          <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/suppliers" class="item--2">Proveedores</a></li>
        </ul>
  </li>
  <li class="list-item">
    <a href="#" class="widget item--js">
      <span>INFORME GERENCIA</span>
         <i class="ion ion-md-stats"></i>
     </a>
   <ul class="drop-menu menu-4">
           <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/stats" class="item--1">Consolidado</a></li>
          <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/stats#producto" class="item--2">productos</a></li>
          <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/stats#ambiente" class="item--3">Ambientes</a></li>
          <li class="drop-item"><a href="http://www.deshida.com.co/soliari/puntoventa/zarest/stats#stock" class="item--1">Stock de Productos</a></li>
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
               <a href="login/logout.php"><div class="fa fa-sign-out"></div></a>
            </div>
            <div class="btn-app">
                <a href=""><div class="fa fa-cog"></div></a>
            </div>
             <div class="btn-app">
                <a href="http://www.deshida.com.co/soliari/puntoventa/recepcion/login"><div class="fa fa-sign-in"></div></a>
            </div>
        </div>
  <script  src="js/index.js"></script>
</div>
</body>

</html>

