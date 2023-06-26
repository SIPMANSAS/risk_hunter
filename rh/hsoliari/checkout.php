<?php


include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';


/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
	define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;

		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
	$system_path = 'pagos/system';

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
	$application_folder = 'pagos/application';

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
// require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */


require_once (APPPATH . 'third_party/Stripe/Stripe.php');

class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();

		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
	
	 public function ResetPos()
    {
        Posale::delete_all(array(
            'conditions' => array(
                'status = ? AND register_id = ?',
                1,
                $this->register
            )
        ));
        echo json_encode(array(
            "status" => TRUE
        ));
    }
	
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */

function FncBuscarseq($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select lpad(($parametro + 1),5,'0') from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
           return $XNEXTSEQ[0];
}

function FncBuscarseq1($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select $parametro from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
          return $XNEXTSEQ[0];
}


function restar_fechas($fechaini, $fechafin) {
         if (isset($fechaini) and isset($fechafin)) {
            $segundos=strtotime($fechafin) - strtotime($fechaini);
            $diferencia_dias=intval($segundos/86400);
         }
         else
              $diferencia_dias = 0;
         return  $diferencia_dias;
}



?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Checkout</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
<link href="assets/css/styledynam.css" rel="stylesheet">
<link href="assets/css/pagos/Style-Light.css" rel="stylesheet">
<link href="assets/css/pagos/Style-Lightprint.css" type="text/css" media="print" />
<link href="assets/css/pagos/bootstrap.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap-horizon.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
 <script type="text/javascript" src="assets/js/gestion_reservas3.js" ></script>
   <!-- ajax form -->
      <script src="pagos/assets/js/jquery.form.min.js"></script>




</head>

<body>

<?php


// inicia el checkout
   $XOBJRES=new greservas;

