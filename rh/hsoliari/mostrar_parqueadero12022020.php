<?php
    include_once 'classes/greservas.class.php';
    include_once 'assets/funciones.php';
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Parqueadero</title>
    <link rel="stylesheet" href="assets/css/mostrar.css">
      <link rel="stylesheet" href="assets/css/app.css">
      <link href="assets/css/print.css" rel="stylesheet" media="all">



</head>
<body>
   <header>
       <img src="assets/images/logo-soliari.png" alt="">
       <span>Listado de parqueadero</span>

        <a class="float-right printbutton" href="javascript:window.print();"><span>
        <img src="assets/images/imprimir.png" alt=""></span>
         </a>
          <a class="float-right printbutton" href="index2.php">Menu Principal</a>

   </header>
    <div class="mostrar">
        <ul>
            <li>Cedula</li>
            <li>Nombre Cliente</li>
             <li>Habitacion</li>
            <li>Placa</li>
            <li>T. Vehiculo</li>
            <li>F. Entrada</li>
           </ul>
        <?php
        
        	$XOBJRES=new greservas;
           	$setid = "001";
           	$parqueadero = (int)"1";
           	$filtros = "tbl_reservas.setid like '%001%' and tbl_reservas.estado like '%10%' and tbl_det_reservas.parqueadero like '%1%' ";
            $XRSRES=$XOBJRES->buscar_checkout($filtros);
           while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
           
           echo ' <div class="mostrar"><ul>
            <div class="datos">'. $XROWRES[3].'</div>
            <div class="datos">'.$XROWRES[4].'</div>
            <div class="datos">' .$XROWRES[1].'</div>
            <div class="datos">' .$XROWRES[8].'</div>
            <div class="datos">' .$XROWRES[10].'</div>
             <div class="datos">' .$XROWRES[6].'</div>
            </ul></div>';
        }
        ?>
    </div>
</body>
</html>
