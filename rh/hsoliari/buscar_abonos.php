<?php
include_once 'classes/paginas.class.php';
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';
date_default_timezone_set("America/Bogota");

?>
<head>
  <meta charset="UTF-8">
  <title>Buscar Abonos</title>
     <link rel="stylesheet" href="assets/css/reservas2.css">
     <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     
     
</head>


<body>

<script type="text/javascript" src="assets/js/gestion_reservas3.js" ></script>
<script src="https://codepen.io/shshaw/pen/QmZYMG.js"></script>
<!-- <input type="radio" name="cice" id="nav-1" checked> -->
<div id="app">
<!-- Generated by IcoMoon.io -->
 <header>
   <nav>
    <div class="logo">
       <a href="index2.php"><img src="assets/images/logo-horos-transparente.fw.png" alt=""></a>
    </div>
    
      <div class="menu-a">
          <a href="buscar_reservas.php">Retornar</a>
      <a href="index2.php">Menu Principal</a>
      <a href="home.php">Disponibilidad de Habitaciones</a>
        </div>


    </nav>
  </header>

  <?php
  
  // Si presiono guardar busco el id de la habitacion y la habilito
  if (isset($_POST["guardar"]))
  {
    	$XOBJRES=new greservas;
    if (isset($_POST["numerofilas"]))
       $numerofilas = $_POST["numerofilas"];
    else
       $numerofilas = 0;
    for ($i=0;$i < $numerofilas;$i++)
    {
       if (isset($_POST["idhab"][$i]))
         $idhab = $_POST["idhab"][$i];
       else
         $idhab = "";
         if (isset($_POST['seleccion'][$i]) )
             if ($_POST['seleccion'][$i] != null)
             {
                   // voy a actualizar habitacion estado
                   $XACTHAB=$XOBJRES->actualiza_habestado($idhab);

             }
      }
    
  }
  
  
  

?>

  <div class="ui-pages">
    <article id="buscar">
           	<?php
           	
       	echo'
            <form class="buscar" action="buscar_abonos.php" method="post">
                <h1>Abonos  </h1>

                    ';



           	$XOBJRES=new greservas;

			$XRSRES=$XOBJRES->buscar_abonos1();
            $XNUMFILA = 0;
             echo '    	<table id="resultado" >  ';
            	echo'<tr >
            	<td class="tituT" align="center" > Id pago </td>
                <td class="tituT" align="center" > # Checkin </td>
            	<td class="tituT" align="center" > Selec </td>
            	<td class="tituT" align="center" > Cliente </td>
                <td class="tituT" align="center" > Fecha Abono </td>
                <td class="tituT" align="center" > Valor Abono </td>
           	 	<td class="tituT" align="center" > Saldo </td>
   	 	 	 	<td class="tituT" align="center" > Numhab </td>
 	 	 	 	<td class="tituT" align="center" > Metodo de Pago </td>

 		       </tr>';

            $i = 0;
            $numerofilas = 0;
            while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
           		$numcheckin = $XROWRES[0];
				$fechaabono = $XROWRES[2];
				$nombre = $XROWRES[1];
               	$valor = $XROWRES[3];
              	$saldo = $XROWRES[6];
              	$numhab = $XROWRES[5];
                $idpago = $XROWRES[7];
              	$metpago = $XROWRES[4];
              	$metodo = explode("~",$metpago);
              	if ($metodo[0] == "0")
                  $metodopago = "Efectivo";
                else
                  $metodopago = "Tarjeta";
        		echo'<tr>
        		   <td > <input type="text" class="Txtmenu" name="idpago['.$i.']" value="'.$idpago.'" readonly> </td>
        	      <td > <input type="checkbox" name="seleccion['.$i.']" value="0" > </td>
               	<td >' . $numcheckin.'</td>
        	    	<td > '.$nombre.'</td>
            	    <td >'.$fechaabono.'</td>
    	   	       	<td >'.$valor.'</td>
   	       	     	<td >'.$saldo.'</td>
                   	<td >'.$numhab.'</td>
                   	<td >'.$metodopago.'</td>';

    	   	    echo ' </tr> ';
                $i++;
                $numerofilas++;
           	}


       echo '<input type="hidden" name="numerofilas" value='.$numerofilas.'>';
      echo '	</table><img src="" alt=""> ';
      echo '<div style="position: relative;">
        <div  class="botones">
        <input type="submit"  name="guardar" id="BtnBuscar" value="HABILITAR" />
        </div>

          	</div>
          	
          	          </form>';

?>
        
      </article>

  </div>

</div>
</body>
