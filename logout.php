<?php
	session_start();
	
	session_unset();
	
	unset($_SESSION['user']);
	unset($_SESSION['prevent_hijacking']);
	
	session_destroy();

	Header('Location:/index.php');
?>