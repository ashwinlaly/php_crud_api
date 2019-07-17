<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$data = apache_request_headers();
if (array_key_exists('token', $data)) {
  $token = $data['token'];
  if ($token == '123') {
	include('db.php');
	$id = $_GET['id'];
	
	$data = json_decode(file_get_contents("php://input"),true);
	mysql_query("update users set first_name = '".$data['name']."' where user_id = '".$id."' ");

  	$data = mysql_query("select * from users where user_id = '".$id."' ") or die('query error');
  	while ($row = mysql_fetch_object($data)) {
  		echo json_encode($row);
  	}
  } else {
      $error = array('message' => 'invalid access');
      echo json_encode($error);
  }
} else {
    $error = array('message' => 'invalid access');
    echo json_encode($error);    
}

?>