<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Valores de Respuestas</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<link href="css/bootstrap.min-2.css" rel="stylesheet">
<link rel="stylesheet" href="css/regiones.css">
<link rel="stylesheet" href="css/preguntas.css">
<link href="css/styledynam.css" rel="stylesheet">

 <script>
function AgregarMas() {
    var id = $(".lista-valores").length + 1;
    var idant = id - 1;
    var nombrepp = 'esp-' + idant;
    var nombre = 'esp-' + id;
    var nombreant =    $("#totnombre").val();
    var nombre2 = "";
      $("<div>").load("InputDinamicovalores.php", function() {
            var html = $(this).html();
            html = html.replace('identificador-1', 'identificador-' + id);
            html = html.replace('nombre-1', 'nombre-' + id);
            $("#identificador-" + idant).val(idant);
            $("#totresgistrovalor").val(id);
       	    $("#listvalores").append(html);
	});
}

function BorrarRegistro() {
	$('div.lista-valores').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</script>

</head>
<body>

<?php


    /* ingreso al formulario inicial */
                      
    echo '<div class="contenedor"><form name="bloque1" class="registro" action="crearespuestas.php" method="post" /> ';
    echo '<input type="hidden" id="totregistrovalor" name="totregistro" />';
    echo "</div>";
    echo '
    			<div class="mt-5">
                <div class="row">
                <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3>Valores del Tipo de Dato </h3>
                
                <div id="outer">
                <div id="header">
                <div class="float-left">&nbsp; Nro.</div>
                <div class="float-left col-heading2"> Id</div>
                <div class="float-left col-heading"> Nombre</div>
                </div>
    <div id="listvalores">';
    require_once("InputDinamicovalores.php");
    echo '        </div>
            <div class="btn-action float-clear">
                <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
             </div>
			<div style="position: relative;">
			<input class="btn btn-primary" type="submit" name="enviar" value="Enviar" /></div>
    </div> ';
    echo '</form>
        </div>
       <div class="registro registro-b">';

?>  
<script src="js/bootstrap.min.js"></script> 
</body>
</html>