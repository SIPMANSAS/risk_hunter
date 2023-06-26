<?php
	include 'sec_login.php';
	include 'clases/gabriel.class.php';  
?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoria rh</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="shortcut icon" href="favicon.ico">
    
	<script>
		$(document).ready(function() {
			$('#search').on('keyup', function() {
				var key = $(this).val();	
				var dataString = 'key='+key;
				var parametros = {
				"search": search,
				}
		$.ajax({
				type: "POST",
				url: "funciones/obtienesearchauditoria.php",
				data: dataString,
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
							$('#idauditoria').val(id);
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
<?php include 'header-rh.php'; ?>
<div class="titulo_p"><i class="fa-solid fa-eye"></i></i>&nbsp; Auditoria</div>
<div class="link_int">
	<div class="titulo2"><a href="auditoria.php">Volver</a></div>
	<div class="titulo3"></div>
</div>
<div class="buscar">
	<div class="contenedor-1">
		<span class="icon"><i class="fa fa-search"></i></span>
		<input type="search" id="search" placeholder="Buscar registro..." autocomplete="off" />
	</div>
	<div id="sugerencia"></div>
</div>

<?php
$idauditoria = $_POST['idauditoria'];

if(isset($_POST['idauditoria'])){
	echo "<div class='contenedor_titulos'>
			<div class='titulo'>resultados de la busqueda</div>
		</div>
		<div class='contenedor_titulos_aud'>
			<div class='titulo_aud'>Nombre</div>
			<div class='titulo_aud'>Consecutivo</div>
			<div class='titulo_aud'>Registro Antes</div>
			<div class='titulo_aud'>Registro Después</div>
			<div class='titulo_aud'>Usuario</div>
			<div class='titulo_aud'>Fecha</div>
			<div class='titulo_aud'>Estado Anterior</div>
			<div class='titulo_aud'>Estado Actual</div>
		</div>
		";
		$filtro="identificador ='$idauditoria'";
		$Jsonauditoria     = new gabriel;
        $consulta = $Jsonauditoria->iniciarVariables();
        $resp = $Jsonauditoria->buscaauditoria($filtro);
	
	while($resultado=$Jsonauditoria->obtener_fila($resp))
	{ ?>
	
	<div class='contenedor_aud'>
		<div class="campos_aud"><?php echo $resultado['nombre']; ?></div>
		<div class="campos_aud"><?php echo $resultado['consecutivo']; ?></div>
		<div class="campos_aud"><?php echo $resultado['registro_antes']; ?></div>
		<div class="campos_aud"><?php echo $resultado['registro_despues']; ?></div>
		<div class="campos_aud"><?php echo $resultado['usuario']; ?></div>
		<div class="campos_aud"><?php echo $resultado['fecha']; ?></div>
		<div class="campos_aud"><?php echo $resultado['estado_anterior']; ?></div>
		<div class="campos_aud"><?php echo $resultado['estado_actual']; ?></div>
		</div>
		
<?php } 
echo "<div class='cont_fin'></div>";
}else{ ?>

<div class="contenedor_titulos_aud">
	<div class="titulo_aud">Nombre</div>
	<div class="titulo_aud">Consecutivo</div>
	<div class="titulo_aud">Registro Antes</div>
	<div class="titulo_aud">Registro Después</div>
	<div class="titulo_aud">Usuario</div>
	<div class="titulo_aud">Fecha</div>
	<div class="titulo_aud">Estado Anterior</div>
	<div class="titulo_aud">Estado Actual</div>
</div>
<?php
$filtro="1";
		$Jsonauditoria     = new gabriel;
        $consulta = $Jsonauditoria->iniciarVariables();
        $xcompproyectos = $Jsonauditoria->listaauditoria($filtro);  
	
	while($auditor=$Jsonauditoria->obtener_fila($xcompproyectos)) { ?>
	<div class="contenedor_aud">
		<div class="campos_aud"><?php echo $auditor['nombre']; 			?></div>
		<div class="campos_aud"><?php echo $auditor['consecutivo']; 	?></div>
		<div class="campos_aud"><?php echo $auditor['registro_antes'];  ?></div>
		<div class="campos_aud"><?php echo $auditor['registro_despues'];?></div>
		<div class="campos_aud"><?php echo $auditor['usuario']; 		?></div>
		<div class="campos_aud"><?php echo $auditor['fecha']; 			?></div>
		<div class="campos_aud"><?php echo $auditor['estado_anterior']; ?></div>
		<div class="campos_aud"><?php echo $auditor['estado_actual']; 	?></div>
	</div>
<?php } ?>
<form id="form" name="" action="auditoria.php" method="post" >
	<input name="idauditoria" id="idauditoria" type="hidden">
</form>
<div class="cont_fin"></div>
<?php } ?>
<?php include 'footer.php'; ?>	
</body>
</html>