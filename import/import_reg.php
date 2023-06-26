<?php

if(isset($_POST['grabar']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo '1. Cargando nombre del archivo: '.$fname.' <br>';
    $chk_ext = explode('.',$fname);

    if(strtolower(end($chk_ext)) == 'csv')
    {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $nombre_final_archivo='cargado.csv';
        if (move_uploaded_file($_FILES['sel_file']['tmp_name'],$nombre_final_archivo))
        {
            //unlink('base.txt');
            echo 'Aviso: El archivo ha sido cargado correctamente.<br>';
            // numero del error para mostrar el paso
            $error_estado=2;
        }else{
            echo "Error: Ocurrió algún error al subir el fichero. No pudo guardarse. Intentelo de nuevo <br>";
        }
        echo '2. empezando cargue: '.$nombre_final_archivo.' <br>';
        $sql = "LOAD DATA LOCAL INFILE 'cargado.csv' REPLACE INTO TABLE import FIELDS TERMINATED BY ';' LINES TERMINATED BY \r\n'
IGNORE 1 LINES (id, nombre, telefono, correo)";
        $db_host = 'localhost';
        $database = 'sipman_risk_hunter';
        $db_user = 'risk_hunter';
        $db_pass = 'Kaliman01*';
        $table = 'import';
        if (!mysqli_connect($db_host, $db_user, $db_pass))  die("No se pudo establecer conexión a la base de datos");        mysqli_query($sql) or die(mysqli_error());
        echo '3. cargue completo <br>';
    }else{
//si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para //ver si esta separado por " , "
    echo 'Archivo invalido!';
    }
}

?>