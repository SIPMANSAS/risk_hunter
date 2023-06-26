<div class="lista-producto float-clear" style="clear:both;">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="bloque-pregunta">
                <div class="float-left">
                    <input type="checkbox" id="item-1" name="item_index[]" />
                </div> 
                <div class="bloque-p">
                     <div>
                        <div class="float-left">  Id:   <input  id="identificador-1"  type="text" name="pro_identificador[]" disabled style="width:40px;" /> </div>
                        <div class="float-left">  Nombre Pregunta:   <input  id="nombre-1" type="text" name="pro_nom[]"  /> </div>
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
                    <div class="contenedor-1">
                        <div id="sugerencia4" class="l_bloques"></div>
                        <div class="float-left"> Nombre Respuesta: 
                          <span class="icon"><i class="fa fa-search"></i></span>
                            <input  id="nomrespuesta-1" placeholder="Buscar Respuesta..." type="text" name="nom_respuesta[]"  autocomplete="off" /> 
                        </div>                     
                    </div> 
                    <div class="bloque-select">
                        <div class="float-left"> Respuesta de Cierre: 
                            <SELECT  name="respuestacierre[]" id="respuestacierre-1"  />
                             </SELECT>
                        </div> 
                        <div class="float-left">
                            <input id="idrespuesta-1" type="hidden" name="id_respuesta[]" style="width:40px;" />
                        </div>        
                        <div class="float-left"> Respuesta Activa Riesgo:  
                            <SELECT  name="respuestariesgo[]" id="respuestariesgo-1"   />
                            </SELECT>
                        </div>
                    </div>
                </div>
                <div class="bloque-p">
                     <div>
                    	<div class="float-left"> Id Padre: 
                        	<input  id="padre-1" type="text"  name="pro_padre[]"  style="width:40px;" /> 
                    	</div>
                    	<div class="float-left"> Nombre Padre: 
                        	<input  id="nompadre-1" type="text" name="nom_padre[]" disabled  style="width:190px;" />
                    	</div>
                    </div>
                     <div class="contenedor-1">
                    <div class="float-left"> Otro padre?
                       <span class="icon"><i class="fa fa-search"></i></span> 
                        <input  id="nompreguntapadre-1" type="text" name="nompreguntapadre[]" placeholder="NO" style="width:110px;" />
                    </div>
                    <div id="sugerencia5" class="l_bloques"></div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
 