<?php
include_once 'classes/paginas.class.php';
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';
date_default_timezone_set("America/Bogota");



/* $BASEPATH = "http://localhost/rental2/calendar/";
 define("BASEPATH", $BASEPATH);
 */

/* $configFile = "rental2/calendar/includes/config.inc.php";
  $synctzFile = "rental2/calendar/includes/synctz.inc.php";
  if (file_exists($configFile)) {
      require_once ($configFile);
	  require_once ($synctzFile);
  } else {
	  exit;
  }

  require_once ("rental2/calendar/classes/class.db.php");

  require_once ("rental2/calendar/classes/class.vault.php");
  Vault::set('Database', new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Vault::get("Database");
  $db->connect();
*/

//$XACTUAL=$_GET['ruta'];
?>
<head>
  <meta charset="UTF-8">
  <title>Buscar Checkout</title>
     <link rel="stylesheet" href="assets/css/reservas2.css">
     <link href="https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <script>
  $( function() {
    $( "#datep1" ).datepicker();
  } );

   $( function() {
    $( "#datep2" ).datepicker();
  } );

  </script>

     
     
</head>


<body>

<?php


$XOBJPAG=new paginas;
$XPAGINA="'PAG_RES_GESTION'";
$XLENG="'ESP'";
$XCLASS="'001'";
$XRSPAG=$XOBJPAG->FncBuscarPagina($XLENG, $XPAGINA, $XCLASS);
$XI=0;
while($XROWPAG=$XOBJPAG->obtener_fila($XRSPAG)){//CREA EL ARREGLO PARA EL MENU
	$XLABEL[$XI]=utf8_encode($XROWPAG[0]);
	$XDISP[$XI]=$XROWPAG[1];
	$XAUT[$XI]=$XROWPAG[2];
	$XURL[$XI]=$XROWPAG[3];
	$XI++;
}
?>
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
  // busco numero de habitaciones ocupadas
               $hoy = date('Y-m-d');
     	       $XOBJRES=new greservas;
               $XNUMOCU=$XOBJRES->buscar_ocupadas($hoy);
               $XOCUP = $XOBJRES->obtener_fila($XNUMOCU);
               $OCUPADA = $XOCUP[0];
               echo '
                 <div class="ocupado">
                 <span>habitaciones ocupadas</span> <br>
                 <span>'. $OCUPADA. ' de 42</span>
                 </div>';
?>

  <div class="ui-pages">
    <article id="buscar">
           	<?php

// Se buscan reservas creadas
             $fecha_actual = date("Y-m-d");
             $fecha_inicial = date("Y-m-d",strtotime($fecha_actual."- 4 month"));
             $fecha_final = date("Y-m-d",strtotime($fecha_actual."+ 4 month"));
        	echo'
            <form class="buscar" action="buscar_ocupacionmotel.php" method="post">
                <h1>Buscar Historial de Ocupacion </h1>

                <div class="buscar-reserva">
                    <div class="rango">
                    <div><label> Sede</label>
               	  		<input type="text" id="TxtReserva" name="idres" placeholder="'.$XLABEL[2].'" />
                    </div>
                    <div><label>Numero de Habitación</label>
                        <input type="text" id="Txtnombre" name="guest" placeholder="'.$XLABEL[3].'" />
                    </div>
                </div>';
                  $calnav = '';
                  $calnav = $calnav. '
                <div class="rango">
                    <div>
                        <label> Desde</label>
                        <input type="text" name="fechadesde" id="datep1" step="1" value='.$fecha_inicial .'>
                    </div>
                    <div> '.
                        ' <label>Hasta</label>
                        <input type="text" name="fechahasta" id="datep2" step="1" value='. $fecha_final .'>
                    </div>
                     <div  class="botones">
                        <input type="submit"  name="buscar" id="BtnBuscar" value="'.$XLABEL[4].'" />

                        
                     </div>
                </div> 

                </div>
                <h1>Habitaciones</h1>
                <div class="habitaciones">
                    ';

                    $XOBJRES=new greservas;
	               $XRSRES=$XOBJRES->buscar_hospedaje1();
	               $XNUMHAB=$XOBJRES->numero_filas($XRSRES);
	               while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){

		             $calnav = $calnav;

                        $hab = $XROWRES[1];
                        $idhab = $XROWRES[0];
                        $calnav = $calnav.'
                        
                            <a href="buscar_ocupacionmotel.php?idhab='.$idhab.'&fecha=1" >
                            <img src="assets/images/habitacion.jpg"><br>
                            <i>'.$hab.'  </i></a>
                        ';

                        }
                        $calnav = $calnav;
                        echo $calnav;
                        echo '
        	        </div>
                    
     	      	   </div>
                </div>
			
            </form>';
			?>
		
