<?php
if(isset($_GET['q'])){
    $keyword = mysql_real_escape_string($_GET['q']);
    $return_values = array();
		
    include('pdo.php'); //inluding the $conn PDO-OBJ 

    $stmt = $conn->prepare("SELECT * FROM products");
    $response =  $stmt->execute();
    
    if($response)
    {
        $return_values = $stmt->fetchAll();
        
    }
    else
    {
        $return_values['ERROR'] = 'INTERNAL ERROR';
    }
    echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);				

}
else{
    header('index.php');
}
?>

