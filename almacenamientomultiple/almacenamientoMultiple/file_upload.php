<?php 

require_once '../../conexion/conexion.php';
if(!empty($_FILES)){
    $upload_dir = "uploads/";
    $fileName = $_FILES['file']['name'];
    $uploaded_file = $upload_dir.$fileName;
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
        $insertaDatos = $mysqli->query("INSERT INTO uploads(file_name,upload_time) VALUES('".$fileName."','".date("Y-m-d H:i:s")."')");
		//$mysql_insert = "INSERT INTO uploads (file_name, upload_time)VALUES('".$fileName."','".date("Y-m-d H:i:s")."')";
		//mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
    }   
}

