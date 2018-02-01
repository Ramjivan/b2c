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

$json = file_get_contents("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$_POST['ID_Token']);
$obj = json_decode($json);
if($obj->aud == $CLIENT_ID){
  
    
     $row = false;
    $email = mysql_real_escape_string($_POST['Email']);
    $results = mysql_query("select c_email from customers where c_email='$email' ");
    if ($results) {
        //let the user login by assigning session to it
        session_start();
        $_SESSION['user'] = $email;
        
        //redircting user
        if(isset($_POST['redirurl'])) 
        $url = $_POST['redirurl']; // holds url for last page visited.
        else 
        $url = "index.php"; // default page for 

        header("Location:$url");
 }
  
}
