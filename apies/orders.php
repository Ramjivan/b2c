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
			echo $index;
			$ERROR_FLAG = true;
		}
	}
}
function get_cart($customer_id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select `p_id`,`qty`,`merchant_id` from `p_cart` where `customer_id` = ?');
		$stmt->execute(array($customer_id));
		if($stmt->rowCount() > 0)
		{
			return $stmt->fetchAll();
		}
		return null;
	}
	catch(PDOException $e)
	{
		return null;
	}
}

function get_merchant($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select distinct `merchant_id` from `p_cart` where `customer_id` = ?');
		$stmt->execute(array($id));
		if($stmt->rowCount() > 0)
		{
			return $stmt->fetchAll();
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
		$return_values = array();
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
		{
			$ERROR_FLAG = 0;
			
			$merchant_ids = array();
			
			$indexes = array(
			'ord_payment_method' => '',
			'ord_address_id' => ''
			);
			
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
			}
			if(!$ERROR_FLAG)
			{
				$cart = get_cart($user['customer_id']);
				$i=0;
				
				$merchant_ids = get_merchant($user['customer_id']);
				
				$conn->beginTransaction();
				if(count($merchant_ids) > 0)
				{
					foreach($merchant_ids as $merchant_id)  //loop through $merchant_ids and create orders for each merchant
					{
						$merchant_ps = array();
						foreach($cart as $cartItem)
						{
							if($merchant_id['merchant_id'] == $cartItem['merchant_id'])
							{
								array_push($merchant_ps,$cartItem);
							}
						}
						
					//real logic
							
						try
						{
							
							
							if(count($merchant_ps) > 0)
							{
								$ord_pl_id = md5(time().rand(0,1000));
								$stmt_ord = $conn->prepare(
									'insert into `orders`
									(
									`customer_id`,
									`merchant_id`,
									`ord_payment_method`,
									`ord_address_id`,
									`ord_pl_id`
									)
									VALUES
									(?,?,?,?,?)');
									
								$stmt_ord->execute(array($user['customer_id'],$merchant_id['merchant_id'],$indexes['ord_payment_method'],$indexes['ord_address_id'],$ord_pl_id));
								
								
								foreach($merchant_ps as $item)
								{
									$stmt = $conn->prepare('insert into `order_list_items` (`pl_id`,`product_id`,`qty`) VALUES (?,?,?)');
									$stmt->execute(array($ord_pl_id,$item['p_id'],$item['qty']));
								}
							}
							else
							{
								die(json_encode(array('ERROR' => '501')));
							}
						}
						catch(PDOException $e)
						{
							$conn->rollBack();
							$return_values['ERROR']['insert'] = $e->getMessage();
							die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
						}
						
						
						
					//real logic
					
						
					}
					
					$stmt = $conn->prepare('delete from `p_cart` where `customer_id` = ?');
					if($stmt->execute(array($user['customer_id'])))
					{
						$conn->commit();
						$return_values['success'] = 1;
					}
					else
					{
						$conn->rollBack();
						$return_values['ERROR'] = '501';
					
					}
				}
				else
				{
					$conn->rollBack();
					$return_values['ERROR'] = '400';
				}
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		
	}
?>