if ( isset($_GET["cedula"])  and isset($_GET["numhab"]))
{
     $numhab = $_GET['numhab'];
     $cedula = $_GET['cedula'];
     $nombre = $_GET['nombre'];
     $idres = $_GET['idres'];

     $metpago = "2~".$numhab;
      $tablacustom = "zarest_customers";
       $campocust = "zarest_customers.id";
       $filtro = " zarest_customers.numdocu = '".$cedula."'";
       $idcust =   FncBuscarseq1($tablacustom,$campocust,$filtro);
        $store = '1';
        $tablaregister = "zarest_registers";
       $camporegister = "zarest_registers.id";
       $filtro = " zarest_registers.status = '1' and zarest_registers.store_id= '1' ";
       $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);
        $tablahold = "zarest_holds";
       $campohold = "zarest_holds.id";
       $filtro = " zarest_holds.table_id = '0' ";
       $idhold =   FncBuscarseq1($tablahold,$campohold,$filtro);
       $parametros = "customer_id = '$idcust', numhab = '$numhab'";
       $XACTCALENDAR=$XOBJRES->actualiza_hold($idhold,$parametros);

     $XRES=$XOBJRES->buscar_salescheckout($idcust,$metpago);
     $XSALES = $XOBJRES->obtener_fila($XRES);
     $XNUMFILA =  $XOBJRES->numero_filas($XRES);
     $idsale = $XSALES[0];
     $XI = 0;
     while($XI < $XNUMFILA)
     {

              // ingreso en posale
                  $XINFODETSALE[0] = $XSALES[1];
                  $XINFODETSALE[1] = $XSALES[2];
                  $XINFODETSALE[2] = $XSALES[3];
                  $XINFODETSALE[3] = $XSALES[4];
                  $XINFODETSALE[4] = '1';
                  $XINFODETSALE[5] = $idregister;
                  $XINFODETSALE[6] = '1';
                  $XINFODETSALE[7] = '0';
                  $XINFODETSALE[8] = date('Y-m-d');
                  $XINFODETSALE[9] = $XSALES[0];
                  $XINFODETSALE[10] = $XSALES[6];
          // despues de ingresar en possale debo borrar de sales los que tengan cargo a la habitacion
          // debo hacer un boton de generar factura  para crear una factura formal e insertar esa venta en una tabl de facturas


                 $XRSDETSALE=$XOBJRES->ingresar_posales($XINFODETSALE, $XI);
                  if((!isset($XRSDETSALE)) or ($XRSDETSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSDETSALE;
                  }
                  $XSALES = $XOBJRES->obtener_fila($XRES);
          $XI++;
       }

     //  echo '<a href="pagos/pos/selectTable/0/'.$idcust.'"> Esta seguro del Checkout? </a>';
       //   redirect('pagos/pos/selectTable/0/'.$idcust);
        //  header("Location: pagos/pos/selectTable/0/$idcust");
echo '
   <div class="container ">
      <div class="row">
         <h1 class="text-center choose_store"> Punto de Venta Alojamiento </h1>
      </div> </div>   ';

     echo '
        <div class="container-fluid">
   <div class="row text-center">
       <h3 style="font-family: Kaushan Script, cursive;">Checkout   Habitacion: '.$numhab.'

       </h3>
    </div>
   <div class="row">
      <ul class="cbp-vimenu2">
      	<li data-toggle="tooltip"  data-html="true" data-placement="left" title="Cancelar" onclick="cancelPOS()"><i class="fa fa-times" aria-hidden="true"></i></li>
       </ul>
      <div class="col-md-5 left-side">
         <div class="row">
            <div class="row row-horizon">
               <span class="holdList">
                  <!-- list Holds goes here -->
               </span>
               <span class="Hold pl" onclick="AddHold()">+</i></span>
               <span class="Hold pl" onclick="RemoveHold()">-</span>
            </div>
         </div>
         <div class="col-xs-8">
            <h2>Cliente</h2>
         </div>
         <div class="col-xs-4 client-add">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#AddCustomer">
               <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Adicionar Cliente">
                  <i class="fa fa-square fa-stack-2x grey"></i>
                  <i class="fa fa-user-plus fa-stack-1x fa-inverse dark-blue"></i>
               </span>
            </a>
            <a href="javascript:void(0)" onclick="showticket()">
               <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Ultima Factura">
                  <i class="fa fa-square fa-stack-2x grey"></i>
                  <i class="fa fa-ticket fa-stack-1x fa-inverse dark-blue"></i>
               </span>
            </a>
         </div>
         <div class="col-sm-6">
            <select class="js-select-options form-control" id="customerSelect">
               <option value="'.$idcust.'">'.$nombre.' / '.$cedula.'</option>
             </select>
            <span class="hidden" id="customerS"></span>
         </div>

';
        echo '
         <div class="col-xs-5 table-header">
            <h3> PRODUCTO </h3>
         </div>
         <div class="col-xs-2 table-header">
            <h3> PRECIO </h3>
         </div>
         <div class="col-xs-3 table-header nopadding">
            <h3 class="text-left">CANTIDAD</h3>
         </div>
         <div class="col-xs-2 table-header nopadding">
            <h3>TOTAL</h3>
         </div>  ';

          $XHAB=$XOBJRES->buscar_possales($idregister,"0");
          $moneda="COP";
        echo '  <div id="productList"></div>';
          $alert = 'background-color:pink';
           $decimales = "2";
         while($XHABRES=$XOBJRES->obtener_fila($XHAB))
         {
             $valor =   $XHABRES[2];
             $cantidad =  $XHABRES[3];
             $options = "Desayuno,Parqueadero";
             $total =  (int)$XHABRES[2] * (int)$XHABRES[3];
               $storeid = "0";
                $row = '<div class="col-xs-12"><div class="panel panel-default product-details">
                <div class="panel-body" style=""><div class="col-xs-5 nopadding">
                <div class="col-xs-2 nopadding"><a href="javascript:void(0)"
                onclick="delete_posale(' . "'" . $XHABRES[0] . "'" . ')">
                <span class="fa-stack fa-sm productD"><i class="fa fa-circle fa-stack-2x delete-product"></i>
                <i class="fa fa-times fa-stack-1x fa-fw fa-inverse"></i></span></a></div><div class="col-xs-10 nopadding">
                <span class="textPD">' . $XHABRES[1] . '</span></div></div><div class="col-xs-2"><span class="textPD">
                ' . number_format((float)$XHABRES[2], $decimales, '.', '') .
                '</span></div><div class="col-xs-3 nopadding productNum"><a href="javascript:void(0)">
                <span class="fa-stack fa-sm decbutton"><i class="fa fa-square fa-stack-2x light-grey"></i>
                <i class="fa fa-minus fa-stack-1x fa-inverse white"></i></span></a>
                <input type="text" id="qt-' . $XHABRES[0] . '" onchange="edit_posale(' . $XHABRES[0] . ')"
                class="form-control" value="' . $XHABRES[3] . '" placeholder="0" maxlength="3"><a href="javascript:void(0)">
                <span class="fa-stack fa-sm incbutton"><i class="fa fa-square fa-stack-2x light-grey"></i>
                <i class="fa fa-plus fa-stack-1x fa-inverse white"></i></span></a></div><div class="col-xs-2 nopadding ">
                <span class="subtotal textPD" id="sstot-' . $XHABRES[0] . '">' . number_format((float)$valor*$cantidad, $decimales, '.', '')
                 . '  ' . $moneda . '</span></div></div><button type="button"
                 onclick="addoptions('.$XHABRES[4].', '.$XHABRES[0].')" class="btn btn-success btn-xs">
                 Opciones</button> <span id="pooptions-'.$XHABRES[0].'"> '.$options.'</sapn></div></div>';
                echo $row;

         }
         echo ' <div class="col-xs-12"><div class="panel panel-default product-details">
                <div class="panel-body" style="'.$alert.'"><div class="col-xs-5 nopadding">
                <div class="col-xs-2 nopadding"><a href="javascript:void(0)">
                <span class="fa-stack fa-sm productD"><i class="fa fa-circle fa-stack-2x delete-product"></i>
                <i class="fa fa-times fa-stack-1x fa-fw fa-inverse"></i></span></a></div><div class="col-xs-10 nopadding">
                <span class="textPD"> Otros Cargos </span></div></div>

                <div class="col-xs-2"><span class="textPD1">
                 <input type="text" name="otroscargos" id="otcg" value="'. number_format((float)0, $decimales, '.', '') .
                '" onchange="edit_posale99()"></input></span></div>

                 <div class="col-xs-2 nopadding ">
                <span class="subtotal textPD" id="otcg1">' . number_format((float)0, $decimales, '.', '')
                 . '  ' . $moneda . '</span></div></div>';

?>
      <div class="footer-section">
            <div class="table-responsive col-sm-12 totalTab">
               <table class="table">
                  <tr>
                     <td class="active" width="40%">Subtotal</td>
<?php

    $XSUBTOT=$XOBJRES->buscar_sumposales($idregister,"0");
    $XSUBTOTAL=$XOBJRES->obtener_fila($XSUBTOT) ;
    $subtotal = $XSUBTOTAL[0];
    $totqt =  $XSUBTOTAL[1];
    $totiva = ($subtotal * 19) /100;
    $XSUBABON=$XOBJRES->buscar_sumpagos($idregister,$idsale);
    $XABONO=$XOBJRES->obtener_fila($XSUBABON) ;
    if (isset($XABONO[0])) {
    $totabonos =  $XABONO[0];
    $totitemabono =  $XABONO[1];
    }
    else
    {
        $totabonos =  0;
        $totitemabono =  0;
    }
    $grantotal = $subtotal + $totiva - $totabonos;
    setlocale(LC_MONETARY, 'en_US');


?>

                     <td class="whiteBg" width="60%"><span id="Subtot"><?php echo $subtotal; ?></span> COP
                        <span class="float-right"><b id="ItemsNum"><span><?php echo $totqt; ?></span> Items</b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active">IVA</td>
                     <td class="whiteBg"><input type="text" value="19%" onchange="total_change()"
                     id="num01" class="total-input TAX"
                     placeholder="N/A"  maxlength="8">
                        <span class="float-right"><b id="taxValue"><?php echo $totiva; ?> COP</b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active">Descuento</td>
                     <td class="whiteBg"><input type="text" value="0" onchange="total_change()"
                     id="num02" class="total-input Remise" placeholder="N/A"  maxlength="8">
                        <span class="float-right"><b id="RemiseValue"> COP</b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active">Abonos</td>
                     <td class="whiteBg" width="60%"><span id="abono"><?php echo $totabonos ?></span> COP
                        <span class="float-right"><b id="Itemabono"><span><?php echo $totitemabono; ?></span> Items</b></span>
                      </td>
                  </tr>
                  <tr>
                     <td class="active">Total</td>
                     <td class="whiteBg light-blue text-bold"><span id="total"><?php echo $grantotal; ?> </span>
                     COP</td>
                  </tr>
               </table>
            </div>
            <button type="button" onclick="cancelPOS()" class="btn btn-danger"><h5 class="text-bold">
            Cancelar</h5></button>
            <button type="button" class="btn btn-primary"
            onclick="Prcconfirmarcheckout('<?php echo $nombre; ?>' , '<?php echo $idcust; ?> ' , '<?php echo $totqt; ?> '
            , '<?php echo $grantotal; ?>' , '<?php echo $totabonos; ?>', '<?php echo $cedula; ?>', '<?php echo $numhab; ?>'
            , '<?php echo $idres; ?>' ,  '<?php echo $idsale; ?>'
            )">
            <h5 class="text-bold">Procesar Checkout</h5></button>

            
         </div>
         


