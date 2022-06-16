<?php
header("Content-Type:application/json");
$postdata = json_decode(file_get_contents("php://input"), true);
require_once __DIR__ . '/db_connect.php';
 
//include("conenexion.php");
$larga = $postdata['larga'];
function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;

}

//include("conenexion.php");
#$response = [] ;
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
  // connecting to db
  $conexion = new DB_CONNECT();
  $insertar = "INSERT INTO guardar (larga, short) VALUES('$larga','$short')";
  $resultado = mysqli_query($conexion->connect(), $insertar);
  response(200,"ok",$short);
} catch (Exception $e) {
  response(500,"error",$e->getMessage);
}
?>