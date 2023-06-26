<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
</HEAD>
<BODY>
<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

echo "entro a enviardato".  $_POST['data'];
  if (isset($_POST['data']))
  {
  
      $idtarifa = $_POST['data'];
      $XRCLI=$XOBJRES->buscar_idtarifa($idtarifa);
	  $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
      if (isset($XROWCLI[0]))
	     $tarifa =  $XROWCLI[0];
      else
         $tarifa = '0';
  }
  else
    $tarifa = '0';
    echo $tarifa;
?>
</BODY>
</HTML>
