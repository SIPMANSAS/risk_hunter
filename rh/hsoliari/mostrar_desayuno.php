<?php
    include_once 'classes/greservas.class.php';
    include_once 'assets/funciones.php';
    
    $hoy= date('Y-m-d');
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Desayunos</title>
    <link rel="stylesheet" href="assets/css/mostrar-b.css">
</head>
<body>
   <header>
       <img src="assets/images/logo-soliari.png" alt="">
       <span>DESAYUNOS ACTIVOS PARA EL DIA <?php echo $hoy; ?></span>
        <a class="printbutton" href="javascript:window.print();"><span>
        <img src="assets/images/imprimir.png" alt=""></span>
         </a>
          <a class="printbutton" href="index2.php">Menu Principal</a>

   </header>
    <div class="mostrar">
        <div class="titulo">
            <div>No.Rsv</div>
            <div>Nombre Cliente</div>
            <div>Hab</div>
            <div>Checkout</div>
            <div>Adultos</div>
            <div>NiNos</div>
            <div>#PAX</div>
            <div>DIAS</div>
            <div>#DES</div>
        </div>
        <?php
        
        	$XOBJRES=new greservas;
           	$setid = "001";
           	$parqueadero = (int)"1";
           	$filtros = "tbl_reservas.setid like '%001%' and tbl_reservas.estado like '%10%' and tbl_det_reservas.desayuno like '%1%' ";
            $XRSRES=$XOBJRES->buscar_checkout($filtros);
            while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
              $totaldes =  (int)$XROWRES[11] * (int)$XROWRES[14];
           
            echo ' 
            <div class="datos">
                <div>'. $XROWRES[0].'</div>
                <div>'.$XROWRES[4].'</div>
                <div>'.$XROWRES[1].'</div>
                <div>' .$XROWRES[7].'</div>
                <div>' .$XROWRES[12].'</div>
                <div>' .$XROWRES[13].'</div>
                <div>' .$XROWRES[11].'</div>
                <div>' .$XROWRES[14].'</div>
                <div>' .$totaldes.'</div>
            </div>';
        }
        ?>
    </div>
</body>
</html>
