<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title> CHECKOUT </title>
      <!-- jQuery -->
      <script type="text/javascript" src="puntoventa/checkout/assets/js/jquery-2.2.2.min.js"></script>
      <script type="text/javascript" src="puntoventa/checkout/assets/js/loading.js"></script>
      <!-- normalize & reset style -->
      <link rel="stylesheet" href="puntoventa/checkout/assets/css/normalize.min.css"  type='text/css'>
      <link rel="stylesheet" href="puntoventa/checkout/assets/css/reset.min.css"  type='text/css'>
      <link rel="stylesheet" href="puntoventa/checkout/assets/css/jquery-ui.css"  type='text/css'>
      <!-- google lato/Kaushan/Pinyon fonts -->
      <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
      <!-- Bootstrap Core CSS -->
      <link href="puntoventa/checkout/assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- bootstrap-horizon -->
      <link href="puntoventa/checkout/assets/css/bootstrap-horizon.css" rel="stylesheet">
      <!-- datatable style -->
      <link href="puntoventa/checkout/assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" href="puntoventa/checkout/assets/css/font-awesome.min.css">
      <!-- include summernote css-->
      <link href="puntoventa/checkout/assets/css/summernote.css" rel="stylesheet">
      <!-- waves -->
      <link rel="stylesheet" href="puntoventa/checkout/assets/css/waves.min.css">
      <!-- daterangepicker -->
      <link rel="stylesheet" type="text/css" href="puntoventa/checkout/assets/css/daterangepicker.css" />
      <!-- css for the preview keyset extension -->
      <link href="puntoventa/checkout/assets/css/keyboard-previewkeyset.css" rel="stylesheet">
      <!-- keyboard widget style -->
      <link href="puntoventa/checkout/assets/css/keyboard.css" rel="stylesheet">
      <!-- Select 2 style -->
      <link href="<puntoventa/checkout/>assets/css/select2.min.css" rel="stylesheet">
      <!-- Sweet alert swal -->
      <link rel="stylesheet" type="text/css" href="puntoventa/checkout/assets/css/sweetalert.css">
      <!-- datepicker css -->
      <link rel="stylesheet" type="text/css" href="puntoventa/checkout/assets/css/bootstrap-datepicker.min.css">
      <!-- Custom CSS -->
      <link href="puntoventa/checkout/assets/css/Style-Light.css" rel="stylesheet">
      <!-- favicon -->
      <link rel="shortcut icon" href="puntoventa/checkout/favicon.ico?v=2" type="image/x-icon">
      <link rel="icon" href="puntoventa/checkout/favicon.ico?v=2" type="image/x-icon">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>



<?php


include_once 'application/views/classes/greservas.class.php';
include_once 'application/views/assets/funciones.php';


$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
	$application_folder = 'application';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  Mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// The PHP file extension
	// this global constant is deprecated.
	define('EXT', '.php');

	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));

	// Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


	// The path to the "application" folder
	if (is_dir($application_folder))
	{
		define('APPPATH', $application_folder.'/');
	}
	else
	{
		if ( ! is_dir(BASEPATH.$application_folder.'/'))
		{
			exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
		}

		define('APPPATH', BASEPATH.$application_folder.'/');
	}

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */



