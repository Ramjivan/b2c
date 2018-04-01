<?php
session_start();
include('pdo.php');
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
			echo $index;
			$ERROR_FLAG = true;
		}
	}
}
function get_product($id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select * from `products` where `product_id` = ? LIMIT 1');
		$stmt->execute(array($id));
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
function get_review($item_id)
{
	try
	{
		include('pdo.php');
		$stmt = $conn->prepare('select `customer_id` from `p_review` where `review_id` = ? LIMIT 1');
		$stmt->execute(array($item_id));
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

function reviewed($cus_id,$pro_id)
{
	include('pdo.php');
	if($cas_id !== null && $pro_id !== null)
	{
		$stmt =  $conn->prepare('select `customer_id` from `p_review` WHERE `customer_id`= ? && `product_id` = ?');
		$stmt->exeute(array($cus_id,$pro_id));

		if($stmt->rowCount() > 0)
		{
			return true;
		}
	}

	return false;
}

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
		{
			include('sessionvalidate.php');
			$user = $_SESSION['user'];

			$ERROR_FLAG = 0;
			
			$return_values = array();
			
			
			$indexes = array(
			'product_id' => '',
			'rew_rating' => '',
			'rew_text' => '',
			);
	
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
			}
				
			if($ERROR_FLAG == 0)
			{
				try
				{
					$indexes['customer_id'] = $user['customer_id'];
					if(reviewed($user['customer_id'],$indexes['product_id']) == false)
					{		
						$conn->beginTransaction();
						$stmt = $conn->prepare("INSERT INTO `p_review` (`product_id`,`rew_rating`,`rew_text`,`customer_id`) VALUES (:product_id,:rew_rating,:rew_text,:customer_id)");
						$response = $stmt->execute($indexes);
						if($response > 0)
						{
							$return_values['success'] = 1;
							$conn->commit();
						}
						else
						{
							$return_values['ERROR'] = "DB ERROR.";
						}
					}
					else
					{
						$return_values['ERROR'] = true;
						$return_values['MESSAGE'] = "Already Reviewed Product.";
					}
				}	
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
			}
			else
			{
				$return_values['ERROR'] = 1;
				$return_values['MESSAGE'] = "Sorry Something went wrong.";
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2') //EDIT
		{
			include('sessionvalidate.php');
			$user = $_SESSION['user'];
			
			if(isset($_POST['review_id']) && !empty($_POST['review_id']))
			{
				if(isset($_POST['rew_text']) && !empty($_POST['rew_text']))
				{
					$row = get_review($_POST['review_id']);
					
					if($row !== null && $row['customer_id'] == $user['customer_id']) 
					{
						try
						{
							$conn->beginTransaction();
							$stmt = $conn->prepare('UPDATE `p_review` SET `rew_text` = ? WHERE `review_id` = ?');
							$response = $stmt->execute(array($_POST['rew_text'],$_POST['review_id']));
							if($response == 1)
							{
								$conn->commit();
								$return_values['success'] = 1;
							}
							else
							{
								$return_values['ERROR'] = "DB ERROR";
							}
						}
						catch(PDOException $e)
						{
							$conn->rollBack();
							$return_values['ERROR']['insert'] = $e->getMessage();
							die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
						}
					}
					else
					{
						$return_values["ERROR"]="Permisson Denied";
					}
				}
				else
				{
					$return_values['ERROR'] = "Parameters missing.";
				}
				
			}
			else
			{
				$return_values['ERROR'] = "Parameters missing.";				
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['p_id']))  // GET
	{
		$return_values = array();
		$i = 0;
		
		if(($product = get_product($_GET['p_id'])) !== null)
		{
			$stmt = $conn->prepare('select `p_review`.*,`customers`.`c_fullname`,`customers`.`ppImg_id` from `customers` INNER JOIN `p_review` ON `customers`.`customer_id` = `p_review`.`customer_id` where `p_review`.`product_id`=?');
			$stmt->execute(array($product['product_id'])); 
			
			if($stmt->rowCount() > 0)
			{	
				$i = 0;
				
				$return_values['result'] = 1;

				$return_values['items'] = $stmt->fetchAll();
				
				$return_values['average_rating'] = 0;
				$return_values['one_star_rating'] = 0;
				$return_values['two_star_rating'] = 0;
				$return_values['three_star_rating'] = 0;
				$return_values['four_star_rating'] = 0;
				$return_values['five_star_rating'] = 0;
				
				$stmt = $conn->prepare("select * from `images` where `img_id`=? && `isDeleted` = '0'");
				
				foreach($return_values['items'] as $rviw)
				{
					$i++;
					$return_values['average_rating'] += $rviw['rew_rating'] ;
					if($rviw['rew_rating'] == 1)
						$return_values['one_star_rating']++;
					if($rviw['rew_rating'] == 2)
						$return_values['two_star_rating']++;
					if($rviw['rew_rating'] == 3)
						$return_values['three_star_rating']++;
					if($rviw['rew_rating'] == 4)
						$return_values['four_star_rating']++;
					if($rviw['rew_rating'] == 5)
						$return_values['five_star_rating']++;
					
					if($rviw['ppImg_id'] !== null)
					{
						$stmt->execute(array($rviw['ppImg_id']));
						if($stmt->rowCount() > 0)
						{
							$return_values['items'][($i-1)]['cusotmer_image'] = $stmt->fetch();
						}
					}
				}
				
				$return_values['average_rating'] /= $i;
				$return_values['rating_count'] = $i;
			}
			else
			{
				$return_values['result'] = 1;
				$return_values['average_rating'] = '0';
				$return_values['one_star_rating'] = '0';
				$return_values['two_star_rating'] = '0';
				$return_values['three_star_rating'] = '0';
				$return_values['four_star_rating'] = '0';
				$return_values['five_star_rating'] = '0';
				$return_values['average_rating'] = '0';
				$return_values['rating_count'] = '0';
				
				$return_values['items'] = array();						
			}
		}
		else
		{
			$return_values['result'] = 0;
			$return_values['MESSAGE'] = "Something Went Wrong.";						
		}
		
		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
?>