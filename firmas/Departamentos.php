
<?php
//include "../comboPaises/conexion/Conexion.php";
function connect()
{
  return new mysqli("localhost", "risk_hunter", "Kaliman01*", "sipman_risk_hunter");

}

$db = connect();

//$query = $db->query("select * from pais where continente_id=$_GET[continente_id]");
$query = $db->query("select * from rg_departamentos where codigo_pais=$_GET[paises_id]");
$states = array();
while ($r = $query->fetch_object()) {
  $states[] = $r;
}
if (count($states) > 0) {
  print "<option value=''>-- SELECCIONE --</option>";
  foreach ($states as $s) {
    print utf8_encode("<option value='$s->codigo'>$s->nombre</option>");
  }
} else {
  print "<option value=''>-- NO HAY DATOS --</option>";
}
