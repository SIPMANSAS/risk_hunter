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

?>

  <!-- Modal Add payament -->
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="Addpayament">Adicionar Abono</h4>
        </div>
        <form>
        <div class="modal-body">
             <div class="form-group">
               <h2 id="TotalModal"></h2>
            </div>
             <div class="form-group col-md-6">
               <label for="paymentMethod">Metodo de Pago</label>
               <select class="js-select-options form-control" id="paymentMethod">
                 <option value="0">Efectivo</option>
                 <option value="1">Tarjeta de Credito</option>
               </select>
             </div>
             <div class="form-group col-md-6">
                <label for="WaiterName">Asesor: </label>
                <select class="js-select-options form-control" id="WaiterName">
                   <option value="0">Sin Asesor</option>
                   <?php foreach ($waiters as $waiter):?>
                      <option value="0" Sin Asesor </option>
                   <?php endforeach;?>
                </select>
             </div>
             <div class="form-group Paid">
               <label for="Paid">Abono</label>
               <input type="text" value="0" name="paid" class="form-control
               id="Paid" placeholder="Pago">
             </div>
             <div class="form-group CreditCardNum">
               <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
               <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
               <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
               <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
               <label for="CreditCardNum">Tarjeta Credito</label>
               <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="Numero Tarjeta">
             </div>
             <div class="clearfix"></div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardHold" placeholder="Titular">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardMonth" placeholder="Mes">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardYear" placeholder="Anno">
             </div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardCODECV" placeholder="CCV">
             </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
         <button type="button" class="btn btn-add stripe-btn" onclick="AddPayement(2)">
           <button type="button" class="btn btn-add" onclick="AddPayement(1)">Enviar</button>
        </div>
     <?php echo form_close(); ?>
      </div>
   </div>
  <!-- /.Modal -->


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

