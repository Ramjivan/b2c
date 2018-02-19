<?php
session_start();
include('pdo.php');
include('sessionvalidate.php');
$user = $_SESSION['user'];
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
	}
	
	
}
	
	$return_values = array();

	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET['qtype']))
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == "1")
		{
			try
			{
				$conn->beginTransaction();

				$ERROR_FLAG = 0;
				
				$return_values = array();
				
				$indexes = array
				(
					'adt_fullname' => '',
					'adt_mob' => '',
					'adt_pincode' => '',
					'adt_addressline1' => '',
					'adt_addressline2' => '',
					'adt_landmark' => '',
					'adt_city' => '',
					'adt_state' => '',
					'adt_type' => ''
				);
		
				foreach($indexes as $index => $value)
				{
					is_set($indexes[$index],$index,$ERROR_FLAG);
				}
	
				if($ERROR_FLAG == 0)
				{
					$indexes['customer_id'] = $user['customer_id'];
					$stmt = $conn->prepare('insert into 
					`addresses` 
					(`customer_id`,
					`adt_fullname`,
					`adt_mob`,
					`adt_pincode`,
					`adt_addressline1`,
					`adt_addressline2`,
					`adt_landmark`,
					`adt_city`,
					`adt_state`
					,`adt_type`) 
					VALUES 
					(:customer_id,
					:adt_fullname,
					:adt_mob,
					:adt_pincode,
					:adt_addressline1,
					:adt_addressline2,
					:adt_landmark,
					:adt_city,
					:adt_state,
					:adt_type)');
					$address = $stmt->execute($indexes);
					
					if($address > 0)
					{
						
						if($user['c_def_address_id'] == null)
						{
							$last_insert_id = $conn->lastInsertId();
							$_SESSION['user']['c_def_address_id'] = $last_insert_id;
							$stmt = $conn->prepare('update `customers` SET `c_def_address_id` = ? WHERE `customer_id` = ?');
							$stmt->execute(array($last_insert_id,$user['customer_id']));
							
						}
						$conn->commit();
						$return_values['success'] = 1;
					}
					else
					{
						$ERROR_FLAG = true;
						$return_values['ERROR'] = "COULDN'T CONNECT TO DATABASE";

					}
				}
				else
				{
					$ERROR_FLAG = true;
					$return_values['ERROR'] = "FIELD DOESN'T MATCH";
				}
			}
			catch(PDOException $e)
			{  
				$conn->rollBack();
				$return_values['ERROR']['insert'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if( (isset($_GET['qtype']) && $_GET['qtype'] == "2") && isset($_POST['cid']))
		{
			try
			{	
				$conn->beginTransaction();
				$get_adr = $conn->prepare('SELECT `customer_id` from `addresses` WHERE `address_id` = ?'); 
				$response = $get_adr->execute(array($_POST['cid']));
				if($response > 0)
				{
					if(($id = $get_adr->fetch()) !== null && $id['customer_id'] == $user['customer_id'])
					{
						$stmt  = $conn->prepare('DELETE FROM `addresses` WHERE `address_id`=?');
						$response = $stmt->execute(array($_POST['cid']));
						
						if($response > 0)
						{
							$conn->commit();
							$return_values['success'] = 1;
							
						}
					}
					else
					{
						$return_values['ERROR'] = "USER NOT PRIVILEGD";
					}
				}
				else
				{
					$return_values['ERROR'] = "DB ERROR";
				}
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']['insert'] = $e->getMessage();
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		}
		
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		try
		{
			$stmt = $conn->prepare('SELECT * FROM `addresses` WHERE `customer_id` = ?');
			$response = $stmt->execute(array($user['customer_id']));
			if($stmt->rowCount() > 0)
			{
				$return_values['result'] = 1;
				$return_values['items'] = $stmt->fetchAll();
				$return_values['default_id'] = $user['c_def_address_id'];
			}
			else
			{
				$return_values['result'] = 0;
				$return_values['items'] = array();	
			}
		}
		catch(PDOException $e)
		{
			$return_values['ERROR']['insert'] = $e->getMessage();
			die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
		}
		echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}


?>