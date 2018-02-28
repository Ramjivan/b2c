<?php
if(isset($_GET['q']) && $_GET['q'] != ""){ //check if there's a q GET var and it's not empty
    
    $keyword = $_GET['q'];
    $return_values = array();
		
    include('pdo.php'); //inluding the $conn PDO-OBJ 
    
    $stmt = $conn->prepare("SELECT p_name FROM products WHERE p_name LIKE :keyword");
    $response =  $stmt->execute(array(':keyword' => $keyword.'%'));
    
    if($response)
    {   
        $return_values = $stmt->fetchAll();
        
    }
    else
    {
        $return_values['ERROR'] = '';
    }
    echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);				

}
else{
    header('index.php');
}
?>

