<?php

require_once __DIR__ . '/db_connect.php';
 
// connecting to db


function geturl($short){
  $conexion = new DB_CONNECT();
  $consulta = "SELECT larga FROM `guardar` WHERE short = '$short'";
  $larga = mysqli_query($conexion->connect(), $consulta);
  return $larga;
}

$result = geturl('http://localhost/3TBsd4');

while ($row = mysqli_fetch_array($result)) {
  echo $row["larga"];
}

?>