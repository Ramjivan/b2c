<?php
session_start();
include('pdo.php');
include('sessionvalidate.php');
$user = $_SESSION['user'];

function is_set(&$var,$index,&$ERROR_FLAG,$method)
{
	if($method == "POST")
	{
		if(isset($_POST[$index]))
		{
			$var = trim($_POST[$index]);
		}
		else
		{
			$ERROR_FLAG = true;
		}	
	}
	else if($method == "GET")
	{
		if(isset($_GET[$index]) && !empty($_GET[$index]))
		{
			$var = trim($_GET[$index]);
		}
		else
		{
			$ERROR_FLAG = true;
		}
	}
}

function validate_wallet($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select * from `wallet` where `customer_id`=? LIMIT 1');
		$response = $stmt->execute(array($id));
		
		if($response > 0 && $stmt->rowCount() > 0)
		{
			return $stmt->fetch();
		}
		return null;
	}
	catch(PDOException $e)
	{
		return null;
	}
}
function get_wallet($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select * from `wallet` where `customer_id`=? LIMIT 1');
		$response = $stmt->execute(array($id));
		
		if($response > 0 && $stmt->rowCount() > 0)
		{
			return $stmt->fetch();
		}
		return null;
	}
	catch(PDOException $e)
	{
		return null;
	}
}


		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
			{
				$return_values = array();
				$ERROR_FLAG = 0;
				
				$indexes = array(
							'balance'=>'',
							'mob'=>''
				);

				foreach($indexes as $index => $value)
				{
					is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
				}
				
				try
				{
					$stmt = $conn->prepare('select `customer_id` from `customers` where `c_mobile` = ? LIMIT 1');
					$stmt->execute(array($indexes['mob']));
					if($stmt->rowCount() > 0)
					{
						$indexes['customer_id'] =$stmt->fetch()['customer_id'];
					}
					else
					{
						die('');
					}
				}
				catch(PDOException $e)
				{
					$return_values['ERROR']['insert'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
				
				if($ERROR_FLAG == 0)
				{
					if( ($user_wallet = validate_wallet($indexes['customer_id']) ) !== null && ( $current_user_wallet = get_wallet($user['customer_id']) ) !==  null)
					{
						try
						{
							
							$current_balance = $current_user_wallet['balance'];
							if($current_balance > 0 && $current_balance >= $indexes['balance'])
							{
								
								//upadating the sending customer wallet
								$new_balance = $current_balance - $indexes['balance'];
								
								$conn->beginTransaction();
								
								$update_cur = $conn->prepare('UPDATE `wallet` SET `balance`=? WHERE `wallet_id` = ?');
								
								$update_cur->execute(array($new_balance,$current_user_wallet['wallet_id']));
								
								//updating recieving customer wallet
								$new_balance = $user_wallet['balance'] + $indexes['balance'];
								$update_rec = $conn->prepare('UPDATE `wallet` SET `balance`=? WHERE `wallet_id` = ?');
								$update_rec->execute(array($new_balance,$user_wallet['wallet_id']));
								
								//adding in_txn tuple
								$txn_id = substr(md5(time()),0,10);
								$in_txn = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`, `txn_credit_wallet_id`, `txn_debit_wallet_id`) VALUES (?,?,?,?)');
								$in_txn->execute(array($txn_id,$indexes['balance'],$current_user_wallet['wallet_id'],$user_wallet['wallet_id']));
								//adding in_txn tuple
								
								
								if($update_cur->rowCount() && $update_rec->rowCount() && $in_txn->rowCount())
								{
									$conn->commit();
									$return_values['success'] = 1;
								}
								else
								{
									$conn->rollBack();
									$return_values['ERROR'] = "DB ERROR";
								}
							}
							else
							{
								$return_values['ERROR'] = "700";
								$return_values['DIFFERENCE'] = $indexes['balance'] - $current_balance;
							}
						}
						catch(PDOException $e)
						{
							$conn->rollBack();
							$return_values['ERROR']['insert'] = $e->getMessage();
							die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
						}
					}
					else
					{
						$return_values['ERROR'] = "DB ERROR";
					}
				}
				else
				{
					$return_values['ERROR'] = '501';
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		}
?>