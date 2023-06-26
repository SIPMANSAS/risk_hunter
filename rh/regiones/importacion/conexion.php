<?php
//header("Content-Type: text/html;charset=utf-8");
$usuario  = "risk_hunter";
$password = "Kaliman01*";
$servidor = "localhost";
$basededatos = "sipman_risk_hunter";
$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($con,"SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");


//$mysqli=mysqli_connect("localhost","u571892443_CRM_4BR1L_2022","*ql&GF&Ee4I","u571892443_CRM_4BR1L_2022");
