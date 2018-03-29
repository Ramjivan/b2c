<?php
session_start();
include('pdo.php');


function is_set(&$var,$index,&$ERROR_FLAG)
{
	if(isset($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}
	else
	{
		$ERROR_FLAG = true;
		echo $index;
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
				if(move_uploaded_file($_FILES[$index]["tmp_name"], $targetFile.'.'.$imageFileType))
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


function getBreadcrum($cat_id,$conn)
{

	$breadcrum = array();

	$stmt = $conn->prepare('select `categorydescription`.`category_id`,`cat_name`,`category`.`parent_id` from `categorydescription` LEFT JOIN `category` ON `categorydescription`.`category_id` = `category`.`category_id` where `categorydescription`.`category_id`=?');
	$stmt->execute(array($cat_id));

	$row = $stmt->fetch();

	array_push($breadcrum,array('name'=>$row['cat_name'],'catid'=>$row['category_id']));

	while($row['parent_id'] !== '1')
	{
		$stmt->execute(array($row['parent_id']));
		$row = $stmt->fetch();
		
		
		array_push($breadcrum,array('name'=>$row['cat_name'],'catid'=>$row['category_id']));
		
		if($row['parent_id'] !== '1')
		{
			break;
		}

	}


	return $breadcrum;
}

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		if(isset($_GET['qtype']) && $_GET['qtype'] == "1")
		{
			include('sessionvalidate.php');

			$user = $_SESSION['user'];

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
						is_numeric($_POST['spcount']) &&
						$_POST['spcount'] > 0 &&
						$_POST['spcount'] <= 20
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
															trim($_POST['sp_name'.$i]),
															trim($_POST['sp_value'.$i])
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
				else
				{
					$return_values['ERROR'] = $product_response.$hlgt_response.$count.$imglst_response.$cod_response;
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			else
			{
				echo 1;
			}
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == "2")
		{
			include('sessionvalidate.php');

			$user = $_SESSION['user'];

			
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
		$return_values = array();
		
		if(isset($_GET['page']) && $_GET['cat'])
		{
			try
			{
				$start = (intval($_GET['page']) * 10) - 10;
				$end = (intval($_GET['page']) * 10);
				$SQL = "SELECT * FROM `products`  where `p_category`=? LIMIT ".$start.",".$end;
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($_GET['cat']));
				
				$cat = "select `category`.`category_id`,`category`.`parent_id`,`categorydescription`.`cat_name`,`categorydescription`.`cat_description`,`categorydescription`.`cat_meta_keyword`,`category`.`dateAdded`,`category`.`image_id` from `category`,`categorydescription` where `category`.`category_id` = `categorydescription`.`category_id` && `category`.`category_id`= ?"; 
				$cat_stmt = $conn->prepare($cat);
				$cat_stmt->execute(array($_GET['cat']));
				
				$sub_cat = $conn->prepare('SELECT `categorydescription`.`category_id`,`categorydescription`.`cat_name` FROM `category` LEFT JOIN `categorydescription` ON `category`.`category_id` = `categorydescription`.`category_id` where `category`.`parent_id` = ?');
				$sub_cat->execute(array($_GET['cat']));
				
				
				if($stmt->rowCount() > 0 && $cat_stmt->rowCount() > 0 && $sub_cat->rowCount() >= 0)
				{
					$return_values['products'] = $stmt->fetchAll();
					$return_values['category'] = $cat_stmt->fetch();
					$return_values['category']['subcategory'] = $sub_cat->fetchAll();
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
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '1')
		{
			
			include('sessionvalidate.php');

			$user = $_SESSION['user'];

			$return_values = array();
			try
			{
				$SQL = "SELECT * FROM `products` where `Merchant_id`=?";
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($user['merchant_id']));
				if($stmt->rowCount())
				{
					$return_values['items'] = $stmt->fetchAll();
					$return_values['result'] = 1;
					
					$i = 0;
					
					foreach($return_values['items'] as $item)
					{
						$stmt = $conn->prepare('select `img_name`,`img_dir` from `images` where `img_list_id`=?');
						$stmt->execute(array($item['img_list_id'])); 
						
						$spec = $conn->prepare('select `spc_field_name`,`spc_field_value` from `p_spec` where `product_id`=?');
						$spec->execute(array($item['product_id']));
						
						$hlgt = $conn->prepare('select `pht_field_value` from `p_highlight` where `product_id`=?');
						$hlgt->execute(array($item['product_id']));
						
						if($stmt->rowCount() > 0)
						{
							$return_values['items'][$i]['images'] = $stmt->fetchAll();
							
							$return_values['items'][$i]['specification'] = $spec->fetchAll();

							$return_values['items'][$i]['highlights'] = $hlgt->fetchAll();
							
						}
					
						$i++;
					}
				}
				else
				{
					$return_values['ERROR'] = "NO ITEMs";
				}
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']['insert'] = $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			}
		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2' && isset($_GET['id']))
		{
			$return_values = array();
			try
			{
				$SQL = "SELECT * FROM `products` where `product_id`=?";
				$stmt = $conn->prepare($SQL);
				$stmt->execute(array($_GET['id']));
				if($stmt->rowCount() > 0)
				{
					$return_values['items'][0]['product'] = $stmt->fetch();
					
					$stmt = $conn->prepare('select `img_name`,`img_dir` from `images` where `img_list_id`=?');
					$stmt->execute(array($return_values['items'][0]['product']['img_list_id'])); 
					
					$spec = $conn->prepare('select `spc_field_name`,`spc_field_value` from `p_spec` where `product_id`=?');
					$spec->execute(array($_GET['id']));
					
					$hlgt = $conn->prepare('select `pht_field_value` from `p_highlight` where `product_id`=?');
					$hlgt->execute(array($_GET['id']));
					
					$breadcrum = getBreadCrum($return_values['items'][0]['product']['p_category'],$conn);
					
					if($stmt->rowCount() > 0 && $spec->rowCount() > 0 && $hlgt->rowCount() > 0)
					{
						$return_values['items'][0]['images'] = $stmt->fetchAll();
						
						$return_values['items'][0]['specification'] = $spec->fetchAll();

						$return_values['items'][0]['highlights'] = $hlgt->fetchAll();	
						
						$return_values['items'][0]['breadcrums'] = $breadcrum;
					}
				}
				else
				{
					$return_values['ERROR'] = "NO ITEMs";
					$return_values['items'] = array();
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