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

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1') //ADD
		{
			$ERROR_FLAG = 0;
			
			$return_values = array();
			
			
			$indexes = array(
			'qna_id' => '',
			'qna_answer' => ''
			);
	
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG);
			}
				
			if($ERROR_FLAG == 0)
			{
				try
				{
					$conn->beginTransaction();
					$stmt = $conn->prepare("UPDATE `p_qna` SET `qna_answer` = :qna_answer WHERE `qna_id` = :qna_id");
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
					$return_values['ERROR']['1'] = $e->getMessage();
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
					$stmt = $conn->prepare('select `qna_answer`,`customer_id` from `p_qna` where `qna_id` = ?');
					$response = $stmt->execute(array($_POST['qna_id']));
					//get the qna and verify user
					if($response > 0)
					{
						$row = $stmt->fetch();
						$customer_id = $row['customer_id'];
						$qna_answer = $row['qna_answer'];
						
						if($user['customer_id'] == $customer_id)
						{
							//now verify if the question was really modified
							if(isset($_POST['qna_answer']) && $qna_answer !== $_POST['qna_answer'])
							{
								try
								{
									$conn->beginTransaction();
									$stmt = $conn->prepare('INSERT INTO `qna_answer_edit_log` (`qna_id`,`qna_answer`) VALUES (?,?)');
									$response = $stmt->execute(array($_POST['qna_id'],$_POST['qna_answer']));
									
									if($response > 0)
									{
										$stmt = $conn->prepare('UPDATE `p_qna` SET `qna_answer`=?,`qna_closed`=? WHERE `qna_id`=?');
										$response = $stmt->execute(array($_POST['qna_answer'],date('Y-m-d h:m:s'),$_POST['qna_id']));
										
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
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		
	}


?>