<?php 

require_once 'conexion/conexion.php';
if(!empty($_FILES)){
    $id_inspeccion = $_POST['id_inspeccion'];
    $upload_dir = "archivos/";
    $fileName = $_FILES['file']['name'];
    $pie_imagen = $_POST['pie_imagen'];
    $uploaded_file = $upload_dir.$fileName;
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
        $insertaDatos = $mysqli->query("INSERT INTO enc_imagenes_inspeccion(id_inspeccion,archivo,pie_de_imagen) VALUES('$id_inspeccion','".$fileName."','$pie_imagen')");
		//$mysql_insert = "INSERT INTO uploads (file_name, upload_time)VALUES('".$fileName."','".date("Y-m-d H:i:s")."')";
		//mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
    }   
}

