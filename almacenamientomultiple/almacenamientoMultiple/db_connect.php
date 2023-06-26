<?php

/* Database connection start */
$servername = "localhost";
$username = "u571892443_risk_hunter";
$password = "#6mL0I[Jd7ZW";
$dbname = "u571892443_risk_hunter";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}else{
    'conectado';
}

//$mysqli = new mysqli('localhost','u571892443_risk_hunter','#6mL0I[Jd7ZW','u571892443_risk_hunter');
?>