<a href=""></a>
          	<div id="buscar">
          	    <table id="resultado" >
          	<?php
          	
          	if ( isset($_POST['buscar']))
          	{

             $idhab = "";
          	 $idres=$_POST['idres'];
          	$guest= $_POST['guest'];
          #	$numdoc = $_POST['cedula'];
          #	$placa = $_POST['placa'];
            if (isset($fecha)) {
              if ($fecha==1)
          	  {
               $fecha_actual = date("Y-m-d");
               $fechadesde = date("Y-m-d",strtotime($fecha_actual."- 4 month"));
               $fechahasta = date("Y-m-d",strtotime($fecha_actual."+ 4 month"));
          	  }
            }
          	else
          	{
          	$postdesde = $_POST['fechadesde'];
            $posthasta = $_POST['fechahasta'];
          	$fechadesde= date("Y-m-d", strtotime($postdesde));
          	$fechahasta= date("Y-m-d",strtotime($posthasta));
          	}
          	if (isset($_POST['idhab']))
          	    $idhab = $_POST['idhab'];
           }
           else
           {
             $idhab = "";
             $idres = "";
             $guest = "";
             $numdoc = "";
             $placa = "";
             $fecha_actual = date("Y-m-d");
             $fechadesde = date("Y-m-d",strtotime($fecha_actual."- 4 month"));
             $fechahasta= date("Y-m-d",strtotime($fecha_actual."+ 4 month"));
              $idstatus="%";
          	if (isset($_GET["idhab"]))
          	$idhab=$_GET["idhab"];
          	else
          	$idhab="";
           }
           if (isset($_POST["placa"]))
              $placa = $_POST["placa"];
           else
              $placa = "";

           	$XOBJRES=new greservas;
           	$setid = "001";
           	$filtros = "tbl_reservas.setid = '001' and tbl_reservas.id_reserva like '%".$idres."%' and
               tbl_det_reservas.fecha_ini >= '".$fechadesde ."' and tbl_det_reservas.fecha_fin <= '".
              $fechahasta."' and tbl_reservas.estado = '13' and tbl_det_reservas.id_habitacion like '%".$idhab."%'
              and tbl_det_reservas.placa like '%".$placa."%'";

			$XRSRES=$XOBJRES->buscar_checkout($filtros);
            $XNUMFILA = 0;
            	echo'<tr >
            	<td class="tituT" align="center" > # Cons </td>
       	       	<td class="tituT" align="center" > # Hab </td>
                <td class="tituT" align="center" > Checkin </td>
           	 	<td class="tituT" align="center" > Checkout </td>
   	 	 	 	<td class="tituT" align="center" > Placa </td>
 		        <td class="tituT" align="center" > Info</td>
               <td class="tituT" align="center" > Factura</td>
                 <td class="tituT" align="center" > Ingresos</td>

             </tr>';

         //   $xi = $inicio;
             while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
             $fcheckout = $XROWRES[7];
             $checkout = date("Y-m-d",strtotime($fcheckout));
             
          //  if ($xi < $tampag) {
              if ($checkout==$fecha_actual)
                         $color = "#FF0000"; //si el resto de la división es 0 pongo un color
            //       $color = $XROWRES[9];
              else
      	                $color = "#33658a";
              //	$XCODIGO=retornar_codigo(10,$XROWRES[0]);
				$cedula="'".$XROWRES[3]."'";
				$numhab = "'".$XROWRES[1]."'";
				$XCODIGO ="'".$XROWRES[0]."'";
				$nombre = "'".$XROWRES[4]."'";
				$statusid = '10';
				echo'<tr style="background-color:'.$color.'">
    	        	<td class="Txtmenu">' . $XROWRES[0].'</td>
        	    	<td class="Txtmenu">
						'.$XROWRES[1].'
					</td>
  	 	              	 <td class="Txtmenu">'.$XROWRES[6].'</td>
    	   	       	<td class="Txtmenu">'.$XROWRES[7].'</td>
    	   	       		<td class="Txtmenu">'.$XROWRES[8].'</td>';
                   echo '<td> <a class="checkin-img" onclick="Prcmostrarcheckout('.$XCODIGO.','.$statusid.','.$numhab.')" style="cursor:pointer"><img src="assets/images/modificar.png"  alt=""></a></td>
        	   	</td> ';
                   echo '<td> <a class="checkin-img" onclick="printfactura('.$XCODIGO.')" style="cursor:pointer"><img src="assets/images/printer.png"  alt=""></a></td>
        	   	</td> ';
                   echo '<td style="background-color:#ffcc33"> <a class="checkin-img" onclick="Prcmuestraabonos
                   ('.$XCODIGO.','.$cedula.','.$numhab.','.$nombre.')" style="cursor:pointer"><img src="assets/images/pago.png"  alt=""></a></td>
        	   	</td> ';

                  echo ' </tr>';
        	   	$XNUMFILA++;
        	//   	$xi++;
              	}


// finaliza busqueda de reservas creadas

 			?>
      	</table><img src="" alt="">
          	</div>
        
      </article>

  </div>

</div>
     <script  src="js/index.js"></script>
</body>
