<div class="lista-producto float-clear" style="clear:both;">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="bloque-pregunta">
                <div class="float-left">
                    <input type="checkbox" id="item-1" name="item_index[]" />
                </div> 
                <div class="bloque-p">
                    <div id="headerp">
                        <div class="col-heading" > Pregunta</div>
                    </div>
                    <div>
                        <div class="float-left">  Id:   <input  id="identificador-1"  type="text" name="pro_identificador[]" disabled style="width:40px;" /> </div>
                        <div class="float-left">  Pregunta:   <input  id="nombre-1" type="text" name="pro_nom[]" style="width: 345px;" autocomplete="off" /> </div>
                       </div>   
                       <div class="float-left">
                        <div class="estado">
                            <b>Estado:</b> 
                            <div class="switch-button">
                                <input type="checkbox" name="estadoval[]" id="switch-label-1" class="switch-button__checkbox" checked>
                                <label for="switch-label-1" class="switch-button__label"></label>
                            </div>                              
                        </div>
                       </div>
                    </div>
                <div class="bloque-p">
                    <div id="headerr">
                        <div class="col-heading" > Respuesta </div>
                    </div>
                    <div class="contenedor-1">
                        <div id="sugerencia4" class="l_bloques"></div>
                        <div class="float-left"> Respuesta: 
                          <span class="icon"><i class="fa fa-search"></i></span>
                            <input  id="nomrespuesta-1" placeholder="Buscar Respuesta..." type="text" name="nom_respuesta[]"  style="width: 400px;" autocomplete="off" /> 
                        </div>                     
                    </div> 
                    <div class="bloque-select">
                        <div class="float-left"> Respuesta de Cierre: 
                            <SELECT  name="respuestacierre[]" id="respuestacierre-1"  style="width: 150px"; />
                            <option value="0" > - </option>
                             </SELECT>
                        </div> 
                        <div class="float-left">
                            <input id="idrespuesta-1" type="hidden" name="id_respuesta[]" style="width:40px;" />
                        </div>        
                        <div class="float-left"> Respuesta Activa Riesgo:  
                            <SELECT  name="respuestariesgo[]" id="respuestariesgo-1" style="width: 150px";  />
                            <option value="0"> - </option>
                            </SELECT>
                        </div>
                        <!----------------------------------------------------- INICIO MODIFICACION SEBASTIAN 1/12/22---------------------------------------------------------->
                        <div class="float-right">  
                        <?php
                        $idpregunta = $_POST["id"];
                        $bloque = $_POST["idbloque"];
                        ?>
                               <a href="crearespuestas.php" class="btn_azul">+ Crear</a>
                               <input type="hidden" value="<?php echo $idpregunta ?>" name="identificador">
                               <input type="hidden" value="<?php echo $bloque ?>" name="idbloque">
                        </div>
                        <!----------------------------------------------------- END MODIFICACION SEBASTIAN 1/12/22---------------------------------------------------------->
                    </div>
                </div>
                <div>
                    <?php  //echo class="bloque-p" ?>
                    <div id="headerpd">
                       <?php /* <div class="col-heading" > Padre </div>*/ ?>
                    </div>
                    <div>
                      <?php
                      /*<div class="float-left"> Id Padre: 
                        	<input  id="padre-1" type="hidden"  name="pro_padre[]"  value="<?php echo $idpregunta ?>" style="width:40px;" /> 
                        	<input  value="<?php echo $idpregunta ?>" style="width:40px;" disabled /> 
                    	</div>
                    	<div class="float-left"> Nombre Padre: 
                        	<input  id="nompadre-1" type="text" name="nom_padre[]" disabled  style="width:190px;" />
                    	</div>
                    	*/
                    	?>
                    </div>
                    <?php 
                    /*
                     <div class="contenedor-1">
                    <div class="float-left"> Otro padre?
                       <span class="icon"><i class="fa fa-search"></i></span> 
                        <input  id="nompreguntapadre-1" type="text" name="nompreguntapadre[]" placeholder="NO" style="width:110px;" />
                    </div>
                    <div id="sugerencia5" class="l_bloques"></div>
                    */
                    ?>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
 