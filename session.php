<?php
include('pdo.php');
include('functions.php');

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
			echo $index;
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

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$ERROR_FLAG = 0;

		$return_values = array();
		
		$indexes = array('mail' => '','paswrd' => '');
		
		foreach($indexes as $index => $value)
		{
			is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
		}		
		
		if(!$ERROR_FLAG && ( $user = get_user($indexes['mail']) ) !== null)
		{
			$pass_arr = get_hash($user['customer_id']);
			$good_hash = $pass_arr['hash'];
			$salt = $pass_arr['salt'];
			$iteration = $pass_arr['iteration'];
			
			$hash = hash_pbkdf2("sha512",$_POST['paswrd'],$salt,$iteration,20);
			
			if($good_hash === $hash)
			{
				$return_values['success'] = 1;
				session_start();
				$_SESSION['user'] = $user;
				
				$prevent_=$_SERVER['HTTP_USER_AGENT'];
				$prevent_.= $_SERVER['REMOTE_ADDR'];
				$prevent_.= $_SERVER['SERVER_NAME'];
				$prevent_ = md5($prevent_);
				
				$_SESSION['prevent_hijacking'] = $prevent_;
			}
			else
			{
				$return_values['ERROR'] = "Invalid Password";
			}
			
		}
		else
		{
			$return_values['ERROR'] = "Invalid Credentials";
		}
		
		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		session_start();
		if(isset($_SESSION['user']))
		{
			echo json_encode($_SESSION,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	}
?>