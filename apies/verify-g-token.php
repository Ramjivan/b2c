<?php
session_start();
/*echo $_POST['ID'];
echo $_POST['Full_Name'];
echo $_POST['First_Name'];
echo $_POST['Last_Name'];
echo $_POST['Image_URL'];
echo $_POST['Email'];
echo $_POST['ID_Token'];*/

require 'pdo.php';
$CLIENT_ID = '340871764456-pqe4gcc4c2ojfkreg031uelvcs9b19c6.apps.googleusercontent.com';

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  


$json = file_get_contents("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$_POST['ID_Token'], false, stream_context_create($arrContextOptions));
$obj = json_decode($json);
if($obj->aud == $CLIENT_ID){
  
    
    $email = ($_POST['Email']);
    $results = $conn->prepare("select * from customers where `c_email`=? LIMIT 1");
    $results->execute(array($email));
	
	if($results->rowCount() > 0) {
        //let the user login by assigning session to it
        $_SESSION['user'] = $results->fetch();
        
        //redircting user
        if(isset($_POST['redirurl'])) 
        $url = $_POST['redirurl']; // holds url for last page visited.
        else 
        $url = "index.php"; // default page for 

        Header("Location:/b2c/index.php");
	}
	else
	{
		echo "no user";
	}
  
}
