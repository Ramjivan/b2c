<?php

	function create_password($password)
	{
		$salt=mcrypt_create_iv(16,MCRYPT_DEV_URANDOM);

		$iteration = rand(0,99999);
	
		$password = ($password !== null ? $password : substr(md5(microtime()),0,7));
		
		$hash = hash_pbkdf2("sha512",$password,$salt,$iteration,20);
		
		return array('salt' => $salt , 'iteration' => $iteration , 'hash' => $hash);
	}	
	
	function get_user($id)
	{
		include('pdo.php');
		try
		{
			$stmt = $conn->prepare('select * from `customers` where `c_email` = ? ');
			$response = $stmt->execute(array($id));
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
	
	
	function get_hash($id)
	{
		include('pdo.php');
		try
		{
			$stmt = $conn->prepare('select * from `_tbl_pass` where `customer_id` = ?');
			$response = $stmt->execute(array($id));
			if($stmt->rowCount() > 0)
			{
				return $stmt->fetch();
			}
			return null;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return null;	
		}
		
	}
	
?>