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
        <title>Caracteristicas</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
				url: "funciones/obtienesearchcaracteristica.php",
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
							$('#idcaracter').val(id);
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
    <?php include 'header-rh.php' ?>
    <div class="titulo_p"><i class="fa-solid fa-chart-simple"></i></i>&nbsp; Característicsa Activas</div>
    <div class="link_int">
        <div class="titulo2">
            <i class="fa-solid fa-list"></i>
            <a href="listarcaracteristicasdesactivadas.php"> Listar Características Desactivadas</a>
        </div>
        <div class="titulo3">
            <i class="fa-solid fa-plus"></i>
            <a href="creacaracteristica.php"> Crear Características</a>
        </div>
    </div>
    <div class="buscar">
        <div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar registro..." autocomplete="off" />
        </div>
        <div id="sugerencia"></div>
    </div>
    <?php
$idcaracter = $_POST['idcaracter'];

if(isset($_POST['idcaracter'])){
	echo "<div class='contenedor_titulos'>
			<div class='titulo'>resultados de la busqueda</div>
		</div>
		<div class='contenedor_titulos'>
            <div class='titulo'>Nombre</div>
            <div class='titulo'>Tipo de Bien</div>
            <div class='titulo'></div>
		</div>
		";
        $filtro= $idcaracter;
        $Jsoncaracter     = new gabriel;
        $consulta = $Jsoncaracter->iniciarVariables();
        $xcompproyectos = $Jsoncaracter->resbuscacaracteristicaactiva($filtro);
       
       while ($resultado = $Jsoncaracter->obtener_fila($xcompproyectos)) { ?>

	<div class='contenedor'>
        <div class="campos_aud"><?php echo $resultado['nombre']; ?></div>
        <div class="campos_aud">
            <form action="editarcaracteristica.php" method="POST">        
                <input  type="hidden" value="<?php echo $resultado['identificador'];  ?>" name="idcaracteristica">
                <input type="hidden" value="<?php echo $resultado['nombre']; ?>" name="nombre">
                <input type="hidden" value="<?php echo $resultado['tipo_estado']; ?>" name="tipo">
                <input type="hidden" value="<?php echo $resultado['estado']; ?>" name="estado">
                <input type="hidden" value="<?php echo $resultado['cod_dominio']; ?>" name="cod">
                <button class="btn_azul" type="submit" name="editarcaracteristica">Editar</button>
            </form>
            <form action="controller/controllercaracteristica.php" method="POST">
                <input type="hidden" value="<?php echo $resultado['identificador'];  ?>" name="idcaracteristica">
                <button class="btn_rojo" type="submit" name="desactivarcaracteristica">Desactivar</button>
            </form>
        </div>    
	</div>
		
<?php } 
echo "<div class='cont_fin'></div>";
}else{ ?>
    <div class="contenedor_titulos">
        <div class=" titulo">Nombre</div>
        <div class=" titulo">Tipo de Bien</div>
        <div class=" titulo"></div>
    </div>
    
    <?php
        $filtro="1";
         $Jsoncaracter     = new gabriel;
         $consulta = $Jsoncaracter->iniciarVariables();
         $xcompproyectos = $Jsoncaracter->buscacaracteristicaactiva($filtro);
        
        while ($caracteristicas = $Jsoncaracter->obtener_fila($xcompproyectos)) { ?> 
          
            <div class="contenedor">
                <div class="campos_f"><?php echo $caracteristicas['nombre']; ?></div>
                <div class="campos_f">
                    <?php
                        $dom  = $caracteristicas['cod_dominio'];
                        $con  = $Jsoncaracter->tipobienes($dom);
                        $trae = $Jsoncaracter->obtener_fila($con);
                        echo $trae['nombre']; 
                    ?>
                </div>
                <div class="campos_f">
                <form action="editarcaracteristica.php" method="POST">        
                    <input  type="hidden" value="<?php echo $caracteristicas['identificador'];  ?>" name="idcaracteristica">
                    <input type="hidden" value="<?php echo $caracteristicas['nombre']; ?>" name="nombre">
                    <input type="hidden" value="<?php echo $caracteristicas['tipo_estado']; ?>" name="tipo">
                    <input type="hidden" value="<?php echo $caracteristicas['estado']; ?>" name="estado">
                    <input type="hidden" value="<?php echo $caracteristicas['cod_dominio']; ?>" name="cod">
                    <button class="btn_azul" type="submit" name="editarcaracteristica">Editar</button>
                </form>
                <form action="controller/controllercaracteristica.php" method="POST">
                    <input type="hidden" value="<?php echo $caracteristicas['identificador'];  ?>" name="idcaracteristica">
                    <button class="btn_rojo" type="submit" name="desactivarcaracteristica">Desactivar</button>
                </form>
                </div>
            </div>   
        <?php } ?>
    <form id="form" name="" action="listacaracteristicas.php" method="post" >
	    <input name="idcaracter" id="idcaracter" type="hidden">
    </form>
    </div>
    <div class="cont_fin"></div>
    <?php } ?>
    <?php include 'footer.php'; ?>
</body>
</html>