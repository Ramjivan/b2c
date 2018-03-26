<?php
session_start();

include('sessionvalidate.php');

include('functions.php');

$user = $_SESSION['user'];

include('pdo.php');


function is_set(&$var,$index,&$ERROR_FLAG)
{
	if(isset($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}
	else
	{
		$ERROR_FLAG = true;
		echo $index;
	}
}

function get_product($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select `p_price` from `products` where `product_id` = ? LIMIT 1');
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


if($_SERVER['REQUEST_METHOD'] == "GET")
{
    if(isset($_GET['qtype']) && $_GET['qtype'] == "1")
    {
        try
        {
            $return_values = array();
            
            $i = 0;

            $cart = get_cart($user['customer_id']);
            if($cart !== null)
            {
                
                $return_values['result'] = 1;
                $total = 0;
                foreach($cart as $cartItem)
                {
                    if(($product = get_product($cartItem['p_id'])) !== null)
                    {						
                    	
                        $total += $cartItem['qty'] * $product['p_price'];
                    
                    }
                    else
                    {
                        $return_values['result'] = 0;
                        $return_values['MESSAGE'] = "Empty Cart.";						
                    }
                }

                if(($wallet = get_wallet($user['customer_id'])) !== null)
                {
                    if($wallet['balance'] < $total)
                    {
                        $return_values['op'] = 1;
                    }
                    else
                    {
                        $return_values['op'] = 0;
                    }
                }
                else
                {
                    $return_values['ERROR'] = 400;
                    $return_values['MESSAGE'] = "Forbidden";						
                }

                $return_values['wallet']['balance'] = $wallet['balance'];
            }
            else
            {
                $return_values['result'] = 0;
                $return_values['MESSAGE'] = "Empty Cart.";
            }
            echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        catch(PDOException $e)
        {
            $return_values = array();
            $return_values['ERROR'] = 400;
            die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }
    }
}