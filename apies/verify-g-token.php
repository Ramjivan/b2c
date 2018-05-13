<?php
session_start();
echo $_POST['ID'];
echo $_POST['Full_Name'];
echo $_POST['First_Name'];
echo $_POST['Last_Name'];
echo $_POST['Image_URL'];
echo $_POST['Email'];
echo $_POST['ID_Token'];

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
    $results = $conn->prepare("select * from customers where `c_email`=? LIMIT 1");
    $results->execute(array($email));
	
	if($results->rowCount() > 0) {
        //let the user login by assigning session to it
        $_SESSION['user'] = $results->fetch();
        
        //redircting user
        if(isset($_POST['redirurl'])) 
        {
            $url = $_POST['redirurl']; // holds url for last page visited.
        }
        else
        { 
            $url = "index.php"; // default page for 
        }    
        
        Header("Location:".$url);
	}
	else
	{
        $indexes = array(
            'c_fullname' => $_POST['Full_Name'],
            'c_email' => $POST['Email'],
             'c_mobile' => 7857366211,
            );

        try
        {
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO `customers` (`c_fullname`,`c_email`,`c_mobile`,`merchant_id`) VALUES (:c_fullname,:c_email,:c_mobile,:merchant_id)");
            $response = $stmt->execute($indexes);
            if($response)
            {
                $customer_id = $conn->lastInsertId();
                $stmt = $conn->prepare('INSERT INTO `wallet` (`customer_id`) VALUES (?)');
                $response = $stmt->execute(array($customer_id));
                if($response)
                {
                    $pass_arr = create_password('testrandom');
                    $pass_arr['customer_id'] = $customer_id;
                    $stmt = $conn->prepare('INSERT INTO `_tbl_pass` (`customer_id`,`salt`,`hash`,`iteration`) VALUES (:customer_id,:salt,:hash,:iteration)');
                    $response = $stmt->execute($pass_arr); 
                    if($response)
                    {
                        $conn->commit();

                    }
                }
            }
            else
            {
                $return_values['ERROR']['insert'] = "FATAL ERROR.";
            }	
        }	
        catch(PDOException $e)
        {
            $conn->rollBack();
            $return_values['ERROR']['insert'] = $e->getMessage();
            echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

    }
  
}
?>