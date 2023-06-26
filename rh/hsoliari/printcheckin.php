<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

if (isset($_GET['setid']))
    $SETID = $_GET['setid'];
else
   $SETID = '001';
if (isset($_GET['idreserva']))
   $XNUMRES = $_GET['idreserva'];
else
    $XNUMRES = '00001';
$XOBJRES=new greservas;
	//INFORMACION DE PRE-RESERVAS

$XRSRES=$XOBJRES->buscar_checkin($SETID,$XNUMRES);
$XROWCLI=$XOBJRES->obtener_fila($XRSRES);
if (isset($XROWCLI[0])) {
    $huesped =  $XROWCLI[0];
    $cedula = $XROWCLI[1];
    $email = $XROWCLI[2];
    $celular = $XROWCLI[3];
    $pais = $XROWCLI[4];
    $fecha_reserva = $XROWCLI[5];
    $valor = $XROWCLI[6];
    $adultos = $XROWCLI[7];
    $menores = $XROWCLI[8];
    $checkin = $XROWCLI[9];
    $checkout = $XROWCLI[10];
    $hab = $XROWCLI[11];
    $fechacheckin =  $XROWCLI[12];

}
$XRSPAX=$XOBJRES->buscar_pax($SETID,$XNUMRES);
$XI=0;
while($XROWPAX=$XOBJRES->obtener_fila($XRSPAX)){
	$XNAMEPAX[$XI] = $XROWPAX[0];
	$CEDULAPAX[$XI] =  $XROWPAX[1];
	$XI++;
}

$XRSAB=$XOBJRES->buscar_abono($SETID,$XNUMRES);
$XABONOI=0;
while($XROWAB=$XOBJRES->obtener_fila($XRSAB)){
	$XABONO[$XABONOI] = $XROWAB[0];
	$XSALDO[$XABONOI] =  $XROWAB[1];
	$XABONOI++;
}


?>

<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>imprimir</title>
    <link rel="stylesheet" href="assets/css/printcheckin.css">
      <link rel="stylesheet" href="assets/css/app.css">
    <link href="assets/css/print.css" rel="stylesheet" media="all">
    <nav>
       <div class="menu-a">
         <a href="buscar_reservas.php">Retornar</a>
       <a href="index2.php">Menu Principal</a>
       </div>
       <br>
    </nav>

</header>
<body>   
   <div class="datos">
   <a class="float-right printbutton" href="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a>
      <h1>hotel soliari</h1>
      <div>
          <span>numero de checkin: <?php echo $XNUMRES;?></span>  <span>Fecha checkin: <?php echo $fechacheckin;?></span>

      </div>
       <div>
           <span>
               fecha de entrada: <?php echo $checkin ?>
           </span>
       </div>
      
       <div>
           <span>
               Fecha de salida <?php echo $checkout; ?>
           </span>
        </div>
       <div>
           <span>
               huesped <?php echo $huesped; ?>
           </span>
        </div>
       <div>
           <span>
               documento <?php echo $cedula; ?>
           </span>
        </div>
       <div>
           <span>
               email <?php echo $email; ?>
           </span>
        </div>
       <div>
           <span>
               telefono <?php echo $celular; ?>
           </span>
        </div>
       <div>
           <span>
               pais <?php echo $pais; ?>
           </span>
        </div>
       <div>
           <span>
              habitacion <?php echo $hab; ?>
           </span>
        </div>
       <div>
           <span>
               valor total <?php echo $valor; ?>
           </span>
       </div>       
        <div>
           <span>
           Acompanantes:
      <?php
      $YX = 0;
      WHILE ($YX < $XI)
      {
          echo '<br> Nombre: ' .$XNAMEPAX[$YX] .' Cedula: ' . $CEDULAPAX[$YX]  ;
          $YX++;
      }
      ?>
           </span>
        </div>
       <div>
           <span>
               Abonos
      <?php
      $YX = 0;
      WHILE ($YX < $XABONOI)
      {
         if ($XABONO[$YX])
          echo '<br> Abono: ' .$XABONO[$YX] .' Saldo: ' . $XSALDO[$YX] ;
          $YX++;
      }
      ?>

           </span>
       </div>
       <div class="firma">
           <span><br><br><br>
             <hr>
              firma
           </span>
        </div>       
   </div>
    
</body>
</html>
