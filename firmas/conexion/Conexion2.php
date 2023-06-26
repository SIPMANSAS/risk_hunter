<?php
// simple conexion a la base de datos
function connect()
{
  return new mysqli("localhost", "risk_hunter", "Kaliman01*", "sipman_risk_hunter");

}