<?php
}
?>
<script>

// function to calculate the total number
function total_change() {
   var tot;
   var iva;
   var dto;
   var total;
   iva = $('#num01').val();
   dto = $('#num02').val();

   tot =   (parseFloat($('#Subtot').text()) * parseInt(iva)) / parseInt(100) + 'COP';
    $('#taxValue').text(tot);
    if ($('#num02').val().indexOf('%') != -1)
      dto =   (parseFloat($('#Subtot').text()) * parseInt(dto)) / parseInt(100) + 'COP';
    else
      dto = $('#num02').val();
      $('#RemiseValue').text(dto);
     total =  parseFloat($('#Subtot').text()) + parseFloat($('#taxValue').text()) - parseFloat($('#RemiseValue').text()) - parseFloat($('#abono').text());
      $('#total').text(total);



}


function cancelPOS(){
     var url = "resetpos.php";
     $.ajax({
           type: "POST",
           url: url,
           data: $("#checkout").serialize(),
           success: function(data) {
               $('#total').text("0");
               $('#Subtot').text("0");
               $('#ItemsNum').text("0");
               $('#num02').val('0');
                 $('#num01').val('19%');

                alert("Fue Cancelado el Checkout. Se cerrará la ventana");
                window.close();
                  }
         });


};



function edit_posale(id)
{
   var qt1 = $('#qt-'+id).val();
   var sstot = $('#sstot-'+id).text();
   var sstotal = parseInt(sstot) * parseInt(qt1);
    $('#sstot-'+id).text(sstotal);
   var subtoto = $('#Subtot').text();
   var totsubt = (parseInt(subtoto) - parseInt(sstot)) + parseInt(sstotal);
    $('#Subtot').text(totsubt);
    var tot;
   var iva;
   var dto;
   var total;
   iva = $('#num01').val();
   dto = $('#num02').val();
   tot =   (parseFloat($('#Subtot').text()) * parseInt(iva)) / parseInt(100) + 'COP';
    $('#taxValue').text(tot);
    if ($('#num02').val().indexOf('%') != -1)
      dto =   (parseFloat($('#Subtot').text()) * parseInt(dto)) / parseInt(100) + 'COP';
    else
      dto = $('#num02').val();
      $('#RemiseValue').text(dto);
     total =  parseFloat($('#Subtot').text()) + parseFloat($('#taxValue').text()) - parseFloat($('#RemiseValue').text()) - parseFloat($('#abono').text());
      $('#total').text(total);

      var ttotitem = parseInt(qt1) + 1 ;
        ttotitem = ttotitem + 'Items';
        $('#ItemsNum').text(ttotitem);
      
   
}

