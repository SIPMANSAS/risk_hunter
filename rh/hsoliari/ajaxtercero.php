<?php
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'hsoliari');

$connexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

$html = '';
$key = $_POST['key'];
$setid = "001";

$result = $connexion->query(
    'SELECT id_tercero, numdoc, nombres, email, celular , pais_res , eps FROM tbl_terceros p
     WHERE setid="'. $setid . '" and  numdoc LIKE "%'.strip_tags($key).'%"
    ORDER BY numdoc LIMIT 5'
);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $amostrar = $row['numdoc'] . "/" . $row['nombres'];
        $html .= '<div><a class="suggest-element" cedula="'.$row['numdoc'].'" nombre="'.$row['nombres'].'" email="'.$row['email'].
        '" telefono="'.$row['celular'].'" pais="'.$row['pais_res'].'" eps="'.$row['eps'].'" data="'.utf8_encode($amostrar).'" id="'.$row['id_tercero'].'">'
        .utf8_encode($amostrar).'</a></div>';
    }
}
echo $html;


?>
