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
	if($_SERVER['REQUEST_METHOD'] == "GET") 
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1')
		{			
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
					$return_values['store']['id'] = $return['st_id'];
					$return_values['store']['name'] = $return['st_name'];
					$return_values['store']['logo'] = $return['st_logo'];
					$return_values['store']['merchant_id'] = $return['merchant_id'];
					$return_values['store']['contact'] = array('phone'=>$return['st_phone'],'email'=>$return['st_email']);

					$return_values['store']['address'] = array(
															'adt_fullname' => $return['adt_fullname'],
															'adt_mob' => $return['adt_mob'],
															'adt_pincode' => $return['adt_pincode'],
															'adt_addressline1' => $return['adt_addressline1'],
															'adt_addressline2' => $return['adt_addressline2'],
															'adt_landmark' => $return['adt_landmark'],
															'adt_city' => $return['adt_city'],
															'adt_state' => $return['adt_state']
														);
					
					$return_values['store']['socialLinks'] = array(
						'facebook' => $return['st_fb_lnk'],
						'youtube' => $return['st_yt_lnk'],
						'whatsapp' => $return['st_wpb_lnk'],
						'instagram' => $return['st_in_lnk'],
						'twitter' => $return['st_tw_lnk'],
						'google' => $return['st_go_lnk'],
					);									


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
				
				
				$SQL = "SELECT * FROM `store` INNER JOIN `addresses` ON `store`.`st_address_id` = `addresses`.`address_id` where `merchant_id` = ? LIMIT 1";
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
	else if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		$return_values = array();

		if($_GET['qtype'] == "1")
		{

			$indexes = array(
				"name" => ""
			);

			foreach($indexes as $index => $value)
			{
				is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
			}

			try
			{
				
				$stmt= $conn->prepare("SELECT count(`st_name`) AS `bool` WHERE `st_name` = ?");
				$stmt->execute(array($indexes['name']));

				if($stmt->fetch()['bool'] > 0)
				{
					$return_values['result'] = 1;
				}
				else
				{
					$return_values['result'] = 0;
				}

			}
			catch(PDOException $e)
			{
				$return_values['ERROR']= $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));				
			}
		}
		else if($_GET['qtype'] == "2")
		{
			//including session validate because this section is related to merchant dashboard
			include('sessionvalidate.php');
			$user = $_SESSION['user'];

			//and $user data is needed here for retrieval of store.
			$return_values = array();
			$ERROR_FLAG = false;

			$indexes = array(
				"st_name"    => "",
				"st_fb_lnk"  => "",
				"st_tw_lnk"  => "",
				"st_in_lnk"  => "",
				"st_wpb_lnk" => "",
				"st_go_lnk"  => "",
				"st_yt_lnk"  => "",
				"st_phone"   => "",
				"st_email"   => "",
				"st_theme_id"=> ""		
			);

			$address_arr = array(
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
				is_set($indexes[$index],$index,$ERROR_FLAG,'POST');
			}

			
			foreach($address_arr as $index => $value)
			{
				is_set($address_arr[$index],$index,$ERROR_FLAG,'POST');
			}

			try
			{
				if(!$ERROR_FLAG)
				{
						
					$conn->beginTransaction();
					$address_arr['customer_id'] = $user['customer_id'];
					$indexes['merchant_id'] = $user['merchant_id'];
					$indexes['st_logo'] = 1;

					$address = $conn->prepare('insert into 
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
					
					$addressBool = $address->execute($address_arr);
					
					$indexes['st_address_id'] = $conn->lastInsertId();

					$stmt= $conn->prepare
					(
					"INSERT INTO `b2c`.`store`
					(`merchant_id`,
					`st_name`,
					`st_logo`,
					`st_address_id`,
					`st_theme_id`,
					`st_fb_lnk`,
					`st_in_lnk`,
					`st_tw_lnk`,
					`st_go_lnk`,
					`st_wpb_lnk`,
					`st_yt_lnk`,
					`st_phone`,
					`st_email`)
					VALUES
					(:merchant_id,:st_name,:st_logo,:st_address_id,:st_theme_id,:st_fb_lnk,:st_in_lnk,:st_tw_lnk,:st_go_lnk,:st_wpb_lnk,:st_yt_lnk,:st_phone,:st_email)
					");
					$storeBool = $stmt->execute($indexes);


					
					if($addressBool && $storeBool)
					{
						
						if($user['c_def_address_id'] == null)
						{
							$_SESSION['user']['c_def_address_id'] = $last_insert_id;
							$stmt = $conn->prepare('update `customers` SET `c_def_address_id` = ? WHERE `customer_id` = ?');
							$stmt->execute(array($indexes['st_address_id'],$user['customer_id']));
							
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
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			catch(PDOException $e)
			{
				$return_values['ERROR']= $e->getMessage();
				die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));				
			}
		}
		else if($_GET['qtype'] == 3)
		{
			//including session validate because this section is related to merchant dashboard
			
			include('sessionvalidate.php');
			$user = $_SESSION['user'];

			//and $user data is needed here for retrieval of store

			$return_values = array();
			
			$indexes = array(
				"st_name",
				"st_fb_lnk",
				"st_tw_lnk",
				"st_in_lnk",
				"st_wpb_lnk",
				"st_go_lnk",
				"st_yt_lnk",
				"st_phone",
				"st_email",
				"st_theme_id"		
			);//for store table


			$address_arr = array(
				'adt_fullname',
				'adt_mob',
				'adt_pincode',
				'adt_addressline1',
				'adt_addressline2',
				'adt_landmark',
				'adt_city',
				'adt_state',
				'adt_type'
			);//for address

			$i = 0;
			$SQL = 'UPDATE `store` SET ';
			//store update operation 
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
			
			$SQL .= " WHERE `merchant_id` ='".$user['merchant_id']."'";
			
			if($i > 0)
			{
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
				$return_values['ERROR'] = "No Data to Update.";
				$return_values['sql1'] = $SQL;
			}
			//store update operation
			
			//address update operation
			$SQL = 'UPDATE `addresses` SET ';
			$i=0;
			foreach($address_arr as $index)
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
			
			$SQL .= " WHERE `customer_id` ='".$user['customer_id']."'";
			
			if($i > 0)
			{
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
				$return_values['ERROR'] = "No Data to Update.";
				$return_values['sql2'] = $SQL;
			}

			
			//address update operation

			
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				
		}
	}
?>