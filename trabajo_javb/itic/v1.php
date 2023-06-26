
<?php
////////////////// CONEXION A LA BASE DE DATOS //////////////////

$host = 'localhost';
$basededatos = 'sipman_risk_hunter';
$usuario = 'risk_hunter';
$contraseña = 'Kaliman01*';



$conexion = new mysqli($host, $usuario,$contraseña, $basededatos);
if ($conexion -> connect_errno) {
die( "Fallo la conexión : (" . $conexion -> mysqli_connect_errno() 
. ") " . $conexion -> mysqli_connect_error());
}
  ///////////////////CONSULTA DE LOS ALUMNOS///////////////////////

$alumnos="SELECT * FROM alumnos order by id_alumno";
$queryAlumnos= $conexion->query($alumnos);


?>

<html lang="es">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

		<link rel="stylesheet" href="css/estilos.css" rel="stylesheet">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>

		<script>
			
    		$(function(){
				// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
				$("#adicional").on('click', function(){
					$("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
				});
			 
				// Evento que selecciona la fila y la elimina 
				$(document).on("click",".eliminar",function(){
					var parent = $(this).parents().get(0);
					$(parent).remove();
				});
			});
		</script>



	</head>

	<body>
		<header>
			<div class="alert alert-info">
			<h2>Insertar Registros a la BD con PHP y JQUERY</h2>
			</div>
		</header>

		<section>

				<table class="table">


					<tr class="info">
						<th>No Pregunta</th>
						<th>Pregunta</th>
						<th>Respuesta</th>
						<th>Grupo</th>

				    </tr>

				  <?php

				  while($registroAlumno  = $queryAlumnos->fetch_array( MYSQLI_BOTH)) 
				  {


				  echo '<tr>
				    	<td>'.$registroAlumno['id_alumno'].'</td>
				    	<td>'.$registroAlumno['nombre'].'</td>
				    	<td>'.$registroAlumno['carrera'].'</td>
				    	<td>'.$registroAlumno['grupo'].'</td>
				    </tr>';
				   }

				  ?>


				</table>


			<?php

				//////////////////////// PRESIONAR EL BOTÓN //////////////////////////
				if(isset($_POST['insertar']))

				{

				$items1 = ($_POST['idalumno']);
				$items2 = ($_POST['nombre']);
				$items3 = ($_POST['carrera']);
				$items4 = ($_POST['grupo']);


				///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
				$contador = 0;
				while(true) {

				    $item1 = current($items1);
				    $item2 = current($items2);
				    $item3 = current($items3);
				    $item4 = current($items4);

				    echo "item1<".$item1.">";
				    echo "item2<".$item2.">";
				    echo "item3<".$item3.">";
				    echo "item4<".$item4.">";
                    echo "valoresQ<".$valoresQ.">";
                    echo "contador<".$contador.">";
				    //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
				    if ($contador = 0){
				        $mi_consulta = "select * from v_pinta_formulario where id_pregunta = f_pintar_siguiente_pregunta( 1,1 )";
				    }
				    else {
				        $mi_consulta = "select * from v_pinta_formulario where id_pregunta = f_pintar_siguiente_pregunta( 1,'$item1' )";
				    }
                    $mi_pregunta= $conexion->query($mi_consulta);
                    $registropregunta  = $mi_pregunta->fetch_array( MYSQLI_BOTH); 



                    ?>
        				<h3 class="bg-primary text-center pad-basic no-btm"> <?php echo $registropregunta['Label'] ?> </h3>
                    <?php
                    

				    $item2 = $registropregunta['Label'];
				
	        ?>
			<form method="post">
				<!--<h3 class="bg-primary text-center pad-basic no-btm">Agregar Nuevo Alumno </h3> -->
				<table class="table bg-info"  id="tabla">
					<tr class="fila-fija">
						<td><input required name="idalumno[]" placeholder="Siguiente Pregunta"/></td>
						<td><input required name="nombre[]" placeholder="Basura"/></td>
						<td><input required name="carrera[]" placeholder="Respuesta"/></td>
						<td><input required name="grupo[]" placeholder="Basura"/></td>
						<td class="eliminar"><input type="button"   value="Menos -"/></td>
					</tr>
				</table>

				<div class="btn-der">
					<input type="submit" name="insertar" value="Insertar Alumno" class="btn btn-info"/>
					<button id="adicional" name="adicional" type="button" class="btn btn-warning"> Más + </button>

				</div>
			</form>
            <?php
            



				    
				    
				    ////// ASIGNARLOS A VARIABLES ///////////////////
				    $id=(( $item1 !== false) ? $item1 : ", &nbsp;");
				    $nom=(( $item2 !== false) ? $item2 : ", &nbsp;");
				    $carr=(( $item3 !== false) ? $item3 : ", &nbsp;");
				    $gru=(( $item4 !== false) ? $item4 : ", &nbsp;");

				    //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
				    $valores='('.$id.',"'.$nom.'","'.$carr.'","'.$gru.'"),';

				    //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
				    $valoresQ= substr($valores, 0, -1);
				    
				    ///////// QUERY DE INSERCIÓN ////////////////////////////
				    $sql = "INSERT INTO alumnos (id_alumno, nombre, carrera, grupo) 
					VALUES $valoresQ";

					
					$sqlRes=$conexion->query($sql) or mysql_error();

				    
				    // Up! Next Value
				    $item1 = next( $items1 );
				    $item2 = next( $items2 );
				    $item3 = next( $items3 );
				    $item4 = next( $items4 );
				    
				    // Check terminator
				    if($item1 === false && $item2 === false && $item3 === false && $item4 === false) break;
    
				}
				}

			?>



		</section>

		<footer>
		</footer>
	</body>

</html>


