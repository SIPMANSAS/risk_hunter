<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/regiones.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        var search = $(this).val();	
        var dataString = 'search='+search;
        var parametros = {
      "search": search,
     }
	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchusuario.php",
            data: parametros,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#search').val($('#'+id).attr('data'));
			
                        //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia').fadeOut(1000);
                        $('#identificau').val(id);
                        $('#identifu').val("d");
                        
                        
			document.getElementById('form').submit();
	                  return false;
                });
            }
        });
    });
}); 
</script>

</head>
<body>  
   
<?php 

if (isset($_POST["identificau"]))
        $identificador = $_POST["identificau"];
    elseif (isset($_POST["idusuario"]))
        $identificador = $_POST["idusuario"];
    else
        $identificador = "1";
    $filtro = "1";
if(isset($_POST["identificau"]) or (isset($_POST["idusuario"])))
{
    /* entrada al metodo post para mostrar informacion de usuario y actualizar */
    
    if (isset($_POST["identificau"]))
         $identificador = $_POST["identificau"];
    elseif (isset($_POST["idusuario"]))
        $identificador = $_POST["idusuario"];
    
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "identificador = '$identificador'";
    $result = $Json->buscarusuarios($filtro);
    $xinfouser = $Json->obtener_fila($result);
    //aqui cambio el id de la sugunda pagina
   
  
    
    $filtro = "id_usuario = $identificador";
    $result = $Json->buscarclienteusuario($filtro);
    $xrowcl = array();
    echo "<br>";
}
else
{

echo '<div class="buscar">';
echo '<div class="contenedor-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input type="search" id="search" placeholder="Buscar Usuario..." autocomplete="off" />
    </div>
    
 <div id="sugerencia"></div>
    </div>';

}
 ?>
</body>
</html>