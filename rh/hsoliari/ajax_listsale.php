<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
</HEAD>
<BODY>
<?
   function ajax_list()
    {
      echo "ojo entre a ajax list sale";
        $list = $this->invoice->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $invoice) {
            $no ++;
            $row = array();
            $row[] = sprintf("%05d", $invoice->id);
            $row[] = $invoice->clientname;
            $row[] = $invoice->numdoc;
            $row[] = $invoice->numhab;
            $row[] = $invoice->tax;
            $row[] = $invoice->discount;
            $row[] = number_format((float)$invoice->total, $this->setting->decimals, '.', '');
            $row[] = $invoice->created_by;
            $row[] = $invoice->totalitems;

            switch ($invoice->status) {
                case 1: // case Credit Card
                    $satus = 'unpaid';
                    break;
                case 2: // case ckeck
                    $satus = 'Partiallypaid';
                    break;
                default:
                    $satus = 'paid';
            }
            $row[] = '<span class="' . $satus . '">' . label($satus) . '<span>';

            // add html for action
            if ($this->user->role === "admin")
                $row[] = '<div class="btn-group"><a class="btn btn-primary" href="javascript:void(0)" dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-cog fa-fw"></i> ' . label("Action") . '</a><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-caret-down" title="Toggle dropdown menu"></span></a><ul class="dropdown-menu"><li><a href="javascript:void(0)" onclick="Edit_Sale(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> ' . label("Edit") . '</a></li><li><a href="javascript:void(0)" onclick="payaments(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i> ' . label("Payements") . '</a></li><li><a href="javascript:void(0)" onclick="showInvoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-sticky-note" aria-hidden="true"></i> ' . label("invoice") . '</a></li><li><a href="javascript:void(0)" onclick="showTicket(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-ticket fa-fw" aria-hidden="true"></i> ' . label("Receipt") . '</a></li><li class="divider"></li><li><a href="javascript:void(0)" onclick="delete_invoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> ' . label("Delete") . '</a></li></ul></div>';
            else
                $row[] = '<div class="btn-group"><a class="btn btn-primary" href="javascript:void(0)" dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-cog fa-fw"></i> ' . label("Action") . '</a><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-caret-down" title="Toggle dropdown menu"></span></a><ul class="dropdown-menu"><li><a href="javascript:void(0)" onclick="Edit_Sale(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> ' . label("Edit") . '</a></li><li><a href="javascript:void(0)" onclick="payaments(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i> ' . label("Payements") . '</a></li><li><a href="javascript:void(0)" onclick="showInvoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-sticky-note" aria-hidden="true"></i> ' . label("invoice") . '</a></li><li><a href="javascript:void(0)" onclick="showTicket(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-ticket fa-fw" aria-hidden="true"></i> ' . label("Receipt") . '</a></li></ul></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invoice->count_all(),
            "recordsFiltered" => $this->invoice->count_filtered(),
            "data" => $data
        );
        // output to json format
        echo json_encode($output);
    }
?>
</BODY>
</HTML>
