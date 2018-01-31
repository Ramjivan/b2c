<?php
require_once 'b2c/google-api-php-client-master/src/Google/autoload.php';

if(isset($_POST['token_id'])){
    $id_token = $_POST['token_id'];
}
else{
    return 'BAD REQUEST: NO TOKEN ID WAS PASSED!';
}

$CLIENT_ID = '340871764456-pqe4gcc4c2ojfkreg031uelvcs9b19c6.apps.googleusercontent.com';

$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
  // If request specified a G Suite domain:
  //$domain = $payload['hd'];
} else {
  // Invalid ID token
}
?>