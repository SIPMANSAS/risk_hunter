<?php
     $YX = 1;
     echo '<div class="lista-valores float-clear" style="clear:both;">';
WHILE ($YX < $ir )
{
    $nomvalor = $valores[$YX];
    $idval = $id_valor[$YX];
 
   echo '<ul class="list-group">
   <li class="list-group-item">
<div class="float-left"><input type="checkbox" id="item-1"  name="item_index[]" /></div>
<div class="float-left"><input class="form-control" id="identificador-'.$YX.'" readonly type="text" name="pro_identificador[]" value="'.$idval.'" style="width:110px;" /></div>
<div class="float-left"><input class="form-control" id="nomb-'.$YX.'" type="text" name="pro_nomvalor[]" value="'.$nomvalor.'"  /></div>
<div class="float-left"><div class="switch-button">
                    <input type="checkbox" name="estadoval[]" id="switch-label-'.$YX.'" class="switch-button__checkbox" checked>
                    <label for="switch-label-'.$YX.'" class="switch-button__label"></label>
                </div></div>
</li>
 </ul> ';
   $YX++;
}
if ($YX == 1)
{
    echo '<ul class="list-group"> <li class="list-group-item">
    <div class="float-left"><input type="checkbox" id="item-1"  name="item_index[]" /></div>
    <div class="float-left"><input class="form-control" id="identificador-1" readonly type="text" name="pro_identificador[]"  style="width:110px;" /></div>
    <div class="float-left"><input class="form-control" id="nomb-1" type="text" name="pro_nomvalor[]"   /></div>
    <div class="float-left"><div class="switch-button">
                    <input type="checkbox" name="estadoval[]" id="switch-label-1" class="switch-button__checkbox" checked>
                    <label for="switch-label-1" class="switch-button__label"></label>
                </div></div></li></ul> ';
}
echo '</div>';
