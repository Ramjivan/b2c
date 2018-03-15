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
								
								$order_id = $conn->lastInsertId();
								
								foreach($merchant_ps as $item)
								{
									$stmt = $conn->prepare('insert into `order_list_items` (`pl_id`,`product_id`,`qty`,`price`) VALUES (?,?,?,(SELECT `p_price` FROM `products` where `product_id`=? LIMIT 1))');
									$stmt->execute(array($ord_pl_id,$item['p_id'],$item['qty'],$item['p_id']));
								}
								
								$address = $conn->prepare('INSERT INTO `b2c`.`snap_addresses`
															(`address_id`,
															`customer_id`,
															`adt_fullname`,
															`adt_mob`,
															`adt_pincode`,
															`adt_addressline1`,
															`adt_addressline2`,
															`adt_landmark`,
															`adt_city`,
															`adt_state`,
															`adt_country`,
															`adt_type`,
															`order_id`)
															
															SELECT `address_id`,`customer_id`,`adt_fullname`,`adt_mob`,`adt_pincode`,`adt_addressline1`,`adt_addressline2`,`adt_landmark`,`adt_city`,`adt_state`,`adt_country`,`adt_type`,? FROM `addresses` where `address_id` = ?');
								$address->execute(array($order_id,$indexes['ord_address_id']));
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
		$return_values = array();
		if(isset($_GET['qtype']) && $_GET['qtype'] == 1 && isset($_GET['t']))
		{
			
			try
			{
				
				$timestamp = date('Y-m-d h:m:s',strtotime('-'.$_GET['t'].' days'));
				
				$stmt = $conn->prepare('select *,(select count(*) from `order_list_items` where `pl_id` = `orders`.`ord_pl_id`) AS `pl_count` from `orders` where `merchant_id` = ? && `ord_date_time` >= ?');
				$stmt->execute(array($user['merchant_id'],$timestamp));
			
				if($stmt->rowCount() > 0)
				{	
					$return_values['items'] = $stmt->fetchAll();
					
					$return_values['result'] = 1;
					$return_values['timestamp'] = $timestamp;
				}
				else
				{
					
					$return_values['result'] = $user['merchant_id'];
				}
				
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}	
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == 2) //single order fetch merchant
		{
			
			try
			{
				
				
				$stmt = $conn->prepare('select * from `orders` where `ord_pl_id` = ? LIMIT 1');
				$stmt->execute(array($_GET['t']));
			
				if($stmt->rowCount() > 0)
				{	
					$order = $stmt->fetch();
					
					if($order['merchant_id'] !== $user['merchant_id'])
					{							
						$return_values['ERROR'] = 400;
						$return_values['Message'] = "BAD REQUEST";
						die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
					}
					
					$return_values['items']['orderDetails'] = $order;
					
					$productDetails = $conn->prepare("select (`products`.`p_price`*`order_list_items`.`qty`) AS `total_price`,`order_list_items`.`qty`,`products`.`product_id`,`products`.`p_name` from `products` LEFT JOIN `order_list_items` ON `order_list_items`.`product_id` = `products`.`product_id`  where `pl_id` = ?");
					$productDetails->execute(array($_GET['t']));
					
					$address = $conn->prepare('select * from `addresses` where `address_id` = ?');
					$address->execute(array($order['ord_address_id']));
					
					
					if($address->rowCount() > 0 &&
						$productDetails->rowCount() > 0)
					{
						$return_values['items']['productDetails'] = $productDetails->fetchAll();
						$return_values['items']['address'] = $address->fetch();
						$return_values['result'] = 1;						
					}
					else
					{
						$return_values['ERROR'] = 400;
						$return_values['Message'] = "BAD REQUEST";
					}

				}
				else
				{
					$return_values['ERROR'] = 400;
					$return_values['Message'] = "BAD REQUEST";
				}
				
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}	
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == 3 && isset($_GET['t']))
		{
			
			try
			{
				
				$timestamp = date('Y-m-d h:m:s',strtotime('-'.$_GET['t'].' days'));
				
				$stmt = $conn->prepare('select *,(select count(*) from `order_list_items` where `pl_id` = `orders`.`ord_pl_id`) AS `pl_count` from `orders` where `customer_id` = ? && `ord_date_time` >= ?');
				$stmt->execute(array($user['customer_id'],$timestamp));
			
				if($stmt->rowCount() > 0)
				{	
					$return_values['items'] = $stmt->fetchAll();
					
					$return_values['result'] = 1;
					$return_values['timestamp'] = $timestamp;
				}
				else
				{
					
					$return_values['result'] = 0;
				}
				
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}	
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == 4) //single order fetch merchant
		{
			
			try
			{
				
				
				$stmt = $conn->prepare('select * from `orders` where `ord_pl_id` = ? LIMIT 1');
				$stmt->execute(array($_GET['t']));
			
				if($stmt->rowCount() > 0)
				{	
					$order = $stmt->fetch();
					
					if($order['merchant_id'] !== $user['merchant_id'])
					{							
						$return_values['ERROR'] = 400;
						$return_values['Message'] = "BAD REQUEST";
						die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
					}
					
					$return_values['items']['orderDetails'] = $order;
					
					$productDetails = $conn->prepare("select (`products`.`p_price`*`order_list_items`.`qty`) AS `total_price`,`order_list_items`.`qty`,`products`.`product_id`,`products`.`p_name` from `products` LEFT JOIN `order_list_items` ON `order_list_items`.`product_id` = `products`.`product_id`  where `pl_id` = ?");
					$productDetails->execute(array($_GET['t']));
					
					$address = $conn->prepare('select * from `addresses` where `address_id` = ?');
					$address->execute(array($order['ord_address_id']));
					
					
					if($address->rowCount() > 0 &&
						$productDetails->rowCount() > 0)
					{
						$return_values['items']['productDetails'] = $productDetails->fetchAll();
						$return_values['items']['address'] = $address->fetch();
						$return_values['result'] = 1;						
					}
					else
					{
						$return_values['ERROR'] = 400;
						$return_values['Message'] = "BAD REQUEST";
					}

				}
				else
				{
					$return_values['ERROR'] = 400;
					$return_values['Message'] = "BAD REQUEST";
				}
				
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}	
		}
	}
	
	
	//$today = date('Y-m-d');
	
	//$month = date('Y-m-d h:m:s',strtotime('-30 days'));
	
	
?>