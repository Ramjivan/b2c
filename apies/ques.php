<?php
session_start();
include('pdo.php');
include('sessionvalidate.php');
$user = $_SESSION['user'];

function is_set(&$var,$index,&$ERROR_FLAG)
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

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
		{
			$ERROR_FLAG = 0;
			
			$return_values = array();
			
			
			$indexes = array(
			'product_id' => '',
			'qna_question' => ''
			);
	
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG);
			}
			
			
			
			if($ERROR_FLAG == 0 && ($product = get_product($indexes['product_id'])) !== null)
			{
				
				try
				{
					$indexes['customer_id'] = $user['customer_id'];
					$indexes['Merchant_id'] = $product['Merchant_id'];
					$conn->beginTransaction();
					$stmt = $conn->prepare("INSERT INTO `p_qna` (`product_id`,`qna_question`,`customer_id`,`Merchant_id`) VALUES (:product_id,:qna_question,:customer_id,:Merchant_id)");
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
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
			}
			else
			{
				$return_values['ERROR'] = "REQUIRED PARAMETERS ARE MISSING.";
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2')
		{
			if(isset($_POST['qna_id']))
			{
				try
				{
					$stmt = $conn->prepare('select `qna_question`,`customer_id` from `p_qna` where `qna_id` = ?');
					$response = $stmt->execute(array($_POST['qna_id']));
					//get the qna and verify user
					if($response > 0)
					{
						$row = $stmt->fetch();
						$customer_id = $row['customer_id'];
						$qna_question = $row['qna_question'];
						
						if($user['customer_id'] == $customer_id)
						{
							//now verify if the question was really modified
							if(isset($_POST['qna_question']) && $qna_question !== $_POST['qna_question'])
							{
								try
								{
									$conn->beginTransaction();
									$stmt = $conn->prepare('INSERT INTO `qna_question_edit_log` (`qna_id`,`qna_question`) VALUES (?,?)');
									$response = $stmt->execute(array($_POST['qna_id'],$_POST['qna_question']));
									
									if($response > 0)
									{
										$stmt = $conn->prepare('UPDATE `p_qna` SET `qna_question`=? WHERE `qna_id`=?');
										$response = $stmt->execute(array($_POST['qna_question'],$_POST['qna_id']));
										
										if($response > 0)
										{
											$conn->commit();
											$return_values['success'] = 1;
										}
										else
										{
											$conn->rollBack();
											$return_values['ERROR'] = "DB ERROR";
										}
									}
									else
									{
										$conn->rollBack();
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
								$return_values['ERROR'] ="NOTHING MODIFIED";
							}
						}
						else
						{
							$return_values['ERROR'] ="INVALID PRIVILEGES.";
						}
					}
					else
					{
						$return_values['ERROR'] ="INVALID REQUEST";
					}
				}
				catch(PDOException $e)
				{
					$return_values['ERROR']['insert'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));									
				}
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '3')
		{
			if(isset($_POST['qna_id']))
			{
				try
				{
					$stmt = $conn->prepare('select `customer_id` from `p_qna` where `qna_id` = ?');
					$response = $stmt->execute(array($_POST['qna_id']));
					//get the qna and verify user
					if($response > 0)
					{
						$row = $stmt->fetch();
						$customer_id = $row['customer_id'];
						
						if($user['customer_id'] == $customer_id)
						{
							$conn->beginTransaction();
							$stmt = $conn->prepare('DELETE FROM `p_qna` WHERE `qna_id` = ?');
							$response = $stmt->execute(array($_POST['qna_id']));
							
							if($response > 0)
							{
								$conn->commit();
								$return_values['success'] = 1;
							}
							else
							{
								$conn->rollBack();
								$return_values['ERROR'] = "DB ERROR";
							}
						}
						else
						{
							$return_values['ERROR'] ="INVALID PRIVILEGES.";
						}
					}
				}
				catch(PDOException $e)
				{
					$return_values['ERROR']['DB'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
			}
		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] = 1 &&  isset($_GET['id']) && !empty($_GET['id'])) //get question on product
		{
			try
			{
				$stmt = $conn->prepare('SELECT * FROM `p_qna` WHERE `product_id` = ?');
				$response = $stmt->execute(array($_GET['id']));
				if($response > 0)
				{
					$return_values = $stmt->fetchAll();
				}	
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']['DB'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] = 2)
		{
			try
			{
				$stmt = $conn->prepare('SELECT * FROM `p_qna` WHERE `Merchant_id` = ?');
				$response = $stmt->execute(array($user['merchant_id']));
				if($stmt->rowCount() > 0)
				{
					$return_values['success'] = 1;
					$return_values['items'] = $stmt->fetchAll();
				}	
				else
				{
					$return_values['success'] = 0;
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']['DB'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}
		}
	}


?>