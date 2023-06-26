<?php
    include_once 'classes/greservas.class.php';
    include_once 'assets/funciones.php';
    
    $hoy= date('Y-m-d');
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
       <span>DESAYUNOS ACTIVOS PARA EL DIA <?php echo $hoy; ?></span>

        <a class="float-right printbutton" href="javascript:window.print();"><span>
        <img src="assets/images/imprimir.png" alt=""></span>
         </a>
          <a class="float-right printbutton" href="index2.php">Menu Principal</a>

   </header>
    <div class="mostrar">
        <ul>
            <li>No.Rsv</li>
            <li>Nombre Cliente</li>
             <li>Habitacion</li>
            <li>Checkout</li>
            <li>Adultos</li>
            <li>NiNos</li>
            <li>#PAX</li>
            <li>DIAS</li>
            <li>#DES</li>

           </ul>
        <?php
        
        	$XOBJRES=new greservas;
           	$setid = "001";
           	$parqueadero = (int)"1";
           	$filtros = "tbl_reservas.setid like '%001%' and tbl_reservas.estado like '%10%' and tbl_det_reservas.desayuno like '%1%' ";
            $XRSRES=$XOBJRES->buscar_checkout($filtros);
           while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
              $totaldes =  (int)$XROWRES[11] * (int)$XROWRES[14];
           
           echo ' <div class="mostrar"><ul>
            <div class="datos">'. $XROWRES[0].'</div>
             <div class="datos">'.$XROWRES[4].'</div>
            <div class="datos"> </div>
              <div class="datos">'.$XROWRES[1].'</div>
            <div class="datos">' .$XROWRES[7].'</div>
            <div class="datos"> </div>
            <div class="datos">' .$XROWRES[12].'</div>
            <div class="datos">' .$XROWRES[13].'</div>
             <div class="datos">' .$XROWRES[11].'</div>
             <div class="datos">' .$XROWRES[14].'</div>
              <div class="datos">' .$totaldes.'</div>
            </ul></div>';
        }
        ?>
    </div>
</body>
</html>
