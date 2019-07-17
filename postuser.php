<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$data = apache_request_headers();
if (array_key_exists('token', $data)) {
  $token = $data['token'];
  if ($token == '123') {

	  include('db.php');
  	
    $data = json_decode(file_get_contents("php://input"),true);
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
  	$res = mysql_query("insert into users(first_name,email_id,password) values('$name','$email','$password')");
    $id = mysql_insert_id();

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