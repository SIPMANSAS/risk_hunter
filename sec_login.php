<?php
session_start();
$usuario_login=$_SESSION["usuario"];
    if(!isset($usuario_login)) 
        header("location: log.php");         
?>
