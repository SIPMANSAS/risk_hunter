<?php

define ('DB_USER', "u571892443_risk_hunter");
define ('DB_PASSWORD', "#6mL0I[Jd7ZW");
define ('DB_DATABASE', "u571892443_risk_hunter");
define ('DB_HOST', "localhost");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$sql = "SELECT * FROM ter_terceros 
		WHERE nombres LIKE '%".$_GET['q']."%'
		LIMIT 10"; 
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['identificacion'], 'text'=>$row['nombres']];
}
echo json_encode($json);
?>