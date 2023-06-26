<?php

include '../conexions.php';

if(isset($_POST['asignarinspectores'])){
    'Compa単ia Seguros: '.$companiaseguros = $_POST['companiaseguros'];
    '<br>';
    'Firma Id: '.$idfirma = $_POST['identificador'];
    'Firma Inspectora Check:'.$firmainspectora = $_POST['firmainspectora'];
    '<br>';
    
    
    for($i=0; $i <= count($firmainspectora);$i++){
        if($firmainspectora == 0){
            echo '<script>alert("Algunos Campos estan vacios")
             window.location.href="../listacompaniaseguros.php"</script>';
            
        }else{
           $eliminavacios = $mysqli->query("DELETE FROM sg_usuarios_x_cliente WHERE id_usuario=0");
           $insertaDatos = $mysqli->query("INSERT INTO sg_usuarios_x_cliente(id_cliente,id_usuario,tipo_estado,estado)VALUES('$companiaseguros','$firmainspectora[$i]','13',1)");
           echo '<script language="javascript">alert("Inspector Asignado.");
    window.location.href="../listafirmasinspectoras.php"</script>';
        }
    }
    
}
?>