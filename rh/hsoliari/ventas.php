<?

include_once 'includes/configpagos.inc.php';
include_once 'pagos/application/config/config.php';
include_once 'pagos/application/controllers/sales.php';
include_once 'pagos/application/models/Sale.php';
include_once 'pagos/application/controllers/invoices.php';
include_once 'pagos/application/helpers/ln_helper.php';



 $register = '16';
 $view = 'sale';
 $waiters = '1';




function label($label) {
   $lb = 'spanish';
   if($lb) {
      return $lb;
   } else {
      return $label;
   }
}

?>

<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
    <!-- normalize & reset style -->
    <link rel="stylesheet" href="pagos/assets/css/normalize.min.css"  type='text/css'>
    <link rel="stylesheet" href="pagos/assets/css/reset.min.css"  type='text/css'>
    <!-- Bootstrap Core CSS -->
    <link href="pagos/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="pagos/assets/css/Style-Light.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="pagos/favicon.ico" type="image/x-icon">
    <link rel="icon" href="pagos/favicon.ico" type="image/x-icon">
   <title>Hotel Soliari</title>
      <!-- jQuery -->
      <script type="text/javascript" src="pagos/assets/js/jquery-2.2.2.min.js"></script>
      <script type="text/javascript" src="pagos/assets/js/loading.js"></script>
      <!-- normalize & reset style -->
      <link rel="stylesheet" href="pagos/assets/css/normalize.min.css"  type='text/css'>
      <link rel="stylesheet" href="pagos/assets/css/reset.min.css"  type='text/css'>
      <link rel="stylesheet" href="pagos/assets/css/jquery-ui.css"  type='text/css'>
      <!-- google lato/Kaushan/Pinyon fonts -->
      <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
      <!-- Bootstrap Core CSS -->
      <link href="pagos/assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- bootstrap-horizon -->
      <link href="pagos/assets/css/bootstrap-horizon.css" rel="stylesheet">
      <!-- datatable style -->
      <link href="<?php echo 'http://localhost/hsoliari/pagos/assets/datatables/css/dataTables.bootstrap.css' ?>" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" href="pagos/assets/css/font-awesome.min.css">
      <!-- include summernote css-->
      <link href="pagos/assets/css/summernote.css" rel="stylesheet">
      <!-- waves -->
      <link rel="stylesheet" href="pagos/assets/css/waves.min.css">
      <!-- daterangepicker -->
      <link rel="stylesheet" type="text/css" href="pagos/assets/css/daterangepicker.css" />
      <!-- css for the preview keyset extension -->
      <link href="pagos/assets/css/keyboard-previewkeyset.css" rel="stylesheet">
      <!-- keyboard widget style -->
      <link href="pagos/assets/css/keyboard.css" rel="stylesheet">
      <!-- Select 2 style -->
      <link href="pagos/assets/css/select2.min.css" rel="stylesheet">
      <!-- Sweet alert swal -->
      <link rel="stylesheet" type="text/css" href="pagos/assets/css/sweetalert.css">
      <!-- datepicker css -->
      <link rel="stylesheet" type="text/css" href="pagos/assets/css/bootstrap-datepicker.min.css">
      <!-- Custom CSS -->
      <link href="pagos/assets/css/Style-Light.css" rel="stylesheet">
      <!-- favicon -->
      <link rel="shortcut icon" href="pagos/favicon.ico?v=2" type="image/x-icon">
      <link rel="icon" href="pagos/favicon.ico?v=2" type="image/x-icon">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
 
