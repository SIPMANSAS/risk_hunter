<?php
  $YX = 1;
  echo '<div class="lista-rol float-clear" style="clear:both;">';
     
  if (!isset($irolxusuario))
      $irolxusuario = 0;
   WHILE ($YX < $irolxusuario )
      {
          $nombrerol = $rolusuario[$YX];
            
          echo '<div class="float-left"> <ul class="list-group">
          <li class="list-group-item"> ';
                    
          echo '<div class="float-left"><input type="checkbox" id="itemru-'.$YX.'" name="item_index[]" /></div>';
          echo  '<div class="float-left"><input class="form-control" id="nombrerol-'.$YX.'" type="text" name="nomrol[]" value="'.$nombrerol.'" autocomplete="off" /></div>';
          echo ' </li>
                </ul></div> ';
              $YX++;
     }
     if ($YX == 1)
     {
     echo '<div class="float-left"> <ul class="list-group">
          <li class="list-group-item">';
     
     echo '<div class="float-left"><input type="checkbox" id="item-1" name="item_index[]" /></div>
		   <div class="float-left"><input class="form-control" id="nombrerol-1" type="text" name="nomrol[]"  /></div>';
      echo ' </li>
                </ul>
                </div>';
     }
     echo '</div>';
?>
