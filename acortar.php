<?php

$postdata = json_decode(file_get_contents("php://input"), true);
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$conexion = new DB_CONNECT();

//include("conenexion.php");
$larga = $postdata["larga"];

$response = array();
//$short=$postdata["short"];

function base62($num) {
  $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $res = '';
  do {
    $res = $index[$num % 62] . $res;
    $num = intval($num / 62);
  } while ($num);
  return $res;
}

function shorten($long_url) {
    $strcrc32 = crc32($long_url);
    return base62($strcrc32);
}

$short = "http://localhost/".shorten($larga);
try {
  $insertar = "INSERT INTO guardar (larga, short) VALUES('$larga','$short')";
  $resultado = mysqli_query($conexion->connect(), $insertar);
  $response["success"] = 1;
  $response["corta"] = $short;
} catch (Exception $e) {
  $response["success"] = 0;
  $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>