</HEAD>
<BODY>


  <div class="container">

    <h3>Ventas</h3>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead class="thead-inverse">
        <tr>
          <th>Numero</th>
          <th>Cliente</th>
          <th>Cedula</th>
          <th>Habitacion</th>
          <th>Iva</th>
          <th>Descuento</th>
          <th>Total</th>
          <th>Usuario</th>
          <th>#Items</th>
          <th>Estado</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>


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
            "url": "<?php echo 'http://localhost/hsoliari/pagos/invoices/ajax_list' ?>",
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
      swal({   title: 'Seguro ?>',
      text: '<?=Borrar ?>',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: 'si',
      closeOnConfirm: false },
      function(){
         // ajax delete data to database
         $.ajax({
            url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/ajax_delete' ?>/"+id,
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
         swal('Borrar', 'Borrar registro', "success"); });
    }

    function showTicket(id){

      $.ajax({
          url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/ShowTicket' ?>/"+id,
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
          url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/showInvoice' ?>/"+id,
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
          url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/Edit_Ajax' ?>/"+id,
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
      var customerId = $('#customerSelect').val();
      var customer = $('#customerSelect option:selected').text();
      var Status = $('#changeStatus').val();

      $.ajax({
          url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/Update_Sale' ?>/"+id,
          data: {customer: customer, customerId: customerId, Status: Status},
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
       $.redirect('<?php echo 'http://localhost/hsoliari/pagos/pos/pdfreceipt' ?>/', { content: content });

    }

    function pdfinvoice(){


       var content = $('#printSectionInvoice').html();
       $.redirect('<?php echo 'http://localhost/hsoliari/pagos/pos/pdfreceipt'?>/', { content: content });

    }

var saleID;
    function payaments(id){
      saleID = id;
      $.ajax({
          url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/payaments' ?>/"+id,
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
         url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/Addpayament' ?>/"+type,
         type: "POST",
         data: {created_by: createdBy, paid: Paid, paidmethod: paidMethod, ccnum: ccnum, ccmonth: ccmonth, ccyear: ccyear, ccv: ccv, sale_id: saleID, waiter_id: waiterID},
         success: function(data)
         {
            $('#payementsSection').load("<?php echo 'http://localhost/hsoliari/pagos/invoices/payaments' ?>/"+saleID);
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
      swal("Registro requerido");
}

function deletepayement(id){
   $.ajax({
       url : "<?php echo 'http://localhost/hsoliari/pagos/invoices/deletepayement' ?>/"+id+"/"+saleID,
       type: "POST",
       success: function(data)
       {
          $('#payementsSection').load("<?php echo 'http://localhost/hsoliari/pagos/invoices/payaments' ?>/"+saleID);
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
          <h4 class="modal-title" id="ticket">Vale</h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="printSection">
              <!-- Ticket goes here -->
              <center><h1 style="color:#34495E">Vacio</h1></center>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-add hiddenpr" href="javascript:void(0)" onClick="pdfreceipt()">PDF</button>
          <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()">Imprimir</button>
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
          <h4 class="modal-title" id="invoice">Factura</h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="printSectionInvoice">
              <!-- Invoice goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-add hiddenpr" href="javascript:void(0)" onClick="pdfinvoice()">PDF</button>
          <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()">Imprimir</button>
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
          <h4 class="modal-title" id="edit">Editar</h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="editSection">
             <!-- edit goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-add hiddenpr" onclick="update_Sale()">Enviar</button>
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
          <h4 class="modal-title" id="edit">Pagos</h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="payementsSection">
             <!-- payements goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal" onclick="reload_table();">Cerrar</button>
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
          <h4 class="modal-title" id="Addpayament">Adicione Pagos</h4>
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
                 <option value="1">Tarjeta de credito</option>
                 <option value="2">Cargo a Cuenta/Hab</option>
              </select>
             </div>
             <div class="form-group col-md-6">
                <label for="WaiterName">Camarero </label>
                <select class="js-select-options form-control" id="WaiterName">
                   <option value="0">Sin Camarero</option>
                   <?php foreach ($waiters as $waiter):?>
                      <option value="<?=$waiter->id;?>"><?=$waiter->name;?></option>
                   <?php endforeach;?>
                </select>
             </div>
             <div class="form-group Paid">
               <label for="Paid">Pagado</label>
               <input type="text" value="0" name="paid" class="form-control <?=strval($this->setting->keyboard) === '1' ? 'paidk' : ''?>" id="Paid" placeholder="<?=label("Paid");?>">
             </div>
             <div class="form-group CreditCardNum">
               <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
               <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
               <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
               <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
               <label for="CreditCardNum">Numero Tarjeta credito</label>
               <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="Numero Tarjeta Credito">
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
               <input type="text" class="form-control" id="CreditCardCODECV" placeholder="Codico CCV">
             </div>
             <div class="form-group ChequeNum">
               <label for="ChequeNum"><?=label("ChequeNum");?></label>
               <input type="text" name="chequenum" class="form-control" id="ChequeNum" placeholder="Numero Habitacion">
             </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <?=strval($this->setting->stripe) === '1' ? '<button type="button" class="btn btn-add stripe-btn" onclick="AddPayement(2)"><i class="fa fa-cc-stripe" aria-hidden="true"></i> '.label("StripePayment").'</button>' : ''; ?>
          <button type="button" class="btn btn-add" onclick="AddPayement(1)">Enviar</button>
        </div>
     <?php echo form_close(); ?>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

       <!-- jQuery -->
      <script type="text/javascript" src="http://localhost/hsoliari/pagos/assets/js/jquery-2.2.2.min.js"></script>
      <!-- waves material design effect -->
      <script type="text/javascript" src="http://localhost/hsoliari/pagos/assets/js/waves.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script type="text/javascript" src="http://localhost/hsoliari/pagos/assets/js/bootstrap.min.js"></script>

      <script type="text/javascript">
      $(document).ready(function() {
         $('#login-modal').modal('show').on('hide.bs.modal', function (e) {
            e.preventDefault();
         });
      });
      </script>

</BODY>
</HTML>
