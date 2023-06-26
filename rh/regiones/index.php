<?php

session_start();
include "clases/Json.class.php";

// se inicia a validar

if (isset($_POST['entrar']))
{
   $usuario = $_POST["usuario"];
   $password = $_POST["password"];
      
    $Json     = new Json;
    $Json->iniciarVariables();
    $xcomplogin = $Json->validarlogin($usuario,$password);
    $flagprimeravez = $Json->obtener_fila($xcomplogin);
    $flag = $flagprimeravez["flag_primera_vez"];
    if (isset($flagprimeravez["flag_primera_vez"]))
    {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
        
        if ($flagprimeravez["flag_primera_vez"] == 0)
             header("location: primeravez.php");   
        else 
             header("location: menu.php");      
    }
    else 
    {
        echo "<div> Error de autenticacion. Revise usuario, password y que la cuenta se encuentre activa </div>";
        header("location: log.php");
        
    }
      
}

?>
