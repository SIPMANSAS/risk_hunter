<?php

$mysqlserver="localhost";  				 // host del MySQL
$dbname="u649745058_novoclpa_panel";			 // Seleccionamos la base con la cual trabajar
$user="u649745058_novoclpa_panel";					 // aqui debes ingresar el nombre de usuario
$passdb="+Kh@pVHkk9[B";						 // password de acceso para el usuario de la

$conn = mysqli_connect($mysqlserver, $user, $passdb, $dbname);
if (!$conn) {
   die("conexion falida: " . mysqli_connect_error());
}

 echo "me conecte sin problema";
 $consulta = "select * from users";

$datos = mysqli_query($conn, $consulta) or
    die("Problemas en el select:" . mysqli_error($conexion));
while ($reg = mysqli_fetch_array($datos)) {
    echo "id:" . $reg['Id'] . "<br>";
    echo "grupo:" . $reg['grupo'] . "<br>";
    echo "name:" . $reg['name'] . "<br>";
}
?>

