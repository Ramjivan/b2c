<?php
session_start();
include('pdo.php');
include('sessionvalidate.php');
$user = $_SESSION['user'];

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
		return array();
	}
	catch(PDOException $e)
	{
		return array();
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
		return array();
	}
	catch(PDOException $e)
	{
		return array();
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
		return array();
	}
	catch(PDOException $e)
	{
		return array();
	}
}



function order($cart,$usr)
{
    include('pdo.php');
    //create order and put another txn

    $conn->beginTransaction();

    $i=0;
    $merchant_ids = get_merchant($_SESSION['user']['customer_id']);
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
                        
                    $stmt_ord->execute(array($_SESSION['user']['customer_id'],$merchant_id['merchant_id'],$_POST['pay-method'],1,$ord_pl_id));
                    
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
                    $address->execute(array($order_id,$_SESSION['user']['c_def_address_id']));
                
                    //deduct from pay balance
                    $update_cur = $conn->prepare('UPDATE `wallet` SET `balance`=? WHERE `wallet_id` = ?');
                    $update_cur->execute(array(0,$wallet['wallet_id']));
                    //deduct from pay balcnce

                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
                return false;
            }   
        //real logic   
        }
        try
        {
            $stmt = $conn->prepare('delete from `p_cart` where `customer_id` = ?');
            if($stmt->execute(array($_SESSION['user']['customer_id'])))
            {
                $conn->commit();
                return true;
            }
            else
            {
                $conn->rollBack();
                return false;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
    else
    {
        return false;
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{

    $conn->beginTransaction();

    //check all false cases
    if(isset($_POST['payb']) && isset($_POST['pay-method']) && $_POST['pay-method'] == '105')
    {
        die('<p>something went wrong</p><a href="/">Go to Homepage</a>');
    }

    if(isset($_POST['payb']) && !isset($_POST['pay-method']))
    {   
        die('<p>something went wrong</p><a href="/">Go to Homepage</a>');        
    }
    //check all false cases

    $wallet = get_wallet($user['customer_id']);
    $cart = get_cart($user['customer_id']);

    if(isset($_POST['payb']) && $_POST['payb'] == '101') // this means user does not have enough balance 
    {
        
        //use selected radio and create transaction and order
        try
        {
            if(count($cart) > 0)
            {
                
                $total = 0;
                foreach($cart as $cartItem)
                {
                    if(($product = get_product($cartItem['p_id'])) !== null)
                    {						
                    	
                        $total += $cartItem['qty'] * $product['p_price'];
                    
                    }
                }
            

                if(count($wallet) > 0 && $wallet['balance'] < $total && $_POST['pay-method'] !== '105')
                {
                    //create txn    
                    $txn_id = substr(md5(time()),0,10);
                    $difference = $total - $wallet['balance'];

                    $put = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`, `txn_credit_wallet_id`,`txn_type`,`txn_desc`) VALUES (?,?,?,?,?)');
                    $res = $put->execute(array($txn_id,$difference,$wallet['wallet_id'],2,$_POST['pay-method']));

                }
                else if(count($wallet) > 0 && $wallet['balance'] >= $total && $_POST['pay-method'] !== '105')
                {

                    $txn_id = substr(md5(time()),0,10);
                    $difference = $total - $wallet['balance'];

                    $put = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`, `txn_debit_wallet_id`,`txn_type`,`txn_desc`) VALUES (?,?,?,?,?)');
                    $res = $put->execute(array($txn_id,$total,$wallet['wallet_id'],2,$_POST['pay-method']));

                }
                else if($_POST['pay-method'] == '105')
                {
                    $res = true;
                }

                if($res && order($cart,$user))
                {
                    if(count($wallet) > 0 && $wallet['balance'] < $total && $_POST['pay-method'] !== '105' && $_POST['pay-method'] !== '101')
                    {
                        //deduct from wallet
                        $put = $conn->prepare('UPDATE `wallet` SET `balance` = ? WHERE `wallet_id` = ?');
                        $put->execute(array(0,$wallet['wallet_id']));
                        //deduct from wallet
                    }
                    else if(count($wallet) > 0 && $wallet['balance'] >= $total && $_POST['pay-method'] == '101')
                    {
                        //deduct from wallet
                        $put = $conn->prepare('UPDATE `wallet` SET `balance` = ? WHERE `wallet_id` = ?');
                        $put->execute(array($wallet['balance']-$total,$wallet['wallet_id']));
                        //deduct from wallet
                    }


                    $conn->commit();
                    echo 'order Placed';
                }
                else
                {
                    $conn->rollBack();
                    echo 'something went wrong';
                }
            }
        }
        catch(PDOException $e)
        {
            die('<p>something went wrong</p><a href="/">Go to Homepage</a>');
        }
    }
    else if(!isset($_POST['payb']) && isset($_POST['pay-method'])) //user have enough balance in wallet
    {
        try
        {
            $total = 0;
            foreach($cart as $cartItem)
            {
                if(($product = get_product($cartItem['p_id'])) !== null)
                {						
                    
                    $total += $cartItem['qty'] * $product['p_price'];
                
                }
            }
  
            $res = false;

            if(count($wallet) > 0 && $wallet['balance'] >= $total && $_POST['pay-method'] !== '105')
            {

                $txn_id = substr(md5(time()),0,10);
                $difference = $total - $wallet['balance'];

                $put = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`,`txn_credit_wallet_id`,`txn_type`,`txn_desc`) VALUES (?,?,?,?,?)');
                $res = $put->execute(array($txn_id,$total,$wallet['wallet_id'],2,$_POST['pay-method']));
            }
            else if(count($wallet) > 0 && $wallet['balance'] >= $total && $_POST['pay-method'] == '101')
            {

                $txn_id = substr(md5(time()),0,10);
                $difference = $total - $wallet['balance'];

                $put = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`, `txn_debit_wallet_id`,`txn_type`,`txn_desc`) VALUES (?,?,?,?,?)');
                $res = $put->execute(array($txn_id,$total,$wallet['wallet_id'],2,$_POST['pay-method']));

            }
            else if(count($wallet) > 0 && $wallet['balance'] < $total && $_POST['pay-method'] !== '105')
            {

                $txn_id = substr(md5(time()),0,10);
                $difference = $total - $wallet['balance'];

                $put = $conn->prepare('INSERT INTO `in_txn`(`txn_id`, `txn_amount`, `txn_credit_wallet_id`,`txn_type`,`txn_desc`) VALUES (?,?,?,?,?)');
                $res = $put->execute(array($txn_id,$total,$wallet['wallet_id'],2,$_POST['pay-method']));

            }
            else if($_POST['pay-method'] == '105')
            {
                $res = true;
            }

            if($res && order($cart,$user))
            {
                if(count($wallet) > 0 && $wallet['balance'] < $total && $_POST['pay-method'] !== '105' && $_POST['pay-method'] !== '101')
                {
                    //deduct from wallet
                    $put = $conn->prepare('UPDATE `wallet` SET `balance` = ?  WHERE `wallet_id` = ?');
                    $put->execute(array(0,$wallet['wallet_id']));
                    //deduct from wallet
                }
                else if(count($wallet) > 0 && $wallet['balance'] >= $total && $_POST['pay-method'] == '101')
                {
                    //deduct from wallet
                    $put = $conn->prepare('UPDATE `wallet` SET `balance` = ? WHERE `wallet_id` = ?');
                    $put->execute(array($wallet['balance']-$total,$wallet['wallet_id']));
                    //deduct from wallet
                }

                $conn->commit();
                Header('Location:/customer/orders');
            }
            else
            {
                $conn->rollBack();
                echo 'something went wrong';
            }
        }
        catch(PDOException $e){
            die('<p>something went wrong'.$e->getMessage().'</p><a href="/">Go to Homepage</a>');
        }
    }
}    
?>