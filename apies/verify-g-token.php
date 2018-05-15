<?php
function create_password($password)
{
    $salt=mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);

    $iteration = rand(0,99999);

    $password = ($password !== null ? $password : substr(md5(microtime()),0,7));
    
    $hash = hash_pbkdf2("sha512",$password,$salt,$iteration,20);
    
    return array('salt' => $salt , 'iteration' => $iteration , 'hash' => $hash);
}
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
if($obj->aud == $CLIENT_ID)
{
    $email = ($_POST['Email']);
    $results = $conn->prepare("select * from `customers` where `c_email`=? LIMIT 1");
    $results->execute(array($email));
	
	if($results->rowCount() > 0) {
        //let the user login by assigning session to it
        $_SESSION['user'] = $results->fetch();
        
        //redircting user
        if(isset($_POST['redirurl']) && !empty($_POST['redirurl'])) 
        {
            Header("Location: ".$_POST['redirurl']); // holds url for last page visited.
        }
        else
        { 
            Header('Location: /index.php'); // default page for 
        }    
	}
	else
	{
        $indexes = array(
            'c_fullname' => $_POST['Full_Name'],
            'c_email' => $_POST['Email'],
             'c_mobile' => 7857366211,
             'merchant_id' => md5(time().$indexes['c_fullname'])
            );

        try
        {
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO `customers` (`c_fullname`,`c_email`,`c_mobile`,`merchant_id`) VALUES (:c_fullname,:c_email,:c_mobile,:merchant_id)");
            $response = $stmt->execute($indexes);
            if($response > 0)
            {
                $customer_id = $conn->lastInsertId();
                $stmt = $conn->prepare('INSERT INTO `wallet` (`customer_id`) VALUES (?)');
                $response = $stmt->execute(array($customer_id));
                if($response)
                {
                    echo 1;
                    $pass_arr = create_password('testrandom');
                    $pass_arr['customer_id'] = $customer_id;
                    $stmt = $conn->prepare('INSERT INTO `_tbl_pass` (`customer_id`,`salt`,`hash`,`iteration`) VALUES (:customer_id,:salt,:hash,:iteration)');
                    $response = $stmt->execute($pass_arr); 
                    if($response)
                    {
                        $conn->commit();
                        Header('Location: /index.php');

                    }
                }
            }
            else
            {
                echo 1;
               Header('Location: 404.php');
            }	
        }	
        catch(PDOException $e)
        {
            $conn->rollBack();
            $return_values = $e->getMessage();
            echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

    }
  
}else{
    Header('Location: 404.php');
}
?>