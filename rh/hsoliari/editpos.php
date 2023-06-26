<?php
  include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

  $XOBJRES=new greservas;

   function edit($id)
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


?>

