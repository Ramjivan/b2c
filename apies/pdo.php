<?php
try{
		$servername = "b2c-rds.ci5stww8s4in.ap-south-1.rds.amazonaws.com";
		$username = "root";
		$password = "jivan12345";
		$dbname = "b2c";	
		
		
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

}catch(PDOException $e){
	echo json_encode($e->getMessage());
}
?>