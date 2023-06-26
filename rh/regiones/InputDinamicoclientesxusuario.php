<?php
  $YX = 1;

 echo '<div class="lista-cliente float-clear" style="clear:both;">';
 
 if (!isset($iclientexusuario))
     $iclientexusuario = 0;
     WHILE ($YX < $iclientexusuario )
     {
         $nombrecliente = $clienteusuario[$YX];
         
         echo '<div class="float-left"> <ul class="list-group">
          <li class="list-group-item"> ';
         
         echo '<div class="float-left"><input type="checkbox" id="itemcliente-'.$YX.'" name="itemcliente_index[]" /></div>';
         echo  '<div class="float-left"><input class="form-control" id="nombrecliente-'.$YX.'" type="text" name="clientef[]" value="'.$nombrecliente.'" autocomplete="off" /></div>';
         echo ' </li>
                </ul></div> ';
         $YX++;
     }
     if ($YX == 1)
     {
         echo '<div class="float-left"> <ul class="list-group">
          <li class="list-group-item">';
         
         echo '<div class="float-left"><input type="checkbox" id="itemcliente-1" name="itemcliente_index[]" /></div>
		   <div class="float-left"><input class="form-control" id="nombrecliente-1" type="text" name="clientef[]"  /></div>';
         echo ' </li>
                </ul>
                </div>';
     }
     echo '</div>';
 ?>
     
