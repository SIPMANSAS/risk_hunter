<?php
     $YX = 1;
     echo '<div class="lista-producto float-clear" style="clear:both;">';
WHILE ($YX < $ir )
{
    $nomriesgo = ($riesgo[$YX]);
    $idpreg = $identificadorpreg[$YX];
    $idriesgo = $id_riesgo[$YX];
    echo ' <div>
            <div class="bloque-p">
                    <div class="float-left">
                        <input type="checkbox" id="item-'.$YX.'" name="item_index[]"  />
                    </div>
                    <div class="float-left">
                        <span class="icon"><i class="fa fa-search"></i></span>
                        <div class="float-left"><input type="text" id="nomriesgo-'.$YX.'" placeholder="Buscar Riesgo..."  name="nombriesgo[]" value="'.utf8_decode($nomriesgo).'" autocomplete="off" style="width:300px;" /></div>
                    </div>
                    <div class="float-left">
                        <input type="text" id="idriesgo-'.$YX.'" name="idriesgof[]" value="'.$idriesgo.'" style="width:40px;" />
                    </div>
            </div>                                       
           </div>';
    $YX++;
}
if ($YX == 1)
{
    echo ' <div>
            <div class="bloque-p">
               <div class="float-left">
                   <input type="checkbox" id="item-1" name="item_index[]" />
               </div>
                    <div class="float-left">
                        <span class="icon"><i class="fa fa-search"></i></span>
                        <div class="float-left"><input type="text" id="nomriesgo-1" placeholder="Buscar Riesgo..."  name="nombriesgo[]" autocomplete="off" style="width:300px;" /></div>
                   </div>
                   <div class="float-left">
                        <input type="text" id="idriesgo-1" name="idriesgof[]"  style="width:40px;" />
                   </div>
                </div>
           </div>';
}
echo '</div> ';
       
     