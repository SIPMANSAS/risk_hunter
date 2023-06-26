<?php

 include "conexion/conexion.php";
 session_start();
 $usuario = $_SESSION["usuario"];
 
 $eliminaRegistro = $mysqli->query("DELETE FROM temporal WHERE usuario_session='$usuario'");
 
 $cons = 'SELECT * FROM v_ciudades';
 $insertasesiones = $mysqli->query("INSERT INTO sesiones(nombre)VALUES('$usuario')");
 
 $consultaConsescutivo = $mysqli->query("SELECT MAX(identificador) AS Sesion,nombre FROM sesiones WHERE nombre ='$usuario'");
 $extraerData = $consultaConsescutivo->fetch_array(MYSQLI_ASSOC);
 $sesion = $extraerData['Sesion'];
 //echo 'Sesion #: '.$sesion;
 
 $actualizausuario = $mysqli->query("UPDATE sg_usuarios SET usuario_session ='$sesion' WHERE usuario='$usuario'");
 
 $insertaDatos = $mysqli->query("INSERT INTO temporal(query,numero_encuesta,numero_pregunta,parametro1,parametro2,usuario_session)VALUES('$cons','1','1','1','2','$sesion')");
 
 $conteoDatos =$mysqli->query("SELECT COUNT(Codigo) AS Cantidad FROM v_ciudades");
 
 $extarerDatos = $conteoDatos->fetch_array();
 $total = $extarerDatos['Cantidad'];
 

 $consulta = $mysqli->query("SELECT * FROM temporal");
 $data = $consulta->fetch_array(MYSQLI_ASSOC);
 $cons = $data['query'];
 
 
 $datosASeguradora = $mysqli->query("$cons");
 $extaerDatos = $datosASeguradora->fetch_array(MYSQLI_ASSOC);
 echo $info = $extaerDatos['codigo'].' '.$extaerDatos['nombre'];
 
 
 $eliminarDatos = $mysqli->query("DELETE FROM temporal WHERE usuario_session='$sesion'");
 
 /*
 CREATE TEMPORARY TABLE SalesSummary (
    -> product_name VARCHAR(50) NOT NULL
    -> , total_sales DECIMAL(12,2) NOT NULL DEFAULT 0.00
    -> , avg_unit_price DECIMAL(7,2) NOT NULL DEFAULT 0.00
    -> , total_units_sold INT UNSIGNED NOT NULL DEFAULT 0
 */
 
 //$creartablatemporal = $mysqli->query("CREATE TEMPORARY TABLE ")    
    
    
?>