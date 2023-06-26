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

?>

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


  <div class="container">

    <h3>Ventas</h3>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead class="thead-inverse">
        <tr>
          <th>#Fact</th>
          <th>Cliente</th>
          <th>Cedula</th>
          <th>Hab.</th>
          <th>Iva</th>
          <th>Descuento</th>
          <th>Total</th>
          <th>Creado Por</th>
          <th>Items</th>
          <th>Estatus</th>
          <th>Accion</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
<?php
   	$XOBJRES=new greservas;
   	$filtros = "";

    $XRSRES=$XOBJRES->buscar_sales($filtros);
    while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){



  <script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('ajax_listsale.php')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],
         "bInfo": false,
         // "fnRowCallback": function(nRow, aData, iDisplayIndex) {
         //     nRow.setAttribute('data-order',aData[4]);
         // }
      });
    });


    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }

    function delete_invoice(id)
    {
      swal({   title: '<?=label("Areyousure");?>',
      text: '<?=label("Deletemessage");?>',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: '<?=label("yesiam");?>',
      closeOnConfirm: false },
      function(){
         // ajax delete data to database
         $.ajax({
            url : "<?php echo site_url('invoices/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               alert('Error adding / update data');
            }
         });
         swal('<?=label("Deleted");?>', '<?=label("Deletedmessage");?>', "success"); });
    }

    function showTicket(id){

      $.ajax({
          url : "<?php echo site_url('invoices/ShowTicket')?>/"+id,
          type: "POST",
          success: function(data)
          {
              $('#printSection').html(data);
              $('#ticket').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };

    function showInvoice(id){

      $.ajax({
          url : "<?php echo site_url('invoices/showInvoice')?>/"+id,
          type: "POST",
          success: function(data)
          {
              $('#printSectionInvoice').html(data);
              $('#invoice').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };

    function Edit_Sale(id){

      $.ajax({
          url : "<?php echo site_url('invoices/Edit_Ajax')?>/"+id,
          type: "POST",
          success: function(data)
          {
              $('#editSection').html(data);
              $('#Edit').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };

    function update_Sale(){
      var id = $('#ClientId').val();
      var subtotal = $('#customerSelect').val();
      var tax = $('#changeStatus').val();
      var total = $('#total').val();

      $.ajax({
          url : "<?php echo site_url('invoices/Update_Sale')?>/"+id,
          data: {subtotal: subtotal, tax: tax, total: total},
          type: "POST",
          success: function(data)
          {
              reload_table();
              $('#Edit').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };

    function PrintTicket() {
       $('.modal-body').removeAttr('id');
       window.print();
       $('.modal-body').attr('id', 'modal-body');
    }

    function pdfreceipt(){


       var content = $('#printSection').html();
       $.redirect('<?php echo site_url('pos/pdfreceipt')?>/', { content: content });

    }

    function pdfinvoice(){


       var content = $('#printSectionInvoice').html();
       $.redirect('<?php echo site_url('pos/pdfreceipt')?>/', { content: content });

    }

var saleID;
    function payaments(id){
      saleID = id;
      $.ajax({
          url : "<?php echo site_url('invoices/payaments')?>/"+id,
          type: "POST",
          success: function(data)
          {
              $('#payementsSection').html(data);
              $('#payements').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };

    function AddPayement(type){
      var createdBy = '<?php echo $this->user->firstname." ".$this->user->lastname;?>';
      var Paid = $('#Paid').val();
      var ccnum = $('#CreditCardNum').val();
      var ccmonth = $('#CreditCardMonth').val();
      var ccyear = $('#CreditCardYear').val();
      var ccv = $('#CreditCardCODECV').val();
      var waiterID = $('#WaiterName').find('option:selected').val();
      var paidMethod = $('#paymentMethod').find('option:selected').val();
      switch(paidMethod) {
          case '1':
              paidMethod += '~'+$('#CreditCardNum').val()+'~'+$('#CreditCardHold').val();
              break;
          case '2':
              paidMethod += '~'+$('#ChequeNum').val();
      }

     $.ajax({
         url : "<?php echo site_url('invoices/Addpayament')?>/"+type,
         type: "POST",
         data: {created_by: createdBy, paid: Paid, paidmethod: paidMethod, ccnum: ccnum, ccmonth: ccmonth, ccyear: ccyear, ccv: ccv, sale_id: saleID, waiter_id: waiterID},
         success: function(data)
         {
            $('#payementsSection').load("<?php echo site_url('invoices/payaments')?>/"+saleID);
            $('#Addpayament').modal('hide');
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
            alert("error");
         }
     });

     $('#CreditCardNum').val('');
     $('#CreditCardHold').val('');
     $('#CreditCardYear').val('');
     $('#CreditCardMonth').val('');
     $('#CreditCardCODECV').val('');
   }

   $(document).ready(function() {
      $('.Paid').show();
      $('.ReturnChange').show();
      $('.CreditCardNum').hide();
      $('.CreditCardHold').hide();
      $('.ChequeNum').hide();
      $('.stripe-btn').hide();

      $("#paymentMethod").change(function(){
         var p_met = $(this).find('option:selected').val();
         if (p_met === '0') {
            $('.Paid').show();
            $('.ReturnChange').show();
            $('.CreditCardNum').hide();
            $('.CreditCardHold').hide();
            $('.CreditCardMonth').hide();
            $('.CreditCardYear').hide();
            $('.CreditCardCODECV').hide();
            $('#CreditCardNum').val('');
            $('#CreditCardHold').val('');
            $('#CreditCardYear').val('');
            $('#CreditCardMonth').val('');
            $('#CreditCardCODECV').val('');
            $('.stripe-btn').hide();
            $('.ChequeNum').hide();
         } else if (p_met === '1') {
            $('.Paid').show();
            $('.ReturnChange').hide();
            $('.CreditCardNum').show();
            $('.CreditCardHold').show();
            $('.CreditCardMonth').show();
            $('.CreditCardYear').show();
            $('.CreditCardCODECV').show();
            $('.stripe-btn').show();
            $('.ChequeNum').hide();
         } else if (p_met === '2') {
            $('.Paid').show();
            $('.ReturnChange').hide();
            $('.CreditCardNum').hide();
            $('.CreditCardHold').hide();
            $('.CreditCardMonth').hide();
            $('.CreditCardYear').hide();
            $('.CreditCardCODECV').hide();
            $('#CreditCardNum').val('');
            $('#CreditCardHold').val('');
            $('#CreditCardYear').val('');
            $('#CreditCardMonth').val('');
            $('#CreditCardCODECV').val('');
            $('.stripe-btn').hide();
            $('.ChequeNum').show();
         }
      });

      /********************************* Credit Card infos section ****************************************/
      $('#CreditCardNum').validateCreditCard(function(result) {
         var cardtype = result.card_type == null ? '-' : result.card_type.name;
         $('.CreditCardNum i').removeClass('dark-blue');
         $('#' + cardtype).addClass('dark-blue');
      });

      $('#CreditCardNum').keypress(function (e) {
         var data = $(this).val();
         if(data.length > 22){

          if (e.keyCode == 13) {
              e.preventDefault();

              var c = new SwipeParserObj(data);

                  $('#CreditCardNum').val(c.account);
                  $('#CreditCardHold').val(c.account_name);
                  $('#CreditCardYear').val(c.exp_year);
                  $('#CreditCardMonth').val(c.exp_month);
                  $('#CreditCardCODECV').val('');

              }
              else {
                  $('#CreditCardNum').val('');
                  $('#CreditCardHold').val('');
                  $('#CreditCardYear').val('');
                  $('#CreditCardMonth').val('');
                  $('#CreditCardCODECV').val('');
              }

              $('#CreditCardCODECV').focus();
              $('#CreditCardNum').validateCreditCard(function(result) {
                 var cardtype = result.card_type == null ? '-' : result.card_type.name;
                 $('.CreditCardNum i').removeClass('dark-blue');
                 $('#' + cardtype).addClass('dark-blue');
              });
      }

      });
});

function addpymntBtn(){
   if(<?=$register ? 'true' : 'false';?>)
     $('#Addpayament').modal('show');
  else
      swal("<?=label("requiresRegister");?>");
}

function deletepayement(id){
   $.ajax({
       url : "<?php echo site_url('invoices/deletepayement')?>/"+id+"/"+saleID,
       type: "POST",
       success: function(data)
       {
          $('#payementsSection').load("<?php echo site_url('invoices/payaments')?>/"+saleID);
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}


  </script>


  <!-- Modal ticket -->
  <div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="ticketModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="ticket"><?=label("Receipt");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="printSection">
              <!-- Ticket goes here -->
              <center><h1 style="color:#34495E"><?=label("empty");?></h1></center>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" href="javascript:void(0)" onClick="pdfreceipt()">PDF</button>
          <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?=label("print");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal invoice -->
  <div class="modal fade" id="invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document" id="invoiceModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="invoice"><?=label("INVOICE");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="printSectionInvoice">
              <!-- Invoice goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" href="javascript:void(0)" onClick="pdfinvoice()">PDF</button>
          <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?=label("print");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal edit -->
  <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="editModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="edit"><?=label("Edit");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="editSection">
             <!-- edit goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" onclick="update_Sale()"><?=label("Submit");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal payements -->
  <div class="modal fade" id="payements" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="payementsModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="edit"><?=label("Payements");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="payementsSection">
             <!-- payements goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal" onclick="reload_table();"><?=label("Close");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->


  <!-- Modal Add payament -->
  <div class="modal fade" id="Addpayament" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="Addpayament"><?=label("AddPayements");?></h4>
        </div>
        <form>
        <div class="modal-body">
             <div class="form-group">
               <h2 id="TotalModal"></h2>
            </div>
             <div class="form-group col-md-6">
               <label for="paymentMethod"><?=label("paymentMethod");?></label>
               <select class="js-select-options form-control" id="paymentMethod">
                 <option value="0"><?=label("Cash");?></option>
                 <option value="1"><?=label("CreditCard");?></option>
                 <option value="2"><?=label("Cheque");?></option>
              </select>
             </div>
             <div class="form-group col-md-6">
                <label for="WaiterName"><?=label("WaiterName");?>: </label>
                <select class="js-select-options form-control" id="WaiterName">
                   <option value="0"><?=label("withoutWaiter");?></option>
                   <?php foreach ($waiters as $waiter):?>
                      <option value="<?=$waiter->id;?>"><?=$waiter->name;?></option>
                   <?php endforeach;?>
                </select>
             </div>
             <div class="form-group Paid">
               <label for="Paid"><?=label("Paid");?></label>
               <input type="text" value="0" name="paid" class="form-control <?=strval($this->setting->keyboard) === '1' ? 'paidk' : ''?>" id="Paid" placeholder="<?=label("Paid");?>">
             </div>
             <div class="form-group CreditCardNum">
               <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
               <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
               <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
               <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
               <label for="CreditCardNum"><?=label("CreditCardNum");?></label>
               <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="<?=label("CreditCardNum");?>">
             </div>
             <div class="clearfix"></div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardHold" placeholder="<?=label("CreditCardHold");?>">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardMonth" placeholder="<?=label("Month");?>">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardYear" placeholder="<?=label("Year");?>">
             </div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardCODECV" placeholder="<?=label("CODECV");?>">
             </div>
             <div class="form-group ChequeNum">
               <label for="ChequeNum"><?=label("ChequeNum");?></label>
               <input type="text" name="chequenum" class="form-control" id="ChequeNum" placeholder="<?=label("ChequeNum");?>">
             </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
          <?=strval($this->setting->stripe) === '1' ? '<button type="button" class="btn btn-add stripe-btn" onclick="AddPayement(2)"><i class="fa fa-cc-stripe" aria-hidden="true"></i> '.label("StripePayment").'</button>' : ''; ?>
          <button type="button" class="btn btn-add" onclick="AddPayement(1)"><?=label("Submit");?></button>
        </div>
     <?php echo form_close(); ?>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

<?
    public function showInvoice($id)
    {
        $sale = Sale::find($id);
        $posales = Sale_item::find('all', array(
            'conditions' => array(
                'sale_id = ?',
                $id
            )
        ));
        $client = Customer::find('first', array(
            'conditions' => array(
                'id = ?',
                $sale->client_id
            )
        ));
        $ClientData = $client ? 'Customer: ' . $client->name . '<br>' . $client->phone . '<br>' . $client->email : label('WalkinCustomer');

        $ticket = '<div class="col-sm-12"><table width="100%"><tr><td align="left"><span class="float-left">' . $this->setting->companyname . '<br>' . label("Tel") . ' ' . $this->setting->phone . '</span></td><td align="right"><img src="files/Setting/' . $this->setting->logo . '" alt="" width="100px" Style="margin:15px;float:right;"/></td></tr></table></div><div style="clear:both;"></div><h4 class="float-left">#' . sprintf("%05d", $sale->id) . '</h4> <div style="clear:both;"></div><span style="font-size:40px;font-weight:600;padding:5px;background-color:#415472;color:#fff;">' . label("INVOICE") . '</span><br><br><br><div style="clear:both;"></div><table width="100%"><tr><td align="left"><span class="float-left">' . label("Date") . ': ' . $sale->created_at->format('d-m-Y') . '</span></td><td align="right"><span Style="margin-bottom:15px;float:right;width:100%;text-align:right">' . $ClientData . '</span></td></tr></table><div style="clear:both;"></div><div style="clear:both;"></div><table class="table" cellspacing="0" border="0"><thead><tr style="background-color:#555;color:#fff;font-weight:600"><th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") . '</th></tr></thead><tbody>';

        $i = 1;
        foreach ($posales as $posale) {
            $ticket .= '<tr><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' . $posale->name . '</td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
            $i ++;
        }

        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $ticket .= '</tbody></table><div class="col-xs-4  col-xs-offset-8"><table class="table table-striped" cellspacing="0" border="0" style="margin:20px 0 30px 0;"><thead><tr><td style="text-align:left; padding:3px;">' . label("TotalItems") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . $sale->totalitems . '</td></tr></thead><tbody><tr><td style="text-align:left; padding:3px;">' . label("Total") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . number_format((float)$sale->subtotal, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';

        if (intval($sale->discount))
            $ticket .= '<tr><td style="text-align:left; padding:3px;">' . label("Discount") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . $sale->discount . '</td></tr>';
        if (intval($sale->tax))
            $ticket .= '<tr><td style="text-align:left; padding:3px; padding-left:1.5%;">' . label("tax") . '</td><td style="text-align:right; padding:3px;font-weight:bold;">' . $sale->tax . '</td></tr>';
        $ticket .= '<tr style="background-color:#415472;color:#fff;font-weight:600;font-size:20px"><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sale->total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr><tr>';

        $PayMethode = explode('~', $sale->paidmethod);
        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCard") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">xxxx xxxx xxxx ' . substr($PayMethode[1], - 4) . '</td></tr><tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCardHold") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td></tr></tbody></table></div>';
                break;
            case '2': // case ckeck
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("ChequeNum") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[1] . '</td></tr></tbody></table></div>';
                break;
            default:
                $ticket .= '</tbody></table></div>';
        }
        $ticket .= '<div class="text-center" style="clear:both;padding-bottom:10px; padding-top:10px; width:100%; background-color:#eee"><span style="font-size:9px;text-transform:uppercase;letter-spacing: 4px;">' . $this->setting->companyname . '<br>' . $this->setting->phone . '</span></div>';

        echo $ticket;
    }
?>
