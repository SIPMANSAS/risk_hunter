<?php

include '../conexion/conexion.php';

if(isset($_POST['registrarparametrizacion'])){
    $asunto = $_POST['asunto'];
    $texto = $_POST['texto'];
    $remitente = $_POST['remitente'];
    $cc = $_POST['cc'];
    $textoof = $_POST['textoof'];
    
    $consultaidentificadormaximo = $mysqli->query("SELECT MAX(identificador) AS Ultimo FROM ad_comunicaciones");
    $extraerdatosconsulta = $consultaidentificadormaximo->fetch_array(MYSQLI_ASSOC);
    $ultimo = $extraerdatosconsulta['Ultimo']+1;
    
    $insertadatos = $mysqli->query("INSERT INTO ad_comunicaciones(identificador,vdom_canal,asunto,texto,textof,remitente,cc,tipo_estado,estado) VALUES ('$ultimo','1','$asunto','$texto','$textoof','$remitente','$cc','21','1')");
    echo '<script language="javascript">alert("Comunicación Registrada Correctamente.");
        window.location.href="../parametrizacion.php"</script>';

}


if(isset($_POST['actualizarparametrizacion'])){
    $asunto = $_POST['asunto'];
    $texto = $_POST['texto'];
    $remitente = $_POST['remitente'];
    $cc = $_POST['cc'];
    $textoof = $_POST['textoof'];
    $identificador = $_POST['identificador'];
    
    $actualizadatos = $mysqli->query("UPDATE ad_comunicaciones SET asunto='$asunto',texto='$texto',textof='$textoof',remitente='$remitente',cc='$cc' WHERE identificador ='$identificador'");
    
    echo '<script language="javascript">alert("Comunicación Actualizada Correctamente.");
        window.location.href="../parametrizacion.php"</script>';
    
}


if(isset($_POST['desactivarparametrizacion'])){
    echo 'ENTRO';
     $identificador = $_POST['id_parametrizacion'];
     
     $desactivarparametrizacion = $mysqli->query("UPDATE ad_comunicaciones SET estado='0' WHERE identificador ='$identificador'");
    
    echo '<script language="javascript">alert("Comunicación Desactivada Correctamente.");
        window.location.href="../parametrizacionesinactivas.php"</script>';
}

if(isset($_POST['activarparametrizacion'])){
    echo 'ENTRO';
     $identificador = $_POST['id_parametrizacion'];
     
     $desactivarparametrizacion = $mysqli->query("UPDATE ad_comunicaciones SET estado='1' WHERE identificador ='$identificador'");
    
    echo '<script language="javascript">alert("Comunicación Activada Correctamente.");
        window.location.href="../parametrizacion.php"</script>';
}



?>