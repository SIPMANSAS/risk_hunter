<?php
// simple conexion a la base de datos
function connect(){
	return new mysqli('localhost','u571892443_risk_hunter','#6mL0I[Jd7ZW','u571892443_risk_hunter');
}
$con = connect();
if (!$con->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
       die("Error cargando el conjunto de caracteres utf8");
}else{
    echo 'Conectado';
}
?>