if(!empty($_POST["guardar"])) {

       $correcto = "";
       $setid = "001";


   if (($setid != "" ) && ( $_POST["entrada"] != "") && ($_POST['salida1'] != "") && $_POST["cedula1"] != "" && $_POST["cedula1"] != "0")
    {
        $flaq = 1;
       $secuencia="";
       $mens = "";
       $correcto = "true";
       $XOBJRES=new greservas;

       // si no hay reserva debo crear todo
       $idtercero1 = $_POST['idtercero1'];
        if (!isset($_POST['numres']) or ($_POST['numres'] == ""))
             $idtercero1 = "";
       // busco si selecciono un tercero
       $tercero = "";
       if (isset($_POST['tercero']))
          $tercero = trim($_POST['tercero']);
       if ( ($tercero != "") && ($tercero != "00001") && (!empty($tercero)) )
       {
          // busco el cliente
            $idtercero = $tercero;
          	$XRCLI=$XOBJRES->buscar_cliente($idtercero,$setid);
	        $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
            if (isset($XROWCLI[0]))
	           $idcliente =  $XROWCLI[0];
            else
               $idcliente = "";
       }
       else
       {

       // ingresa datos del tercero en la tabla tbl_tercero
       $tablater = "tbl_terceros";
       $campoter = "tbl_terceros.id_tercero";
       $filtro = " tbl_terceros.setid = '".$setid."'";
       $idtercero =   FncBuscarseq($tablater,$campoter,$filtro);

       $XINFOTER[0] =  $setid;
       $XINFOTER[1] = $idtercero;
       $XINFOTER[2] = $_POST['cedula1'];
       $XINFOTER[3] = $_POST['guestname'];
       $XINFOTER[4] = $_POST['guestemail'] ;
       $XINFOTER[5] = $_POST['guestphone'] ;
       $XINFOTER[6] =  $_POST['guestcountry'] ;

       $XRSTER=$XOBJRES->ingresar_tercero($XINFOTER);
	    if((!isset($XRSTER)) or ($XRSTER == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación del tercero... ".$XRSTER;
       }
       else {
          // ingresa datos del cliente en la tabla tbl_cliente
            $tablacliente = "tbl_clientes";
            $campocli = "tbl_clientes.id_cliente";
            $filtro = " tbl_clientes.setid = '".$setid."'";
            $idcliente =   FncBuscarseq($tablacliente,$campocli,$filtro);
            if (!isset($idcliente))
              $idcliente = "00001";

            $XINFOCLI[0] =  $setid;
            $XINFOCLI[1] = $idcliente;
            $XINFOCLI[2] = $idtercero;
            $XINFOCLI[3] = $_POST['asesorcom'];
            $XINFOCLI[4] = $_POST['referidopor'] ;
            $XINFOCLI[5] = $_POST['cedula1'] ;
            $XINFOCLI[6] =  $_POST['guestname'] ;
            $XINFOCLI[7] = $_POST['guestemail'] ;
            $XINFOCLI[8] = $_POST['guestphone'] ;
            $XINFOCLI[9] =  $_POST['guestcountry'] ;

            $XRSCLI=$XOBJRES->ingresar_cliente($XINFOCLI);
            if((!isset($XRSCLI)) or ($XRSCLI == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación del Cliente... ".$XRSCLI;
            }
         }
        }

        if ($correcto == "true")
        {

              // INSERTA RESERVA
             $tablareserva = "tbl_reservas";
            $camporeserva = "tbl_reservas.id_reserva";
            $filtro = " tbl_reservas.setid = '".$setid."'";
            $idreserva =   FncBuscarseq($tablareserva,$camporeserva,$filtro);

            $numnoches = restar_fechas($_POST['entrada'] , $_POST['salida1']);
            if ($numnoches == 0)
               $numnoches = 1;
            $origen = "ERP";

            $XINFOPRE[0] = $setid;
            $XINFOPRE[1] = $idreserva;
            $XINFOPRE[2] = $idtercero;
            $XINFOPRE[3] = $_POST['fechareserva'];
            $XINFOPRE[4] = $numnoches;
	        $XINFOPRE[5] = $_POST['guestadult'];
	        $XINFOPRE[6] = $_POST['guestchild'];
	        $XINFOPRE[7] = "1";
	        $XINFOPRE[8] = $_POST['amount'];
            $XINFOPRE[9] = $_POST['estadores'];
	        $XINFOPRE[10] = $origen;
	        $XINFOPRE[11] = $_POST['deposit'];
            $XINFOPRE[12] = $idcliente;
            $XRSPRE=$XOBJRES->ingresar_prereserva($XINFOPRE);
	       if((!isset($XRSPRE)) or ($XRSPRE == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación de la reserva... ".$XRSPRE;
            }
            else {
                 if (!isset($_POST['tipotarifa']))
                    $tipotarifa = "";
                 else
                    $tipotarifa = $_POST['tipotarifa'];
                 if (!isset($_POST['habit']))
                    $_POST['habit'] = "";

                // inserto el detalle de la reserva  en tbl_det_reserva
                 $XINFODETR[0] = $setid;
                 $XINFODETR[1] = $idreserva;
                 $XINFODETR[2] = $_POST['entrada'];
                 $XINFODETR[3] = $_POST['salida1'];
                 $XINFODETR[4] = $tipotarifa;
                 $XINFODETR[5] = $_POST['guestadult'];
                 $XINFODETR[6] = $_POST['guestchild'];
                 $XINFODETR[7] = "";
                 $XINFODETR[8] = $_POST['habit'];
                 $XINFODETR[9] = $_POST['estadores'];
                 $cantpers = $_POST['guestadult'] + $_POST['guestchild'];
                 $XINFODETR[10] = $cantpers;
                 $numhab1 = $_POST['habit'] . " " . $_POST['numhab'];

                 $XRSDETPRE=$XOBJRES->ingresar_detalle_prereserva($XINFODETR);
                  if((!isset($XRSDETPRE)) or ($XRSDETPRE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación del detalle de la reserva... ".$XRSDETPRE;
                  }

                   // inserto el detalle del Abono en tbl_abonos_reservas
                 $XINFODETABONO[0] = $setid;
                 $XINFODETABONO[1] = $idreserva;
                 $tablaabono = "tbl_abonos_reservas";
                 $campoabono = "tbl_abonos_reservas.seq_abono";
                 $filtro = " tbl_abonos_reservas.setid = '".$_POST['setid']."' and tbl_abonos_reservas.id_reserva = '" . $idreserva . "'";
                 $seqabono =   FncBuscarseq($tablaabono,$campoabono,$filtro);

                 $XINFODETABONO[2] = $seqabono;
                 $XINFODETABONO[3] = $_POST['formapago'];
                 $XINFODETABONO[4] = $_POST['amount'];
                 $basepago = $_POST['deposit'] - $_POST['impuestos'];
                 $XINFODETABONO[5] = $basepago;
                 $XINFODETABONO[6] = $_POST['impuestos'];
                 $XINFODETABONO[7] = $idcliente;
                 $XINFODETABONO[8] = $idtercero;
                 $XINFODETABONO[9] = $_POST['balancedue'];
                 $XINFODETABONO[10] = $_POST['deposit'];

                 $XRSDETABONO=$XOBJRES->ingresar_detalle_abonos($XINFODETABONO);
                  if((!isset($XRSDETABONO)) or ($XRSDETABONO == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación del abono... ".$XRSDETABONO;
                  }

                     // inserto el detalle de la forma de pago del cliente
                 $tablaformapago = "tbl_forma_pago_cliente";
                 $campoformapago = "tbl_forma_pago_cliente.id_tipo_pago";
                 $filtro = " tbl_forma_pago_cliente.setid = '".$setid."' and tbl_forma_pago_cliente.id_tercero = '" . $idtercero . "'";
                 $idtipopago =   FncBuscarseq($tablaformapago,$campoformapago,$filtro);
                 if ((!isset($idtipopago)) or ($idtipopago == ""))
                    $idtipopago = "00001";
                 $XINFOFORMAPAGO[0] = $setid;
                 $XINFOFORMAPAGO[1] = $idtercero;
                 $XINFOFORMAPAGO[2] = $idtipopago;
                 $XINFOFORMAPAGO[3] = $idcliente;
                 $XINFOFORMAPAGO[4] = $_POST['numtarjeta'];
                 $XINFOFORMAPAGO[5] = $_POST['titular'];
                 $XINFOFORMAPAGO[6] = $_POST['mes'];
                 $XINFOFORMAPAGO[7] = $_POST['anno'];

                 $XRSFORMAPAGO=$XOBJRES->ingresar_forma_pago($XINFOFORMAPAGO);
                  if((!isset($XRSFORMAPAGO)) or ($XRSFORMAPAGO == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la forma de pago... ".$XRSFORMAPAGO;
                  }

                 $correcto = "true";
                 $mensaje =  "Se ha registrado el Huesped en la Habitacion(es) Correctamente No.Checkin: $idreserva
                  No. Habitacion: $numhab1 " . $mens ;

                 // Actualizo la reserva con los datos de cedula, abonos y estado de la reserva
                 if (isset($_POST['calendarreserva']))
                 {
                       $cedula = $_POST['cedula1'];
                       $estadores = $_POST['estadores'];
                       $setid = $setid;
                       $idhab = $_POST['habit'];
                       $calendarreserva = $_POST['calendarreserva'];
                       if ($_POST['saldo'] == 0)
                           $estadores="12";
                       else
                          if ($_POST['deposito'] > 0)
                              $estadores = "11";
                          else
                              $estadores = "10";

                      $XACTCALENDAR=$XOBJRES->actualiza_reserva($calendarreserva, $cedula, $estadores, $setid, $idtercero, $idhab);
                      if((!isset($XACTCALENDAR)) or ($XACTCALENDAR == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la actualizacion de la reserva... ".$XACTCALENDAR;
                       }

                 }


		 // ingreso el acompañante en la tabla de tercero  y tabla clientes

                    $conn = mysqli_connect("localhost","root","", "hembajada");
                    
                     // inserto cliente en posrestaurante para consumo
                       $queryposres = "INSERT INTO zarest_customers (name, numdocu, email , phone ) VALUES  ";
                      $queryValueposres = "('". $_POST['guestname'] . "', '" . $_POST['cedula1']  . "', '"
                      . $_POST['guestemail'] . "', '". $_POST['guestphone']  ."')";
                      $sqlposres = $queryposres.$queryValueposres;
                       $resultadoposres = mysqli_query($conn, $sqlposres);

                    // ahora si procedo insertar acompañanates y en posrestaaurnte
                    
                  	$contador = count($_POST['pro_docu']);
		            $ProContador=0;
		            $query = "INSERT INTO tbl_registro_huesped (setid, id_reserva, id_cliente, id_tercero) VALUES ";
        	        $querytercero = "INSERT INTO tbl_terceros (setid,id_tercero,nombres, numdoc, email,celular) VALUES ";
        	        $querycliente = "INSERT INTO tbl_clientes (setid, id_cliente, id_tercero,nombrecliente, numero_documento,
                    email, telefono, id_asesor, id_referidopor ) VALUES  ";


		            $queryValue = "";
	                $queryValueter = "";
                    $queryValuecli = "";
                    $queryValueposres = "";

		         for($i=0;$i<$contador;$i++) {
                   	if(!empty($_POST["pro_nom"][$i]) || !empty($_POST["pro_docu"][$i]) || !empty($_POST["pro_email"][$i])) {
                      $ProContador++;
                    // valida si ya selecciono un tercero sino se inserta
                        if (empty($_POST["pro_tercero"][$i]))   {
				    // busca secuencia para ingresar datos del tercero en la tabla tbl_tercero
                     $tablater = "tbl_terceros";
                     $campoter = "tbl_terceros.id_tercero";
                     $filtro = " tbl_terceros.setid = '".$setid."'";
                     $idterh =   FncBuscarseq($tablater,$campoter,$filtro);

                      // busca secuencia para ingresar datos del cliente en la tabla tbl_cliente
                      $tablacliente = "tbl_clientes";
                      $campocli = "tbl_clientes.id_cliente";
                      $filtro = " tbl_clientes.setid = '".$setid."'";
                      $idcli =   FncBuscarseq($tablacliente,$campocli,$filtro);

				    $queryValueter = "('". $setid."', '". $idterh."', '". $_POST["pro_nom"][$i] . "', '" .
                    $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone'] ."')";
                    $queryValuecli = "('". $setid."', '". $idcli ."', '". $idterh."', '". $_POST["pro_nom"][$i] . "', '" .
                    $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone'] . "', '". $_POST['asesorcom'] . "', '".
                    $_POST['referidopor'] ."')";
                    $queryValueposres = "('". $_POST["pro_nom"][$i] . "', '" . $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone']  ."')";


                    $sqlter = $querytercero.$queryValueter;
       	            $sqlcli = $querycliente.$queryValuecli;
       	            $sqlposres = $queryposres.$queryValueposres;


                    $resultadoconter = mysqli_query($conn, $sqlter);
                    $resultadoconcli = mysqli_query($conn, $sqlcli);
                     $resultadoposres = mysqli_query($conn, $sqlposres);

                    }
                      else
                      {
                       // busco el cliente
                            $idterh = $_POST["pro_tercero"][$i];
                             $setid = $setid;
          	                 $XRCLI=$XOBJRES->buscar_cliente($idterh,$setid);
	                          $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
                              if (isset($XROWCLI[0]))
	                             $idcli =  $XROWCLI[0];
                              else
                                  $idcli = "";
                      }
                    
                    
                    $queryValue = "('". $setid."', '".$idreserva. "', '". $idcli ."', '". $idterh."' ".")";
                   	$sql = $query.$queryValue;
                    $resultadocon = mysqli_query($conn, $sql);



			     }
		         }
		$sql = $query.$queryValue;
        $sqlter = $querytercero.$queryValueter;
       	$sqlcli = $querycliente.$queryValuecli;
         if($ProContador!=0) {
			if(!empty($resultadocon)) $mensaje = $mensaje ."
             <br>Registro(s) de Acompañante(s) Agregado Correctamente.";
             
          // ingreso al cliente en posrestaurante para que pueda hacer consumos

		}

       
       }
	
	   }
        }
        else {
           $mensaje = "Fechas de Entrada y Salida y Cedula son obligatorios";
         }
         
          $disp = '
           <div class="row">
          <div class="detalle">
           <br>
              <br>
                 <label > Se realiz&oacute; el Checkin del usuario </label>
                 Resultado: '.$mensaje.'
                 </div></div> ';

}

?>


<body>
<header> 
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

   <div class="logo">
       <a href="index2.php"><img src="assets/images/logo.jpg" alt=""></a>
    </div>

      <div class="menu-a">
          <a href="buscar_reservas.php">Retornar</a>
      <a href="index2.php">Menu Principal</a>
      <a href="home.php">Disponibilidad de Habitaciones</a>
      </div>


  </nav>
</header>



<!-- Fin container -->
<footer class="footer">
  <div class="container"> <span class="text-muted">
    <p>Deshida SAS <a href="https://deshida.com.co" target="_blank">Deshida SAS</a></p>
    </span> </div>
</footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
