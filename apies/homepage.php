<?php   
session_start();
include('pdo.php');

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    if(isset($_GET['qtype']) && $_GET['qtype'] == '1')
    {
        try
        {
            $SQL = "SELECT * FROM `products` ORDER BY `p_added` LIMIT 5";
            $stmt = $conn->prepare($SQL);
            $stmt->execute();
            
        
            if($stmt->rowCount() > 0)
            {
                $return_values['products'] = $stmt->fetchAll();
                
                $return_values['result'] = 1;
                
                $i = -1;
                
                foreach($return_values['products'] as $item)
                {
                    $i++;
                    
                    $stmt = $conn->prepare('select `img_name`,`img_dir` from `images` where `img_list_id`=? LIMIT 1');
                    $stmt->execute(array($item['img_list_id'])); 
                    
                    $rating_stmt = $conn->prepare('SELECT (SELECT count(*) from `p_review` where `rew_rating`=1  &&  `product_id` = ?) AS `1`,(SELECT count(*) from `p_review` where `rew_rating`=2 &&  `product_id` = ?) AS `2`,(SELECT count(*) from `p_review` where `rew_rating`=3  && `product_id` = ?)  AS `3`,(SELECT count(*) from `p_review` where `rew_rating`=4  && `product_id` = ?) AS `4`,(SELECT count(*) from `p_review` WHERE `rew_rating`=5  && `product_id` = ?) AS `5`,count(`rew_rating`) AS `count` FROM `b2c`.`p_review` WHERE `product_id` = ?'); 
                    $rating_stmt->execute(array($item['product_id'],$item['product_id'],$item['product_id'],$item['product_id'],$item['product_id'],$item['product_id']));
                    
                    if($stmt->rowCount() > 0) 
                        $return_values['products'][$i]['images'] = $stmt->fetch();
                    else
                        $return_values['products'][$i]['images'] = array('','default.png');
                    
                    if($rating_stmt->rowCount() > 0)
                        $return_values['products'][$i]['rating'] = $rating_stmt->fetch();
                    else
                        $return_values['products'][$i]['rating'] = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'count'=>0);
                    
                }
            }
            else
            {
                $return_values['result'] = 0;
            }
            
            echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        catch(PDOException $e)
        {
            $return_values['ERROR']['insert'] = $e->getMessage();
            die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));	
        }
    }
}
else if($_SERVER['REQUEST_METHOD'] == "POST")
{

}


?>