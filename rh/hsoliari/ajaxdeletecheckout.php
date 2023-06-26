<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

$XOBJRES=new greservas;

echo "entre delete";
 $id = "%";
        $XDELPOS=$XOBJRES->delete_possales($id);
        echo json_encode(array(
            "status" => TRUE
        ));

?>
