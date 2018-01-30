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
		$stmt = $conn->prepare('select `p_id`,`qty` from `p_cart` where `customer_id` = ?');
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
		$stmt = $conn->prepare('select `merchant_id` from `products` where `product_id` = ? LIMIT 1');
		$stmt->execute(array($id));
		if($stmt->rowCount() > 0)
		{
			return $stmt->fetch()['merchant_id'];
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
			$ERROR_FLAG = 0;
			
			$ord_pl_id = md5(time().rand(0,1000));
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
				foreach($cart as $cart_item)
				{
					$merchant_id = get_merchant($cart_item['p_id']);
					if($merchant_id !== null)
					{					
						$merchant_ids[$i] = $merchant_id; 
					}
					else
					{
						die(json_encode(array('ERROR'=>'501'),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
					}
					$i++;
				}
				
				echo json_encode(array('ord_pl_id'=>$ord_pl_id,'merchant_id'=>$merchant_ids,'cart'=>$cart,'post_vars'=>$indexes));
			}
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		
	}
?>