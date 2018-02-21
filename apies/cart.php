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

function in_cart($pid)
{
	include('pdo.php');
	try
	{
		$stmt = $conn->prepare('select * from `p_cart` where `p_id` = ?');
		$stmt->execute(array($pid));
		if($stmt->rowCount() > 0)
		{
			return true;
		}
		return false;
	}
	catch(PDOException $e)
	{
		return false;
	}
}

function get_single_cart_item($item_id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select `customer_id` from `p_cart` where `item_id` = ? LIMIT 1');
		$stmt->execute(array($item_id));
		if($stmt->rowCount() > 0)
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

function get_cart($customer_id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select * from `p_cart` where `customer_id` = ?');
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

function get_product($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select * from `products` where `product_id` = ? LIMIT 1');
		$stmt->execute(array($id));
		if($stmt->rowCount() > 0)
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

	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
		{
			$ERROR_FLAG = 0;
			
			$return_values = array();
			
			
			$indexes = array(
			'p_id' => '',
			'qty' => ''
			);
	
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG,'GET');
			}
				
			if($ERROR_FLAG == 0 && !in_cart($_GET['p_id']) && ($product = get_product($_GET['p_id'])) !== null)
			{
				try
				{
					$indexes['customer_id'] = $user['customer_id'];
					$indexes['merchant_id'] = $product['Merchant_id'];
					
					$conn->beginTransaction();
					$stmt = $conn->prepare("INSERT INTO `p_cart` (`p_id`,`qty`,`customer_id`,`merchant_id`) VALUES (:p_id,:qty,:customer_id,:merchant_id)");
					$response = $stmt->execute($indexes);
					if($response > 0)
					{
						$return_values['success'] = 1;
						$conn->commit();
					}
					else
					{
						$return_values['ERROR'] = "DB ERROR.";
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
				if(!$ERROR_FLAG)
				{	
					$return_values['ERROR'] = 1;
					$return_values['MESSAGE'] = "Already in cart.";
				}
				else
				{
					$return_values['ERROR'] = 1;
					$return_values['MESSAGE'] = "Sorry Something went wrong.";
				
				}
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2') //EDIT
		{
			
			if(isset($_GET['item_id']) && !empty($_GET['item_id']))
			{
				if(isset($_GET['qty']) && !empty($_GET['qty']) && is_numeric($_GET['qty']))
				{
					$row = get_single_cart_item($_GET['item_id']);
					if($row !== null && $row['customer_id'] == $user['customer_id']) 
					{
						try
						{
							$conn->beginTransaction();
							$stmt = $conn->prepare('UPDATE `p_cart` SET `qty` = ? WHERE `item_id` = ?');
							$response = $stmt->execute(array($_GET['qty'],$_GET['item_id']));
							if($response == 1)
							{
								$conn->commit();
								$return_values['success'] = 1;
							}
							else
							{
								$return_values['ERROR'] = "DB ERROR";
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
						$return_values["ERROR"]="Permisson Denied";
					}
				}
				else
				{
					$return_values['ERROR'] = "Parameters missing.";
				}
				
			}
			else
			{
				$return_values['ERROR'] = "Parameters missing.";				
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '3')  // GET
		{
			$cart = get_cart($user['customer_id']);
			$return_values = array();
			$i = 0;
			if($cart !== null)
			{
				
				foreach($cart as $cartItem)
				{
					
					if(($product = get_product($cartItem['p_id'])) !== null)
					{
						$stmt = $conn->prepare('select `img_name`,`img_dir` from `images` where `img_list_id`=? LIMIT 1');
						$stmt->execute(array($product['img_list_id'])); 
						
						if($stmt->rowCount() > 0)
						{	
							$return_values['result'] = 1;
							
							$img = $stmt->fetch();

							$return_values['items'][$i] = array(
															'product_id' => $product['product_id'],
															'p_name' => $product['p_name'],
															'qty' => $cartItem['qty'],
															'stock' => ($product['p_stock'] > 0 ? 1 : 0),
															'price' => $product['p_price'],
															'item_id' => $cartItem['item_id'],
															'img' => $img['img_dir'].$img['img_name']
														);

							$i++;
						}
						else
						{
							$return_values['result'] = 0;
							$return_values['MESSAGE'] = "Empty Cart.";						
						}
					}
					else
					{
						$return_values['result'] = 0;
						$return_values['MESSAGE'] = "Empty Cart.";						
					}
				}
			}
			else
			{
				$return_values['result'] = 0;
				$return_values['MESSAGE'] = "Empty Cart.";
			}
		
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '4') //DELETE
		{
			if(isset($_GET['item_id']) && !empty($_GET['item_id']))
			{
				$row = get_single_cart_item($_GET['item_id']);
				if($row !== null && $row['customer_id'] == $user['customer_id']) 
				{
					try
					{
						$conn->beginTransaction();
						$stmt = $conn->prepare('DELETE FROM `p_cart` WHERE `item_id` = ?');
						$response = $stmt->execute(array($_GET['item_id']));
						if($response == 1)
						{
							$conn->commit();
							$return_values['success'] = 1;
						}
						else
						{
							$return_values['ERROR'] = "DB ERROR";
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
					$return_values["ERROR"]="Permisson Denied";
				}
			}
			else
			{
				$return_values['ERROR'] = "Parameters missing.";
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	}
?>