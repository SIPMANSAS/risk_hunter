<?php
    include_once 'classes/greservas.class.php';
    include_once 'assets/funciones.php';


?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Parqueadero</title>
    <link rel="stylesheet" href="assets/css/mostrar.css">
</head>
<body>
   <header>
       <img src="assets/images/logo-soliari.png" alt="">
       <span>Listado de parqueadero</span>

        <a class="printbutton" href="javascript:window.print();"><span>
        <img src="assets/images/imprimir.png" alt=""></span>
         </a>
          <a class="printbutton" href="index2.php">Menu Principal</a>

   </header>
    <div class="mostrar">
        <div class="titulo">
            <div>Cedula</div>
            <div>Nombre Cliente</div>
            <div>Habitacion</div>
            <div>Placa</div>
            <div>T. Vehiculo</div>
            <div>F. Entrada</div>
        </div>
        <?php
        
        	$XOBJRES=new greservas;
           	$setid = "001";
           	$parqueadero = (int)"1";
           	$filtros = "tbl_reservas.setid like '%001%' and tbl_reservas.estado like '%10%' and tbl_det_reservas.parqueadero like '%1%' ";
            $XRSRES=$XOBJRES->buscar_checkout($filtros);
           while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
           
           echo ' 
           <div class="datos">
                <div>'.$XROWRES[3].'</div>
                <div>'.$XROWRES[4].'</div>
                <div>'.$XROWRES[1].'</div>
                <div>'.$XROWRES[8].'</div>
                <div>'.$XROWRES[10].'</div>
                <div>'.$XROWRES[6].'</div>
            </div>';
        }
        ?>
    </div>
</body>
</html>
