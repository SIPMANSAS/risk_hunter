<?php
  include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

  $XOBJRES=new greservas;

  $id = "id like '%'";
  $XACTCALENDAR=$XOBJRES->delete_possales($id);

?>

