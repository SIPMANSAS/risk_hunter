<?php
  $YX = 0;
      WHILE ($YX < $XI)
      {
          $nombre=$XNAMEPAX[$YX];
         $cedula = $CEDULAPAX[$YX];
         $email = $EMAILPAX[$YX];
         $idtercero = $IDTERCERO[$YX];
?>

<div class="lista-producto float-clear" style="clear:both;">
 <ul class="list-group">
   <li class="list-group-item">
<div class="float-left"><input type="checkbox" name="item_index[]" /></div>
<div class="float-left"><input class="form-control" id="documento-1" type="text" name="pro_docu[]" value="<?php echo $cedula; ?>" disabled style="width:110px;" /></span></div>
<div class="float-left"><input class="form-control" id="nombre-1" type="text" name="pro_nom[]" value="<?php echo $nombre; ?>"  disabled /></div>
<div class="float-left"><input class="form-control" id="email-1" type="text" name="pro_email[]" value="<?php echo $email; ?>" disabled style="width:110px;"/></div>
<div class="float-left"><input class="form-control" id="eps-1" type="text" name="pro_eps[]" value=""  style="width:110px;" disabled /></div>
<div class="float-left"><input class="form-control" id="idtercero-1" readonly type="text" name="pro_tercero[]" value="<?php echo $idtercero; ?>"  disabled style="width:110px;"/></div>

	</li>
 </ul> 
</div>
<?php
     $YX++;
     }
?>