function edit_posale99()
{
   var otcg = $('#otcg').val();
   alert ("Se agregan Cargos Adicionales al Checkout "+otcg);
    $('#otcg1').text(otcg);
   var subtoto = $('#Subtot').text();
   var totsubt = parseInt(subtoto) + parseInt(otcg);
   $('#Subtot').text(totsubt);
    var tot;
   var iva;
   var dto;
   var total;
   iva = $('#num01').val();
   dto = $('#num02').val();
   tot =   (parseFloat($('#Subtot').text()) * parseInt(iva)) / parseInt(100) + 'COP';
    $('#taxValue').text(tot);
    if ($('#num02').val().indexOf('%') != -1)
      dto =   (parseFloat($('#Subtot').text()) * parseInt(dto)) / parseInt(100) + 'COP';
    else
      dto = $('#num02').val();
      $('#RemiseValue').text(dto);
     total =  parseFloat($('#Subtot').text()) + parseFloat($('#taxValue').text()) - parseFloat($('#RemiseValue').text()) - parseFloat($('#abono').text());
      $('#total').text(total);
     var ttotitem = $('#ItemsNum').text();
     if (parseInt(otcg) > 0   )
     {
        ttotitem = parseInt(ttotitem) + 1;
        ttotitem = ttotitem + 'Items';
        $('#ItemsNum').text(ttotitem);
     }


}


</script>

