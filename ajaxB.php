<?php

define ('DB_USER', "u571892443_risk_hunter");
define ('DB_PASSWORD', "#6mL0I[Jd7ZW");
define ('DB_DATABASE', "u571892443_risk_hunter");
define ('DB_HOST', "localhost");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$sql = "SELECT * FROM enc_lista_valores 
		WHERE valor_alfa_numerico LIKE '%".$_GET['q']."%' AND id_respuesta = '5'"; 
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['identificador'], 'text'=>$row['valor_alfa_numerico']];
}
echo json_encode($json);
?>