<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once (APPPATH . 'third_party/Stripe/Stripe.php');

class Pos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);
        $this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;
        $this->store = $this->session->userdata('store') ? $this->session->userdata('store') : FALSE;
        $this->selectedTable = $this->session->userdata('selectedTable') ? $this->session->userdata('selectedTable') : FALSE;

        $this->setting = Setting::find(1);
        date_default_timezone_set($this->setting->timezone);
    }



    public function addpdc()
    {
      $product = Sales::find($this->input->post('product_id'));
      $PostPrice = $this->input->post('total');
      $price = !$product->taxmethod || $product->taxmethod == '0' ? floatval($PostPrice) : floatval($PostPrice)*(1 + $product->taxamount / 100);
      /******************************************* sock version *************************************************************/
            $data = array(
                "product_id" => $this->input->post('product_id'),
                "name" => $this->input->post('name'),
                "price" => $price,
                "number" => $this->input->post('number'),
                "register_id" => $this->input->post('registerid'),
                "table_id" => $this->selectedTable,
                "qt" => 1,
                "status" => 1,
                "time" => date("Y-m-d H:i:s")
            );
            Posale::create($data);
            echo json_encode(array(
                "status" => TRUE
            ));


      if ($posale) {
          if($quantity > 0) {
           $posale->qt ++;
           $posale->time = date("Y-m-d H:i:s");
           $posale->save();
           echo json_encode(array(
               "status" => TRUE
           ));
      }

     }
    }

    public function load_posales()
    {
        $setting = Setting::find(1, array(
            'select' => 'currency'
        ));
        
            $posales = Posale::find('all', array(
            'conditions' => array(
                'status = ? AND register_id = ? AND table_id = ?',
                1,
                $this->register,
                $this->selectedTable
            )
        ));
        $data = '';
        if ($posales) {
            foreach ($posales as $posale) {
               $alertqt = Product::find($posale->product_id)->alertqt;
               $type = Product::find($posale->product_id)->type;
               $options = $posale->options;
               $options = trim($options, ",");
               $storeid = Register::find($this->register)->store_id;
               $alert = $type == '0' ? (Stock::find('first', array('conditions' => array('product_id = ? AND store_id = ?', $posale->product_id, $storeid)))->quantity - $posale->qt <= $alertqt ? 'background-color:pink' : '') : '';
 $row = '<div class="col-xs-12"><div class="panel panel-default product-details"><div class="panel-body" style="'.$alert.'"><div class="col-xs-5 nopadding"><div class="col-xs-2 nopadding"><a href="javascript:void(0)" onclick="delete_posale(' . "'" . $posale->id . "'" . ')"><span class="fa-stack fa-sm productD"><i class="fa fa-circle fa-stack-2x delete-product"></i><i class="fa fa-times fa-stack-1x fa-fw fa-inverse"></i></span></a></div><div class="col-xs-10 nopadding"><span class="textPD">' . $posale->name . '</span></div></div><div class="col-xs-2"><span class="textPD">' . number_format((float)$posale->price, $this->setting->decimals, '.', '') . '</span></div><div class="col-xs-3 nopadding productNum"><a href="javascript:void(0)"><span class="fa-stack fa-sm decbutton"><i class="fa fa-square fa-stack-2x light-grey"></i><i class="fa fa-minus fa-stack-1x fa-inverse white"></i></span></a><input type="text" id="qt-' . $posale->id . '" onchange="edit_posale(' . $posale->id . ')" class="form-control" value="' . $posale->qt . '" placeholder="0" maxlength="3"><a href="javascript:void(0)"><span class="fa-stack fa-sm incbutton"><i class="fa fa-square fa-stack-2x light-grey"></i><i class="fa fa-plus fa-stack-1x fa-inverse white"></i></span></a></div><div class="col-xs-2 nopadding "><span class="subtotal textPD">' . number_format((float)$posale->price*$posale->qt, $this->setting->decimals, '.', '') . '  ' . $setting->currency . '</span></div></div><button type="button" onclick="addoptions('.$posale->product_id.', '.$posale->id.')" class="btn btn-success btn-xs">'.label("Options").'</button> <span id="pooptions-'.$posale->id.'"> '.$options.'</sapn></div></div>';

                $data .= $row;
            }
            // adding script for the +/- buttons
            $data .= '<script type="text/javascript">$(".incbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();var newVal = parseFloat(oldValue) + 1;$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});$(".decbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();if (oldValue > 1) {var newVal = parseFloat(oldValue) - 1;} else {newVal = 1;}$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});</script>';
        } else {

            $data = '<div class="messageVide">' . label("EmptyList") . ' <span>(' . label("SelectProduct") . ')</span></div>';
        }
        echo $data;
    }
    
     public function load_sales($id)
    {
        $setting = Setting::find(1, array(
            'select' => 'currency'
        ));
        
             $sales = sale::find('all', array(
            'conditions' => array(
                'client_id = ? AND paidmethod like "2~%"',
                $id,

            )
        ));


        $datasale = '';
        $totitem = 0;
        if ($sales) {
            foreach ($sales as $sale) {
                 $alert = '';
                 $totitem++;
                 $row = '<div class="col-xs-12"><div class="panel panel-default product-details"><div class="panel-body"
                 style="'.$alert.'"><div class="col-xl-5 nopadding"><div class="col-xl-2 nopadding">
                 <a href="javascript:void(0)" onclick="delete_posale(' . "'" . $sale->id . "'" . ')">
                 <span class="fa-stack fa-sm productD"><i class="fa fa-circle fa-stack-2x delete-product"></i>
                 <i class="fa fa-times fa-stack-1x fa-fw fa-inverse"></i></span></a></div><div class="col-xl-10 nopadding">
                 <span class="textPD">' .number_format($sale->subtotal, 2, ",", ".")  .
                 '</span></div><div class="col-xl-3 nopadding productNum"><a href="javascript:void(0)">
                 <span class="fa-stack fa-sm decbutton"><i class="fa fa-square fa-stack-2x light-grey"></i>
                 <i class="fa fa-minus fa-stack-1x fa-inverse white"></i></span></a>
                 <input type="text" id="qt-' . $sale->id . '" onchange="edit_posale(' . $sale->id . ')"
                  class="form-control" value="' . $sale->totalitems . '" placeholder="0" maxlength="3">
                  <a href="javascript:void(0)"><span class="fa-stack fa-sm incbutton"><i class="fa fa-square fa-stack-2x light-grey">
                  </i><i class="fa fa-plus fa-stack-1x fa-inverse white"></i></span></a>
                   <div class="col-xl-5  ">
                  <span class="subtotal textPD">' . number_format($sale->total, 2, ",", ".") .
                   '  ' . $setting->currency . '</span> </div>

                   </div>
                   </div></div></div>';

                $datasale .= $row;
            }
            // adding script for the +/- buttons
            $datasale .= '<script type="text/javascript">$(".incbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();var newVal = parseFloat(oldValue) + 1;$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});$(".decbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();if (oldValue > 1) {var newVal = parseFloat(oldValue) - 1;} else {newVal = 1;}$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});</script>';
        } else {

            $datasale = '<div class="messageVide">' . label("EmptyList") . ' <span>(' . label("SelectProduct") . ')</span></div>';
        }

        echo $datasale;
    }
    
       public function load_sales2($id)
    {
        $setting = Setting::find(1, array(
            'select' => 'currency'
        ));


            $sales = sale::find('all', array(
            'conditions' => array(
                'client_id = ? AND paidmethod like "2~%"',
                $id,

            )
        ));


        $datasale = '';
        $flaq ="";
        if ($sales) {
            $i=2;
            foreach ($sales as $sale) {
                 $i++;
                  $alert = '';
                 if ($sale->flaq == "1")
                      $row = ' <div class="col-sm-2 col-xs-4">
                     <a href="javascript:void(0)" class="addPct" id="product-'. $sale->id .
                     '"onclick="add_posale('. $sale->id .')">
                        <div class="product color0'.$i.' flat-box">
                           <h3 id="proname"> Alojamiento '.
                            number_format((float)$sale->total, $this->setting->decimals, '.', '')
                           . $this->setting->currency .'</h3>
                           <input type="hidden" id="idname-'.$sale->id.'" name="name" value="'.$sale->total.'" />
                           <input type="hidden" id="idprice-'.$sale->total.'" name="price" value="'.$sale->total.'" />
                           <div class="mask">
                              <h3> Subtotal'.
                           number_format((float)$sale->subtotal, $this->setting->decimals, '.', '').
                           $this->setting->currency .
                            '</div><div class="mask"> Tax'. $sale->taxamount.
                           $this->setting->currency . '</h3>
                           </div>
                         </div>
                     </a>
               </div>';
               else
                 $row = ' <div class="col-sm-2 col-xs-4">
                     <a href="javascript:void(0)" class="addPct" id="product-'. $sale->id .
                     '"onclick="add_posale('. $sale->id .')">
                        <div class="product color0'.$i.' flat-box">
                           <h3 id="proname"> '.
                            number_format((float)$sale->total, $this->setting->decimals, '.', '')
                           . $this->setting->currency .'</h3>
                           <input type="hidden" id="idname-'.$sale->id.'" name="name" value="'.$sale->total.'" />
                           <input type="hidden" id="idprice-'.$sale->total.'" name="price" value="'.$sale->total.'" />
                           <div class="mask">
                              <h3> Subtotal'.
                           number_format((float)$sale->subtotal, $this->setting->decimals, '.', '').
                           $this->setting->currency .
                            '</div><div class="mask"> Tax'. $sale->taxamount.
                           $this->setting->currency . '</h3>
                           </div>
                         </div>
                     </a>
               </div>';

                $datasale .= $row;
            }
            // adding script for the +/- buttons
            $datasale .= '<script type="text/javascript">$(".incbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();var newVal = parseFloat(oldValue) + 1;$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});$(".decbutton").on("click", function() {var $button = $(this);var oldValue = $button.parent().parent().find("input").val();if (oldValue > 1) {var newVal = parseFloat(oldValue) - 1;} else {newVal = 1;}$button.parent().parent().find("input").val(newVal);edit_posale($button.parent().parent().find("input").attr("id").slice(3));});</script>';
        } else {

            $datasale = '<div class="messageVide">' . label("EmptyList") . ' <span>(' . label("SelectProduct") . ')</span></div>';
        }
        echo $datasale;
    }

    public function delete($id)
    {
        $posale = Posale::find($id);
        $posale->delete();
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function edit($id)
    {
        $posale = Posale::find($id);
        $product = Product::find($posale->product_id);
       if($product->type == '0'){
          $register = Register::find($this->register);
          $stock = Stock::find('first', array('conditions' => array('store_id = ? AND product_id = ?', $register->store_id, $posale->product_id)));
          $quantity = $stock ? $stock->quantity : 0;
          if(intval($this->input->post('qt')) <= intval($quantity)) {

             $data = array(
                 "qt" => $this->input->post('qt'),
                 "time" => date('Y-m-d H:i:s')
             );
             $posale->update_attributes($data);
             echo json_encode(array(
                 "status" => TRUE
             ));

        }else {
           echo 'stock';
        }
    /******************************************* combo version *************************************************************/
   }elseif ($product->type == '2') {
     $register = Register::find($this->register);
     $quantity = 1;
     $combos = Combo_item::find('all', array('conditions' => array('product_id = ?', $posale->product_id)));
     foreach ($combos as $combo) {
         $prd = Product::find($combo->item_id);
         if($prd->type == '0'){
             $stock = Stock::find('first', array('conditions' => array('store_id = ? AND product_id = ?', $register->store_id, $combo->item_id)));
            $diff = $stock ? ($stock->quantity - $combo->quantity*($this->input->post('qt'))) : 1;
            $quantity = $stock ? ($diff >= 0 ? 1 : 0) : $quantity;
         }
     }
        if($quantity > 0) {
           $data = array(
              "qt" => $this->input->post('qt'),
              "time" => date('Y-m-d H:i:s')
          );
          $posale->update_attributes($data);
          echo json_encode(array(
              "status" => TRUE
          ));
     }else {
         echo 'stock';
     }
   }else {
        $data = array(
            "qt" => $this->input->post('qt'),
            "time" => date('Y-m-d H:i:s')
        );
        $posale->update_attributes($data);
        echo json_encode(array(
            "status" => TRUE
        ));
     }

    }

    public function subtot()
    {
        $posales = Posale::find('all', array(
            'conditions' => array(
                'status = ? AND register_id = ? AND table_id = ?',
                1,
                $this->register,
                $this->selectedTable
            )
        ));
        $sub = 0;
        foreach ($posales as $posale) {
            $sub += $posale->price * $posale->qt;
        }
        echo number_format((float)$sub, $this->setting->decimals, '.', '');
    }

    public function totiems()
    {
        $sales = Sale::find('all', array(
            'conditions' => array(
                'status = ? AND register_id = ? AND table_id = ?',
                1,
                $this->register,
                $this->selectedTable
            )
        ));
        $sub = 0;
        foreach ($sales as $sale) {
            $sub += $sale->totalitems;
        }
        echo $sub;
    }

    public function GetDiscount($id)
    {
        $customer = Customer::find($id);
        $Discount = stripos($customer->discount, '%') > 0 ? $customer->discount : number_format((float)$customer->discount, $this->setting->decimals, '.', '');

        $setting = Setting::find(1, array(
            'select' => 'currency'
        ));
         $sales = sale::find('all', array(
            'conditions' => array(
                'client_id = ? AND paidmethod like "2~%"',
                $id,

            )
        ));

         $totalsale = "0";
         $totalsubsale = "0";
         $totimpuestos ="0";
         $totalitems = "0";

        if ($sales) {
              foreach ($sales as $sale) {
                 $totalsale = $totalsale + $sale->total;
                 $totimpuestos = $totimpuestos + $sale->taxamount ;
                 $totalsubsale = $totalsubsale + $sale->subtotal;
                 $totalitems = $totalitems + $sale->totalitems;
              }

        }

         echo $Discount . '~' . $customer->name .  '~' . $totalsale .  '~' . $totimpuestos .  '~' . $totalsubsale.  '~' . $totalitems;


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

    public function AddNewSale($clientidpaid)
    {
        $fecha = date("Y-m-d H:i:s");
        $_POST['created_at'] = $fecha;
        $_POST['register_id'] = $this->register;
        $register = Register::find($this->register);
        $store = Store::find($register->store_id);
        $valores = explode('~',$clientidpaid);
        $customerid = $valores[0];
        $paidmethod = $valores[1];
        if ($paidmethod == 2) {
            try {
                Stripe::setApiKey($this->setting->stripe_secret_key);
                $myCard = array(
                    'number' => $this->input->post('ccnum'),
                    'exp_month' => $this->input->post('ccmonth'),
                    'exp_year' => $this->input->post('ccyear'),
                    "cvc" => $this->input->post('ccv')
                );
                $charge = Stripe_Charge::create(array(
                    'card' => $myCard,
                    'amount' => (floatval($this->input->post('paid')) * 100),
                    'currency' => $this->setting->currency
                ));
                echo "<p class='bg-success text-center'>" . label('saleStripesccess') . '</p>';
            } catch (Stripe_CardError $e) {
                // Since it's a decline, Stripe_CardError will be caught
                $body = $e->getJsonBody();
                $err = $body['error'];
                echo "<p class='bg-danger text-center'>" . $err['message'] . '</p>';
            }
        }
        unset($_POST['ccnum']);
        unset($_POST['ccmonth']);
        unset($_POST['ccyear']);
        unset($_POST['ccv']);
        $paystatus = $_POST['paid'] - $_POST['total'];
        $_POST['firstpayement'] = $paystatus > 0 ? $_POST['total'] : $_POST['paid'];

           $client = Customer::find('first', array(
            'conditions' => array(
                'id = ?',
                $customerid
            )
        ));
        $ClientData = $client ? 'Customer: ' . $client->name . '<br>' . $client->numdocu. '<br>' . $client->phone . '<br>' . $client->email : label('WalkinCustomer');

        $sales = sale::find('all', array(
            'conditions' => array(
                'client_id = ? AND paidmethod like "2~%"',
                $customerid  )  ));
         if ($sales) {

              $totsal=0;
              $sumsubtotal = 0;
              $sumtax = 0;
              $sumdescuento = 0;
              $sumpaid = 0;
              $ticket1 = "";
            foreach ($sales as $sale) {
                $totsal++;
                $sumsubtotal = $sumsubtotal + $sale->subtotal;
                $sumtax = $sumtax + $sale->taxamount;
                $sumdescuento = $sumdescuento + $sale->discount;
                 $posales = Sale_item::find('all', array(
            'conditions' => array(
                'sale_id = ?',
                $sale->id
                )
                ));
                $i=0;
                foreach ($posales as $posale) {
                  $ticket1 .= '<tr><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' .
                  $posale->name . '</td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
                  $i ++;
               }

             }
          $_POST['client_id'] = $customerid;
          $_POST['subtotal'] = $sumsubtotal;
          $_POST['taxamount'] = $sumtax;
          $_POST['discount'] = $sumdescuento;
          $_POST['totalitems'] = $totsal;
          $_POST['status'] = $paystatus;
          $_POST['paidmethod'] = $paidmethod;
          $salefact = Salefactura::create($_POST);
          $numero = $salefact->id;
          
        }

         $ticket = '<div class="col-sm-12"><table width="100%"><tr><td align="left"><span class="float-left">' .
         $this->setting->companyname . '<br>' . label("Tel") . ' ' . $this->setting->phone .
         '</span></td><td align="right"><img src="files/Setting/' . $this->setting->logo . '"
         alt="" width="100px" Style="margin:15px;float:right;"/></td></tr></table></div><div style="clear:both;"></div>
         <h4 class="float-left">#' . sprintf("%05d", $numero) . '</h4> <div style="clear:both;"></div>
         <span style="font-size:40px;font-weight:600;padding:5px;background-color:#415472;color:#fff;">' .
         label("INVOICE") . '</span><br><br><br><div style="clear:both;"></div><table width="100%"><tr><td align="left">
         <span class="float-left">' . label("Date") . ': ' . $fecha . '</span></td><td align="right"><span Style="margin-bottom:15px;float:right;width:100%;text-align:right">'
         . $ClientData . '</span></td></tr></table><div style="clear:both;"></div><div style="clear:both;"></div>
         <table class="table" cellspacing="0" border="0"><thead><tr style="background-color:#555;color:#fff;font-weight:600">
         <th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") .
         '</th></tr></thead><tbody>';

        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $ticket = $ticket.$ticket1;
        $ticket .= '</tbody></table><div class="col-xs-4  col-xs-offset-8"><table class="table table-striped"
        cellspacing="0" border="0" style="margin:20px 0 30px 0;"><thead><tr><td style="text-align:left; padding:3px;">' .
        label("TotalItems") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' .
        $i-1 . '</td></tr></thead><tbody><tr><td style="text-align:left; padding:3px;">' .
        label("Total") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' .
        number_format((float)$sumsubtotal, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency .
        '</td></tr>';

        
        $sumtotal = ($sumsubtotal + $sumtax)  - $sumdescuento;


        if (intval($sale->discount))
            $ticket .= '<tr><td style="text-align:left; padding:3px;">' . label("Discount") .
            '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' .
            $sumdescuento . '</td></tr>';
        if (intval($sale->tax))
            $ticket .= '<tr><td style="text-align:left; padding:3px; padding-left:1.5%;">' . label("tax") .
             '</td><td style="text-align:right; padding:3px;font-weight:bold;">' . $sumtax . '</td></tr>';
        $ticket .= '<tr style="background-color:#415472;color:#fff;font-weight:600;font-size:20px"><td colspan="2"
        style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sumtotal,
         $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr><tr>';



      /*  $ticket .= '<tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("GrandTotal") . '</td><td colspan="2" style="border-top:1px dashed #000; padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sumtotal, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr><tr>';

       */

        $PayMethode = explode('~', $sale->paidmethod);
        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' .
                label("CreditCard") . '</td><td colspan="2" style="padding-top:5px;
                 text-align:right; font-weight:bold;">xxxx xxxx xxxx ' .
                 substr($PayMethode[1], - 4) . '</td></tr><tr><td colspan="2" style="text-align:left; font-weight:bold;
                 padding-top:5px;">' . label("CreditCardHold") . '</td><td colspan="2" style="padding-top:5px;
                  text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td></tr></tbody></table></div>';
                break;
              default:
                $ticket .= '</tbody></table></div>';
        }
        $ticket .= '<div class="text-center" style="clear:both;padding-bottom:10px; padding-top:10px; width:100%;
         background-color:#eee"><span style="font-size:9px;text-transform:uppercase;letter-spacing: 4px;">' .
         $this->setting->companyname . '<br>' . $this->setting->phone . '</span></div>';


        if (isset($number)) {
            if ($number != 1)
                Hold::delete_all(array(
                    'conditions' => array(
                        'number = ? AND register_id = ? AND table_id = ?',
                        $number,
                        $this->register,
                        rtrim($this->selectedTable, "h")
                    )
                ));
        }
        $hold = Hold::find('last', array(
            'conditions' => array(
                'register_id = ? AND table_id = ?',
                $this->register,
                $this->selectedTable
            )
        ));
        if ($hold) {
            Posale::update_all(array(
                'set' => array(
                    'status' => 1
                ),
                'conditions' => array(
                    'number = ? AND register_id = ? AND table_id = ?',
                    $hold->number,
                    $this->register,
                    rtrim($this->selectedTable, "h")
                )
            ));
        }
        echo $ticket;
    }


    // ******************************************************** hold functions
    public function holdList($registerid)
    {
        $holds = Hold::find('all', array(
            'conditions' => array(
                'register_id = ? AND table_id = ?',
                $registerid,
                $this->selectedTable
            ),
            'order' => 'number asc'
        ));
        $posale = Posale::find('last', array(
            'conditions' => array(
                'status = ? AND register_id = ? AND table_id = ?',
                1,
                $this->register,
                $this->selectedTable
            )
        ));
        $Tholds = '';
        if (empty($holds))
            $Tholds = '<span class="Hold selectedHold">1<span id="Time">' . date("H:i") . '</span></span>';
        else {
            if (empty($posale)) {
                $numItems = count($holds);
                $i = 0;
                foreach ($holds as $hold) {
                    if (++ $i === $numItems)
                        $Tholds .= '<span class="Hold selectedHold" id="' . $hold->number . '"  onclick="SelectHold(' . $hold->number . ')">' . $hold->number . '<span id="Time">' . $hold->time . '</span></span>';
                    else
                        $Tholds .= '<span class="Hold" id="' . $hold->number . '"  onclick="SelectHold(' . $hold->number . ')">' . $hold->number . '<span id="Time">' . $hold->time . '</span></span>';
                }
            } else {
                foreach ($holds as $hold) {
                    if ($hold->number == $posale->number)
                        $selected = 'selectedHold';
                    else
                        $selected = '';
                    $Tholds .= '<span class="Hold ' . $selected . '" id="' . $hold->number . '" onclick="SelectHold(' . $hold->number . ')">' . $hold->number . '<span id="Time">' . $hold->time . '</span></span>';
                }
            }
        }
        echo $Tholds;
    }

    public function AddHold($registerid)
    {
        $hold = Hold::find('last', array(
            'conditions' => array(
                'register_id = ? AND table_id = ?',
                $registerid,
                $this->selectedTable
            )
        ));
        $number = ! empty($hold) ? intval($hold->number) + 1 : 1;
        Posale::update_all(array(
            'set' => array(
                'status' => 0
            ),
            'conditions' => array(
                'status = ? AND register_id = ?',
                1,
                $this->register
            )
        ));
        $attributes = array(
            'number' => $number,
            'time' => date("H:i"),
            'register_id' => $registerid,
            'table_id' => $this->selectedTable
        );
        Hold::create($attributes);
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function RemoveHold($number, $registerid)
    {
        $hold = Hold::find('first', array(
            'conditions' => array(
                'number = ? AND register_id = ? AND table_id = ?',
                $number,
                $registerid,
                $this->selectedTable
            )
        ));
        $hold->delete();
        Posale::delete_all(array(
            'conditions' => array(
                'number = ? AND register_id = ?',
                $number,
                $registerid
            )
        ));
        $hold = Hold::find('last', array(
            'conditions' => array(
                'register_id = ? AND table_id = ?',
                $registerid,
                $this->selectedTable
            )
        ));
        Posale::update_all(array(
            'set' => array(
                'status' => 1
            ),
            'conditions' => array(
                'number = ? AND register_id = ?',
                $hold->number,
                $registerid
            )
        ));
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function SelectHold($number)
    {
        Posale::update_all(array(
            'set' => array(
                'status' => 0
            ),
            'conditions' => array(
                'status = ? AND register_id = ?',
                1,
                $this->register
            )
        ));
        Posale::update_all(array(
            'set' => array(
                'status' => 1
            ),
            'conditions' => array(
                'number = ? AND register_id = ?',
                $number,
                $this->register
            )
        ));
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    /**
     * ****************** register functions ***************
     */
     public function CloseRegister()
     {
         $register = Register::find($this->register);
         $user = User::find($register->user_id);
         $sales = Sale::find('all', array(
             'conditions' => array(
                 'register_id = ?',
                 $this->register
             )
         ));
         $payaments = Payement::find('all', array(
             'conditions' => array(
                 'register_id = ?',
                 $this->register
             )
         ));

         $waiters = Waiter::find('all', array('conditions' => array('store_id = ?', $register->store_id)));

         $cash = 0;
         $cheque = 0;
         $cc = 0;
         $CashinHand = $register->cash_inhand;
         $date = $register->date;
         $createdBy = $user->firstname . ' ' . $user->lastname;

         foreach ($payaments as $payament) {
            $PayMethode = explode('~', $payament->paidmethod);
            switch ($PayMethode[0]) {
                case '1': // case Credit Card
                    $cc += $payament->paid;
                    break;
                case '2': // case ckeck
                    $cheque += $payament->paid;
                    break;
                default:
                    $cash += $payament->paid;
            }
        }

         foreach ($sales as $sale) {
             $PayMethode = explode('~', $sale->paidmethod);
             $paystatus = $sale->paid - $sale->total;
             switch ($PayMethode[0]) {
                 case '1': // case Credit Card
                     $cc += $paystatus > 0 ? $sale->total : $sale->firstpayement;
                     break;
                 case '2': // case ckeck
                     $cheque += $paystatus > 0 ? $sale->total : $sale->firstpayement;
                     break;
                 default:
                     $cash += $paystatus > 0 ? $sale->total : $sale->firstpayement;
             }
         }
         $data = '<div class="col-md-3"><blockquote><footer>' . label("Openedby") . '</footer><p>' . $createdBy . '</p></blockquote></div><div class="col-md-3"><blockquote><footer>' . label("CashinHand") . '</footer><p>' . number_format((float)$CashinHand, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</p></blockquote></div><div class="col-md-4"><blockquote><footer>' . label("Openingtime") . '</footer><p>' . $date->format('Y-m-d h:i:s') . '</p></blockquote></div><div class="col-md-2"><img src="' . site_url() . '/assets/img/register.svg" alt=""></div><h2>' . label("PaymentsSummary") . '</h2><table class="table table-striped"><tr><th width="25%">' . label("PayementType") . '</th><th width="25%">' . label("EXPECTED") . ' (' . $this->setting->currency . ')</th><th width="25%">' . label("COUNTED") . ' (' . $this->setting->currency . ')</th><th width="25%">' . label("DIFFERENCES") . ' (' . $this->setting->currency . ')</th></tr><tr><td>' . label("Cash") . '</td><td><span id="expectedcash">' . number_format((float)$cash, $this->setting->decimals, '.', '') . '</span></td><td><input type="text" class="total-input" value="' . number_format((float)$cash, $this->setting->decimals, '.', '') . '" placeholder="0.00"  maxlength="11" id="countedcash"></td><td><span id="diffcash">0.00</span></td></tr><tr><td>' . label("CreditCard") . '</td><td><span id="expectedcc">' . number_format((float)$cc, $this->setting->decimals, '.', '') . '</span></td><td><input type="text" class="total-input" value="' . number_format((float)$cc, $this->setting->decimals, '.', '') . '" placeholder="0.00"  maxlength="11" id="countedcc"></td><td><span id="diffcc">0.00</span></td></tr><tr><td>' . label("Cheque") . '</td><td><span id="expectedcheque">' . number_format((float)$cheque, $this->setting->decimals, '.', '') . '</span></td><td><input type="text" class="total-input" value="' . number_format((float)$cheque, $this->setting->decimals, '.', '') . '" placeholder="0.00"  maxlength="11" id="countedcheque"></td><td><span id="diffcheque">0.00</span></td></tr><tr class="warning"><td>' . label("Total") . '</td><td><span id="total">' . number_format((float)($cheque + $cash + $cc), $this->setting->decimals, '.', '') . '</span></td><td><span id="countedtotal">' . number_format((float)($cheque + $cash + $cc), $this->setting->decimals, '.', '') . '</span></td><td><span id="difftotal">0.00</span></td></tr></table>';

         foreach ($waiters as $waiter) {
            $cih = explode(',', trim($register->waiterscih, ","));
            $cachin = 0;
            for($i = 0; $i < sizeof($cih); $i += 2){if($cih[$i] == $waiter->id){$cachin = $cih[$i+1];}}
            $cashw = 0;
            $chequew = 0;
            $ccw = 0;
            foreach ($payaments as $payament) {
               if($payament->waiter_id == $waiter->id){
                  $PayMethode = explode('~', $payament->paidmethod);
                  switch ($PayMethode[0]) {
                      case '1': // case Credit Card
                          $ccw += $payament->paid;
                          break;
                      case '2': // case ckeck
                          $chequew += $payament->paid;
                          break;
                      default:
                          $cashw += $payament->paid;
                  }
               }
           }
            foreach ($sales as $sale) {
               if($sale->waiter_id == $waiter->id){
                   $PayMethode = explode('~', $sale->paidmethod);
                   $paystatus = $sale->paid - $sale->total;
                   switch ($PayMethode[0]) {
                       case '1': // case Credit Card
                           $ccw += $paystatus > 0 ? $sale->total : $sale->firstpayement;
                           break;
                       case '2': // case ckeck
                           $chequew += $paystatus > 0 ? $sale->total : $sale->firstpayement;
                           break;
                       default:
                           $cashw += $paystatus > 0 ? $sale->total : $sale->firstpayement;
                   }
               }
            }
            $Wtotal = $ccw + $chequew + $cashw + $cachin;
            $data .= '<div class="waitercount"><ul><li><h4>'.$waiter->name.' :</h4></li><li><b>' . label("CashinHand") . ' : </b>' . number_format((float)$cachin, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</li><li><b>' . label("Cash") . ' : </b>' . number_format((float)$cashw, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</li><li><b>' . label("CreditCard") . ' : </b>' . number_format((float)$ccw, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</li><li><b>' . label("Cheque") . ' : </b>' . number_format((float)$chequew, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</li></ul><div style="clear:both;"></div><div class="wtotal"><h3>' . label("Total") . ' : ' . number_format((float)$Wtotal, $this->setting->decimals, '.', '') . '</h3></div></div>';
         }

         $data .= '<div  class="form-group"><h2>' . label("note") . '</h2><textarea id="RegisterNote" class="form-control" rows="3"></textarea></div>';

         echo $data;
     }

    public function SubmitRegister()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $data = array(
            "cash_total" => $this->input->post('expectedcash'),
            "cash_sub" => $this->input->post('countedcash'),
            "cc_total" => $this->input->post('expectedcc'),
            "cc_sub" => $this->input->post('countedcc'),
            "cheque_total" => $this->input->post('expectedcheque'),
            "cheque_sub" => $this->input->post('countedcheque'),
            "note" => $this->input->post('RegisterNote'),
            "closed_by" => $this->session->userdata('user_id'),
            "closed_at" => $date,
            "status" => 0
        );

        $Register = Register::find($this->register);

        $store = Store::find($Register->store_id);
        $store->status = 0;
        $store->save();

        $tables = Table::find('all', array('conditions' => array('store_id = ?', $Register->store_id)));
        foreach ($tables as $table) {
           $table->status = 0;
           $table->time = '';
           $table->save();
        }

        $Register->update_attributes($data);

        Hold::delete_all(array(
            'conditions' => array(
                'register_id = ?',
                $Register->id
            )
        ));
        Posale::delete_all(array(
            'conditions' => array(
                'register_id = ?',
                $Register->id
            )
        ));

        $CI = & get_instance();
        $CI->session->set_userdata('register', 0);

        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function email()
    {
        $email = $this->input->post('email');
        $content = $this->input->post('content');
        $this->load->library('email');

        $this->email->set_mailtype("html");
        $this->email->from('no-reply@' . $this->setting->companyname . '.com', $this->setting->companyname);
        $this->email->to('$email');

        $this->email->subject('your Receipt');
        $this->email->message($content);

        $this->email->send();

        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function pdfreceipt()
    {
        $content = $this->input->post('content');
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Pdf');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        // add a page
        $pdf->AddPage();

        $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
        ob_end_clean();
        $pdf->Output('pdfexample.pdf', 'D');
    }

    public function storewaitercash($id)
    {
      $waiters = Waiter::find('all', array('conditions' => array('store_id = ?', $id)));
      $content = '';
      foreach ($waiters as $waiter) {
         $content .= '<div class="form-group"><label for="CashinHand"><u>'.$waiter->name.'</u> '.label("CashinHand").'</label><input type="number" step="any" class="form-control" id="waiterid" waiter-id="'.$waiter->id.'" placeholder="'.$waiter->name.' '.label("CashinHand").'" Required></div>';
      }
      echo $content;
   }

   public function WaiterName($num = null)
   {
      $waiterid = Hold::find('first', array(
          'conditions' => array(
             'number = ? AND register_id = ? AND table_id = ?',
             $num,
             $this->register,
             $this->selectedTable
          )
      ))->waiter_id;
      echo $waiterid;
   }
   public function changewaiterS()
   {
      $num = $this->input->post('num');
      $id = $this->input->post('id');
      $hold = Hold::find('first', array(
          'conditions' => array(
             'number = ? AND register_id = ? AND table_id = ?',
             $num,
             $this->register,
             $this->selectedTable
          )
      ));
      $hold->waiter_id = $id;
      $hold->save();

      echo json_encode(array(
          "status" => TRUE
      ));
   }

   public function CustomerName($num = null)
   {
      $customerid = Hold::find('first', array(
          'conditions' => array(
             'number = ? AND register_id = ? AND table_id = ?',
             $num,
             $this->register,
             $this->selectedTable
          )
      ))->customer_id;
      echo $customerid;
   }

   public function changecustomerS()
   {
      $num = $this->input->post('num');
      $id = $this->input->post('id');
      $hold = Hold::find('first', array(
          'conditions' => array(
             'number = ? AND register_id = ? AND table_id = ?',
             $num,
             $this->register,
             $this->selectedTable
          )
      ));
      $hold->customer_id = $id;
      $hold->save();
      $sales = Sale::find('all', array(
             'conditions' => array(
                 'register_id = ? AND client_id = ? AND paidmethod like "2~%" ' ,
                 $this->register,
                 $id
             )
         ));

      echo json_encode(array(
          "status" => TRUE
      ));
   }

   public function showticket($num, $subtotal, $totalitems, $waiter)
   {
      // $hold = Hold::find($num);
      $waiterN = $waiter > 0 ? Waiter::find($waiter)->name : label('withoutWaiter');
      $store = Store::find($this->store);
      $date = date("Y-m-d H:i:s");
      $tableN = Table::find($this->selectedTable)->name;

      $posales = Posale::find('all', array(
           'conditions' => array(
               'status = ? AND register_id = ? AND table_id = ?',
               1,
               $this->register,
               $this->selectedTable
           )
      ));

      $ticket = '<div class="col-md-12"><div class="text-center">' . $this->setting->receiptheader . '</div><div style="clear:both;"><br><div style="clear:both;"><div style="clear:both;"><span class="float-left">' . label("Date") . ': ' . $date . '</span><br><div style="clear:both;"><span class="float-left">' . label("Waiter") . ': ' . $waiterN . '<br> ' . label("Table") . ' :' . $tableN . '</span><div style="clear:both;"><br><br><table class="table" cellspacing="0" border="0"><thead><tr><th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") . '</th></tr></thead><tbody>';

      $i = 1;
      foreach ($posales as $posale) {
           $ticket .= '<tr><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' . $posale->name . '<br><span style="font-size:12px;color:#666">'.$posale->options.'</span></td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px;font-size:14px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
           $i ++;
      }

      $ticket .= '</tbody></table><table class="table" cellspacing="0" border="0" style="margin-bottom:8px;"><tbody><tr><td style="text-align:left;">' . label("TotalItems") . '</td><td style="text-align:right; padding-right:1.5%;">' . $totalitems . '</td><td style="text-align:left; padding-left:1.5%;">' . label("Total") . ' ( + tax)</td><td style="text-align:right;font-weight:bold;">' . $subtotal . ' ' . $this->setting->currency . '</td></tr>';

      $ticket .= '</tbody></table><br><br><div style="border-top:1px solid #000; padding-top:10px;"><span class="float-left">' . $store->name . '</span><span class="float-right">' . label("Tel") . ' ' . ($store->phone ? $store->phone : $this->setting->phone) . '</span><div style="clear:both;"><p class="text-center" style="margin:0 auto;margin-top:10px;">' . $store->footer_text . '</p><div class="text-center" style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;margin-top:20px;">' . $this->setting->receiptfooter . '</div></div>';

      echo $ticket;
   }

   public function showticketKit($tableid)
   {
      $table = Table::find($tableid);
      $tableN = $table->name;
      $posales = Posale::find('all', array(
        'conditions' => array(
          'table_id = ?',
          $tableid
        )
      ));
      foreach ($posales as $posale) {
        $d1 = new DateTime($posale->time);
        $d2 = new DateTime($table->checked);
        if($d1 < $d2){
          $posale->time = 'y';
        }else{
          $posale->time = 'n';
        }
      }
      $table->checked = date("Y-m-d H:i:s");
      $table->save();



      $ticket = '<div class="col-md-12"><div class="text-center">' . $this->setting->receiptheader . '</div><div style="clear:both;"><br><div style="clear:both;"><div style="clear:both;"><br><div style="clear:both;">' . label("Table") . ' :' . $tableN . '</span><div style="clear:both;"><br><br><table class="table" cellspacing="0" border="0"><thead><tr><th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") . '</th></tr></thead><tbody>';

      $i = 1;
      foreach ($posales as $posale) {
           $ticket .= '<tr style="'.($posale->time == "n" ? 'background-color:#FFC0CB;' : '').'"><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' . $posale->name . '<br><span style="font-size:12px;color:#666">'.$posale->options.'</span></td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px;font-size:14px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
           $i ++;
      }

      $ticket .= '</tbody></table>';


      echo $ticket;
   }

   public function getoptions($id, $posale)
   {
      $options = Product::find($id)->options;
      $options = trim($options, ",");
      $array = explode(',', $options); //split string into array seperated by ','
      $poOptions = Posale::find($posale)->options;
      $poOptions = trim($poOptions, ",");
      $array2 = explode(',', $poOptions); //split string into array seperated by ','
      $result = '<div class="col-md-12"><input type="hidden" value="'.$posale.'" id="optprd"><select class="js-select-basic-multiple form-control" multiple="multiple" id="optionsselect">';
      foreach ($array as $value) {
         $selected = '';
         foreach ($array2 as $value2) { $selected = $value == $value2 ? 'selected="selected"' : $selected;}
         $result .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
      }
      $result .= '</select></div>';
      echo $result;
   }

   public function addposaleoptions()
   {
      $options = $this->input->post('options');
      $posaleid = $this->input->post('posale');
      $option = '';
      foreach ($options as $value) {
         $option .= $value.',';
      }
      $posale = Posale::find($posaleid);
      $posale->options = $option;
      $posale->time = date("Y-m-d H:i:s");
      $posale->save();

      echo json_encode(array(
          "status" => TRUE
      ));
   }

   public function CloseTable()
   {
      Hold::delete_all(array(
          'conditions' => array(
              'table_id = ? AND register_id = ?',
              intval($this->selectedTable),
              $this->register
          )
      ));
      Posale::delete_all(array(
          'conditions' => array(
             'table_id = ? AND register_id = ?',
             intval($this->selectedTable),
             $this->register
          )
      ));

      if($this->selectedTable != '0h'){

         $table = Table::find($this->selectedTable);
            $table->status = 0;
            $table->time = '';
            $table->save();
      }

      $CI = & get_instance();
      $CI->session->set_userdata('selectedTable', 0);

      echo json_encode(array(
          "status" => TRUE
      ));
   }
}
