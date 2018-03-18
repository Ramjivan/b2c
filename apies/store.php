<?php
session_start();
include('pdo.php');
function is_set_strict(&$var,$index,&$ERROR_FLAG)
{
		
	if(isset($_POST[$index]) && !empty($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}
	else
	{
		$ERROR_FLAG = true;
	}
	
}

function is_set(&$var,$index,&$ERROR_FLAG)
{
	if(isset($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}else
	{
		$ERROR_FLAG = true;
			echo $index." "; 
	}
	
	
}
	if($_SERVER['REQUEST_METHOD'] == "GET") 
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1')
		{			
			//get category of merchant
			$return_values = array();
			
			try
			{
				$store = "select * from `store` LEFT JOIN `addresses` ON `store`.`st_address_id` = `addresses`.`address_id` where `st_name`= ?"; 
				$stmt = $conn->prepare($store);
				$stmt->execute(array($_GET['name']));
				
				
				if($stmt->rowCount() > 0)
				{
					$return = $stmt->fetch();
					$return_values['result'] = 1;
					$return_values['header'] = array('name' => $return['st_name'],'logo' => $return['st_logo']); 
					$return_values['footer'] = array(
													'address' => array(
																'adt_fullname' => $return['adt_fullname'],
																'adt_mob' => $return['adt_mob'],
																'adt_pincode' => $return['adt_pincode'],
																'adt_addressline1' => $return['adt_addressline1'],
																'adt_addressline2' => $return['adt_addressline2'],
																'adt_landmark' => $return['adt_landmark'],
																'adt_city' => $return['adt_city'],
																'adt_state' => $return['adt_state']
																),
													); 
					$return_values['storeDetails'] = array('id'=>$return['st_id'],'themeid' => $return['st_theme_id'],'merchant_id' => $return['merchant_id']); 
					
					$category = "select distinct `categorydescription`.* from `products` INNER JOIN  `categorydescription` ON `category_id` = `p_category` where `products`.`Merchant_id` = ? ;";
					$stmt = $conn->prepare($category);
					$stmt->execute(array($return['merchant_id']));
					
					$return_values['categories'] = $stmt->fetchAll(); 

				}
				else
				{
					$return_values['result'] = 0;
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']= $e->getMe;
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}
		}
		
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2')
		{
			try
			{
				$SQL = "SELECT * FROM `products` where `Merchant_id`=? LIMIT 5";
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($_GET['mer_id']));
				
				$store = $conn->prepare("select * from `store` where `merchant_id` = ?");
				$store->execute(array($_GET['mer_id']));
				
				
				if($stmt->rowCount() > 0)
				{
					$return_values['products'] = $stmt->fetchAll();
					$return_values['store'] = $store->fetchAll();
					
					$return_values['result'] = 1;
					
					$i = -1;
					
					foreach($return_values['products'] as $item)
					{
						$i++;
						
						$stmt = $conn->prepare('select `img_name`,`img_dir` from `images` where `img_list_id`=? LIMIT 1');
						$stmt->execute(array($item['img_list_id'])); 
						
						$rating_stmt = $conn->prepare('SELECT DISTINCT ((SELECT count(*) from `p_review` where `rew_rating`=1) * 1) AS `1`,((SELECT count(*) from `p_review` where `rew_rating`=2) * 2) AS `2`,((SELECT count(*) from `p_review` where `rew_rating`=3) * 3) AS `3`,((SELECT count(*) from `p_review` where `rew_rating`=4) * 4) AS `4`,((SELECT count(*) from `p_review` where `rew_rating`=5) * 5) AS `5`,count(`rew_rating`) AS `count` FROM `b2c`.`p_review` where `product_id` = ?'); 
						$rating_stmt->execute(array($item['product_id']));
						
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
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '3')
		{
			try
			{
				$start = (intval($_GET['page']) * 10) - 10;
				$end = (intval($_GET['page']) * 10);
				
				$SQL = "SELECT * FROM `products`  where `p_category`=? && `Merchant_id` = ? LIMIT ".$start.",".$end;
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($_GET['cat'],$_GET['mer_id']));
				
				
				
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
						
						$rating_stmt = $conn->prepare('SELECT DISTINCT ((SELECT count(*) from `p_review` where `rew_rating`=1) * 1) AS `1`,((SELECT count(*) from `p_review` where `rew_rating`=2) * 2) AS `2`,((SELECT count(*) from `p_review` where `rew_rating`=3) * 3) AS `3`,((SELECT count(*) from `p_review` where `rew_rating`=4) * 4) AS `4`,((SELECT count(*) from `p_review` where `rew_rating`=5) * 5) AS `5`,count(`rew_rating`) AS `count` FROM `b2c`.`p_review` where `product_id` = ?'); 
						$rating_stmt->execute(array($item['product_id']));
						
						if($stmt->rowCount() > 0) 
							$return_values['products'][$i]['images'] = $stmt->fetch();
						else
							$return_values['products'][$i]['images'] = array('','default.png');
						
						if($rating_stmt->rowCount() > 0)
							$return_values['products'][$i]['rating'] = $rating_stmt->fetch();
						else
							$return_values['products'][$i]['rating'] = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'count'=>0);
						
					}
					
					$SQL = 'SELECT count(*) as `total_products` FROM `products`  where `p_category`=? && `Merchant_id` = ?';
					$stmt = $conn->prepare($SQL);
					$stmt->execute(array($_GET['cat'],$_GET['mer_id']));
					
					$row = $stmt->fetch();
					
					
					$totalProducts = $row['total_products'];
					
					if($totalProducts > 0)
					{
						$totalPages = ceil($totalProducts / 10);
						
						$return_values['TotalPages'] = $totalPages;
						$return_values['NextPage'] = ($totalPages > $_GET['page'] ? $_GET['page']+1 : $totalPages);
						
					}
					else
					{
						$return_values['TotalPages'] = 0;
						$return_values['NextPage'] = 0;
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
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '4')
		{

			//including session validate because this section is related to merchant dashboard
			include('sessionvalidate.php');
			$user = $_SESSION['user'];

			//and $user data is needed here for retrieval of store.

			try
			{
				
				
				$SQL = "SELECT * FROM `store` where `merchant_id` = ? LIMIT 1";
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($user['merchant_id']));
				
				if($stmt->rowCount() > 0)
				{
					$return_values['result'] = 1;
					$return_values['store'] = $stmt->fetch();
			
				}
				else
				{
					$return_values['result'] = 1;
					$return_values['store'] = array('notOpen' => 1);
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
?>