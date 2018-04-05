<?php
session_start();
function prevent_hijacking(){
	if(isset($_SESSION['prevent_hijacking'])){
		$prevent_=$_SERVER['HTTP_USER_AGENT'];
		$prevent_.= $_SERVER['REMOTE_ADDR'];
		$prevent_.= $_SERVER['SERVER_NAME'];
		$prevent_ = md5($prevent_);
		if($_SESSION['prevent_hijacking'] === $prevent_){
			return true;
		}else{
			return false;
			session_destroy();
		}
	}else{
		return false;
	}
}
	
	if(!prevent_hijacking() && !isset($_SESSION['user']))
	{
		Header('Location: /login.php?redirurl=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	}


?>