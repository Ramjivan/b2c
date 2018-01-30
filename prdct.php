<?php

session_start();
include('sessionvalidate.php');
$user = $_SESSION['user'];

include('pdo.php');
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
function upload_image($index)
{
	if(
		isset($_FILES[$index]) && 
		is_uploaded_file($_FILES[$index]['tmp_name']) && 
		$_FILES[$index]['tmp_name'] !== ""
	)
	{
		//image validation starts
		$dir = "products/uploads/";
		$name = md5(basename($_FILES[$index]['name']).time());
		$targetFile = $dir.$name;
		$imageFileType = strtolower(pathinfo($dir.basename($_FILES[$index]['name']),PATHINFO_EXTENSION));
		$check = getimagesize($_FILES[$index]["tmp_name"]);
		if($check !== false)
		{
			if($imageFileType == "png" || $imageFileType == "jpg" || $imageFileType == "jpeg")
			{
				if (move_uploaded_file($_FILES[$index]["tmp_name"], $targetFile.'.'.$imageFileType))
				{
					return array('dir'=>$dir,'imgname'=>$name.'.'.$imageFileType);
				}
			}
			else
			{
				return null;
			}
		}
	}
	return false;
}

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		if(isset($_GET['qtype']) && $_GET['qtype'] == "1")
		{
			$product_response = $spec_response = $hlgt_response = $imglst_response = $cod_response = 0;
			
			$ERROR_FLAG = 0;
			
			$return_values = array();
			
			$img_list_id = md5(time().rand(0,1000));
			$product_id = md5(rand(0,1000).time());
				
			
			$indexes = array(
			'p_name' => '',
			'p_description' => '',
			'p_price' => '',
			'p_stock' => '',
			'p_category' => '',
			);
	
			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG);
			}
			
			$indexes['product_id'] = $product_id;
			$indexes['img_list_id'] = $img_list_id;
			$indexes['Merchant_id'] = $user['merchant_id'];
				
			if($ERROR_FLAG == 0)
			{
				try
				{
				
					$conn->beginTransaction();
					$stmt = $conn->prepare("INSERT INTO `products` (`product_id`,`p_name`,`p_description`,`p_price`,`p_stock`,`img_list_id`,`p_category`,`Merchant_id`) VALUES (:product_id,:p_name,:p_description,:p_price,:p_stock,:img_list_id,:p_category,:Merchant_id)");
					$product_response = $stmt->execute($indexes);
					
				}	
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
				
				try
				{
					if
					(
						isset($_POST['imgcount']) &&
						is_numeric($_POST['imgcount']) &&
						$_POST['imgcount'] > 0
					)
					{
						$count = $_POST['imgcount'];
						for($i = 1 ; $i <= $count ; $i++)
						{
							$name_arr = upload_image('image'.$i);
							if(count($name_arr) > 0)
							{
								$stmt = $conn->prepare('insert into `images` (`img_list_id`,`customer_id`,`img_dir`,`img_name`) VALUES (?,?,?,?)');
								$imglst_response = $stmt->execute
													(
														array
														(
															$img_list_id,
															$user['customer_id'],
															$name_arr['dir'],
															$name_arr['imgname']
														)
													);
							}
							
						}
						$stmt = $conn->prepare('insert into `image_list` (`img_list_id`, `customer_id`) VALUES (?,?)');
						$imglst_response = $stmt->execute(array
													(
													$img_list_id,
													$user['customer_id']
													)
												);
					}
				}
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				}
				
				try
				{
					if
					(
						isset($_POST['hlgtcount']) &&
						is_numeric($_POST['hlgtcount']) &&
						$_POST['hlgtcount'] > 0
					)
					{
						$count = $_POST['hlgtcount'];
						for($i = 1 ; $i <= $count ; $i++)
						{			
							if(isset($_POST['hlgt'.$i]) && !empty($_POST['hlgt'.$i]))
							{
								$stmt = $conn->prepare('insert into `p_highlight` (`product_id`,`pht_field_value`) VALUES (?,?)');
								$hlgt_response = $stmt->execute(array
															(
															$product_id,
															$_POST['hlgt'.$i]
															)
														);
							}
						}
					}
				}
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				}
				
				try
				{
					if
					(
						isset($_POST['spcount']) &&
						is_numeric($_POST['hlgtcount']) &&
						$_POST['hlgtcount'] > 0
					)
					{
						$count = $_POST['spcount'];
						for($i = 1 ; $i <= $count ; $i++)
						{			
							
							if((isset($_POST['sp_name'.$i]) && !empty($_POST['sp_name'.$i])) &&
								(isset($_POST['sp_value'.$i]) && !empty($_POST['sp_value'.$i]))
							)
							{
								$stmt = $conn->prepare('insert into `p_spec` (`product_id`,`spc_field_name`,`spc_field_value`) VALUES (?,?,?)');
								$spec_response = $stmt->execute(array
															(
															$product_id,
															$_POST['sp_name'.$i],
															$_POST['sp_value'.$i]
															)
														);
							}
						}
					}
				}
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				}
				
				try
				{
					if
					(
						isset($_POST['cod']) &&
						is_numeric($_POST['cod'])
					)
					{
						$stmt = $conn->prepare('insert into `p_cod_bool` (`product_id`,`isEligable`) VALUES (?,?)');
						$cod_response = $stmt->execute(array
															(
															$product_id,
															$_POST['cod']
															)
														);
					}
				}
				catch(PDOException $e)
				{
					$conn->rollBack();
					$return_values['ERROR']['insert'] = $e->getMessage();
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				}
				
				if($product_response > 0 && $hlgt_response > 0 && $spec_response > 0 && $imglst_response > 0 && $cod_response > 0)
				{
					$conn->commit();
					$return_values['success'] = 1;
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == "2")
		{
			
				if(isset($_POST['product_id']))
				{
					$i = 0;
					$SQL = 'UPDATE `products` SET ';
					$indexes = array('p_name','p_description','p_price','p_category','p_stock');
					$return_values = array();
					
					foreach($indexes as $index)
					{
						if(isset($_POST[$index]))
						{
							if($i > 0)
							{
								$SQL .= ',';
							}
							$SQL .= "`".$index."`"."='".trim($_POST[$index])."'"; 
							$i=1;
						}
					}
					
					$SQL .= " WHERE `product_id` = '".$_POST['product_id']."' && `Merchant_id` ='".$user['merchant_id']."'";
					
					if($i > 0)
					{
						$return_values['SQL'] = $SQL;
						try
						{
							$conn->beginTransaction();
							$stmt = $conn->prepare($SQL);
							$response = $stmt->execute();
							if($response)
							{
								$conn->commit();
								$return_values['success'] = 1;
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
						$return_values['ERROR']['internal'] = "No Data to Update.";
					}
					
					echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				}
			
		}
		
		
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		
		
		
	}






?>