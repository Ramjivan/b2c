<?php
ini_set('display_errors', 1);
session_start();
include('pdo.php');
include('functions.php');
function is_set_strict(&$var,$index,&$ERROR_FLAG)
{
		
	if(isset($_POST[$index]) && !empty($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}
	else
	{
		$ERROR_FLAG = true;
	}
	
}

function is_set(&$var,$index,&$ERROR_FLAG)
{	
	if(isset($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}else
	{
		$ERROR_FLAG = true;
			echo $index." "; 
	}
	
	
}

function email_exist($email){
	include("pdo.php");
	try
	{
		$stmt = $conn->prepare('select `customer_id` from `customers` where `c_email` = ? LIMIT 1');
		$stmt->execute(array($email));
		if($stmt->rowCount() > 0)
		{
			return true;
		}
		return false;
	}
	catch(PDOException $e){
		$return_values['ERROR'] = $e->getMessage();
		die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
	}
}

function phone_exist($phone){
	include("pdo.php");
	try
	{
		$stmt = $conn->prepare('select `customer_id` from `customers` where `c_mobile` = ? LIMIT 1');
		$stmt->execute(array($phone));
		if($stmt->rowCount() > 0)
		{
			return true;
		}
		return false;
	}
	catch(PDOException $e){
		$return_values['ERROR'] = $e->getMessage();
		die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
	}
}

	$QTYPE = "";
	
	$id = "";
	
	$return_values = array();
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!isset($_POST['scus'])) // the customer id for edit request
		{
			if(isset($_POST['pwd']) && !empty($_POST['pwd'])) // customer type
			{	
				$ERROR_FLAG = 0;

				$indexes = array(
				'c_fullname' => '',
				'c_email' => '',
 				'c_mobile' => '',
				);

				foreach($indexes as $index => $value)
				{
					is_set($indexes[$index],$index,$ERROR_FLAG);
				}
				
				$indexes['merchant_id'] = "NULL";
				
				if($ERROR_FLAG == 0)
				{

					if(email_exist($indexes['c_email']))
					{
						$return_values = array();
						$return_values['ERROR'] = true;
						$return_values['MESSAGE'] = "E-mail Address Already Registered";
						die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));		
					}

					if(phone_exist($indexes['c_mobile']))
					{
						$return_values = array();
						$return_values['ERROR'] = true;
						$return_values['MESSAGE'] = "Phone Number Already Registered";
						die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
					}

					try
					{
						
						if(isset($_POST['ctus']) && $_POST['ctus'] == 1)
						{
							if($_POST['ctus'] == 1)
							{
								$indexes['merchant_id'] = md5(time().$indexes['c_fullname']);
							}
						}
						
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
								$pass_arr = create_password($_POST['pwd']);
								$pass_arr['customer_id'] = $customer_id;
								$stmt = $conn->prepare('INSERT INTO `_tbl_pass` (`customer_id`,`salt`,`hash`,`iteration`) VALUES (:customer_id,:salt,:hash,:iteration)');
								$response = $stmt->execute($pass_arr); 
								if($response)
								{
									$conn->commit();
									$return_values['success'] = 1;
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
						die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
					}
				}
			}
		}
		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$user = $_SESSION['user'];
		try
		{
			$conn->beginTransaction();
			$stmt = $conn->prepare("SELECT * FROM `customers` WHERE `customer_id` = ?");
			$response = $stmt->execute(array($user['customer_id']));
			if($response)
			{
				
				$conn->commit();
				$return_values = $stmt->fetch();
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
			die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
		}

		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
?>