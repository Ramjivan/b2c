<?php
try{
		$servername = "b2c.ci5stww8s4in.ap-south-1.rds.amazonaws.com";
		$username = "root";
		$password = "Jivan1234";
		$dbname = "b2c";	
		
		
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

}catch(PDOException $e){
	echo json_encode($e->getMessage());
}
?>