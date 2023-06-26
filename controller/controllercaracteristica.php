<?php 

if(isset($_POST['registrarCaracteristica'])){
    include '../clases/gabriel.class.php';
    $Jsoncaracter     = new gabriel;
    $consulta = $Jsoncaracter->iniciarVariables();

    $nombre = $_POST['nombreCaracteristica'];
    $bien = $_POST['bienes'];
    $idbien = 10;
    $idestado = 1;

    $info[0] = $nombre;
    $info[1] = $idbien;
    $info[2] = $idestado;
    $info[3] = $bien;

    $insertcaracter = $Jsoncaracter->creacaracteristica($info);    

    echo'<script language="javascript">alert("Caracteristica registrada");
    window.location.href="../listacaracteristicas.php"</script>';
}

if (isset($_POST['editarcaracteristica'])) {
    include '../clases/gabriel.class.php';
    $Jsoncaracter     = new gabriel;
    $consulta = $Jsoncaracter->iniciarVariables();
    
    $idcar=$_POST['idcar'];
    $nombre=$_POST['nombre'];
    $bien=$_POST['bienes'];

    $info[0] =$nombre;
    $info[1] =$bien;
    $info[2] =$idcar;

    $editarcaracteristica = $Jsoncaracter->updatecaracteristica($info);

    echo '<script language="javascript">alert("La caracteristica ha sido actualizada.");
        window.location.href="../listacaracteristicas.php"</script>';
}

if(isset($_POST['activarcaracteristica'])){
    include '../clases/gabriel.class.php';
    $Jsoncaracter     = new gabriel;
    $consulta = $Jsoncaracter->iniciarVariables();

     $idcaracteristica = $_POST['idcaracteristica'];    
     $info = $idcaracteristica;

     $desactivacaracteristicas= $Jsoncaracter->activacacteristica($info);
    echo '<script language="javascript">alert("Caracteristica Activada");
        window.location.href="../listarcaracteristicasdesactivadas.php"</script>';       
}

if(isset($_POST['desactivarcaracteristica'])){
    include '../clases/gabriel.class.php';
    $Jsoncaracter     = new gabriel;
    $consulta = $Jsoncaracter->iniciarVariables();
    
     $idcaracteristica = $_POST['idcaracteristica']; 
     $info = $idcaracteristica;   
     $desactivacaracteristicas= $Jsoncaracter->desactivacaracteristica($info);
    echo '<script language="javascript">alert("Caracteristica Desactivada");
        window.location.href="../listacaracteristicas.php"</script>';       
}

?>