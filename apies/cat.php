<?php
ini_set("display_errors",1);
session_start();
include('pdo.php');
function is_set_strict(&$var,$index,&$ERROR_FLAG)
{
		
	if(isset($_GET[$index]) && !empty($_GET[$index]))
	{
		$var = trim($_GET[$index]);
	}
	else
	{
		echo $index.' ';
		$ERROR_FLAG = true;
	}
	
}

function is_set_post(&$var,$index,&$ERROR_FLAG)
{
		
	if(isset($_POST[$index]))
	{
		$var = trim($_POST[$index]);
	}
	else
	{
		echo $index.' ';
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

	require dirname(__DIR__).'/vendor/autoload.php';

	$config = require('awsconfig.php');

	$bucket = $config['s3']['bucket'];
	
							
	// Instantiate the client.
	$s3 = new Aws\S3\S3Client([
		'version'     => 'latest',
		'region'      => 'ap-south-1',
		'credentials' => [
		'key'    => $config['s3']['key'],
		'secret' => $config['s3']['secret']
		]
	]);

	
	if(isset($_FILES[$index]) && 
	   is_uploaded_file($_FILES[$index]['tmp_name']))
	{
		//filename must be unique otherwise s3 is gonna rewrite previous file
		$keyname = 'assets/images/'.md5(basename($_FILES[$index]['name']).time());
		
		/* old technique
		//image validation starts
		//$dir = dirname(__DIR__)."/images/";
		//$name = md5(basename($_FILES[$index]['name']).time());
		//$targetFile = $dir.$name;
		old technique*/

		//fileType check
		$imageFileType = strtolower(pathinfo(basename($_FILES[$index]['name']),PATHINFO_EXTENSION));
		
		//$check for validation
		$check = getimagesize($_FILES[$index]["tmp_name"]);
		
		if($check !== false)
		{
			if($imageFileType == "png" || $imageFileType == "jpg" || $imageFileType == "jpeg")
			{
				/*if(move_uploaded_file($_FILES[$index]["tmp_name"], $targetFile.'.'.$imageFileType))
				{
					return array('dir'=>'/images/','imgname'=>$name.'.'.$imageFileType);
				}*/

				$filepath = $_FILES[$index]["tmp_name"];
				
				// Upload a file.
				$result = $s3->putObject(array(
					'Bucket'       => $bucket,
					'Key'          => $keyname.'.'.$imageFileType,
					'SourceFile'   => $filepath,
					'ACL'          => 'private',
					'StorageClass' => 'STANDARD',
					'Metadata'     => array(    
					'param1'       => 'value 1',
					'param2'       => 'value 2'
					)
				));

				//$arr for name of file  
				
				$arr = explode('/',$result['ObjectURL']);
				
				return array('dir' => 'https://d12i8noowh27v6.cloudfront.net/assets/images/' , 'imgname' => $arr[count($arr)-1]);

			}
			else
			{
				echo 'not';
				return null;
			}
		}
		else
		{
			echo 'check'; 
		}
	}
	return null;
}
			   /********************************************
				***************starts here******************
				********************************************/
 
	$id = "";
	
	$return_values = array();
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		if(isset($_SESSION['user']))
		{
			$user = $_SESSION['user'];
		}
		if(isset($_GET['qtype']) && $_GET['qtype'] == "1" && $user !== null && $user['merchant_id'] !== null)
		{
			
			try
			{
				$conn->beginTransaction();

				$ERROR_FLAG = 0;
				
				$return_values = array();
			
				$indexes = array(
				'isTop' => '',
				'parent_id' => ''
				);
		
				foreach($indexes as $index => $value)
				{
					is_set($indexes[$index],$index,$ERROR_FLAG);
				}
				
				$name_arr = upload_image('image');
				$indexes['Merchant_id'] = $user['merchant_id'];
					
				if($ERROR_FLAG == 0 && count($name_arr) > 0)
				{
					$stmt = $conn->prepare('insert into `images` (`customer_id`,`img_dir`,`img_name`) VALUES (?,?,?)');
					$imglst_response = $stmt->execute(array
														(
														$user['customer_id'],
														$name_arr['dir'],
														$name_arr['imgname']
														)
													);
					
					if(!$imglst_response)
					{
						$ERROR_FLAG = true;
					}else
					{
						$indexes['image_id'] = $conn->lastInsertId();
					}
				}
				else
				{
					$ERROR_FLAG = true;
				}
					
				if($ERROR_FLAG == 0)
				{	
					$stmt = $conn->prepare("INSERT INTO `category` (`Merchant_id`,`isTop`,`parent_id`,`image_id`) VALUES (:Merchant_id,:isTop,:parent_id,:image_id)");
					$cat_response = $stmt->execute($indexes);
					
					if($cat_response > 0)
					{
						$indexes = array(
									'cat_name' => "",
									'cat_description' => "",
									'cat_meta_keyword' => "",
									);
					
					
						foreach($indexes as $index => $value)
						{
							is_set($indexes[$index],$index,$ERROR_FLAG);
						}
						
						if($ERROR_FLAG == 0)
						{
							$last_id = $conn->lastInsertId();
							$indexes['Merchant_id'] = $user['merchant_id'];
							$indexes['category_id'] = $last_id;
							$stmt = $conn->prepare("INSERT INTO `categorydescription`(`category_id`, `cat_name`, `cat_description`, `cat_meta_keyword`,`Merchant_id`) VALUES (:category_id,:cat_name,:cat_description,:cat_meta_keyword,:Merchant_id)");
							$cat_desc_response = $stmt->execute($indexes);
						}
					}
					
					if( $cat_response > 0 && $imglst_response > 0 && $cat_desc_response > 0 )
					{
						$return_values['success'] = 1;
						$conn->commit();
					}
					else
					{
						$return_values['success'] = 0;	
					}
				}
			}
			catch(PDOException $e)
			{  
				$conn->rollBack();
				$return_values['ERROR']['insert'] = $e->getMessage();
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		else if( (isset($_GET['qtype']) && $_GET['qtype'] == "2") && isset($_POST['cid']))
		{
			try
			{
				$i = 0;
				$SQL = 'UPDATE `categorydescription` SET ';
				$indexes = array('cat_name','cat_description','cat_meta_keyword');
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
				
				$SQL .= " WHERE `category_id`=".$_POST['cid'];
				
				if($i > 0)
				{
					$conn->beginTransaction();
					$stmt = $conn->prepare($SQL);
					$response = $stmt->execute();
					if($response > 0)
					{
						$conn->commit();
						$return_values['success'] = 1;
					}
				}
				else
				{
					$return_values['ERROR'] =  "400"; 
				}
			}
			catch(PDOException $e)
			{
				$conn->rollBack();
				$return_values['ERROR']['insert'] = $e->getMessage();
				echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		}
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '4')
		{			
			
			$indexes = array('min'=> '','max'=>'','stock'=>'','sort'=>'','page'=>'','catid'=>'');
			
			$ERROR_FLAG=false;
			$return_values = array();
			
			foreach($indexes as $index => $value)
			{
				is_set_post($indexes[$index],$index,$ERROR_FLAG);
			}
			
			if($ERROR_FLAG == false && is_numeric($indexes['page']))
			{
				try
				{
					$start = (intval($indexes['page']) * 10) - 10;
					$end = (intval($indexes['page']) * 10);

					$cat = "SELECT * FROM `products` where ";
					
					$cat.= "(`p_price` >= ? && `p_price` <= ?) && ";
					
					if($indexes['stock'] == 'b2xc')
					{
						$cat.= "`p_stock` >= 0 && ";
					}
					else
					{
						$cat.= "`p_stock` >= 1 && ";
					}
					$cat.= "`p_category`= ?"; 
					
					//for sorting of products
					switch($indexes['sort'])
					{
						case 402:
							$cat.= " ORDER BY `p_price` ASC";
						break;
						case 403:
							$cat.= " ORDER BY `p_price` DESC";
						break;
						case 404:
							$cat.= " ORDER BY `p_added` DESC";
						break;

					}

					$cat.= " LIMIT ".$start.",".$end;
					
					$return_values['SQL'] = $cat;
					$stmt = $conn->prepare($cat);
					$stmt->execute(array($indexes['min'],$indexes['max'],$indexes['catid']));
					
					if($stmt->rowCount() > 0)
					{
						$return_values['result'] = 1;

						$return_values['products'] = $stmt->fetchAll();
						
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

						$SQL = 'SELECT count(*) as `total_products` FROM `products`  where `p_category`=?';
						$stmt = $conn->prepare($SQL);
						$stmt->execute(array($indexes['catid']));
						
						$row = $stmt->fetch();
						
						
						$totalProducts = $row['total_products'];
						
						if($totalProducts > 0)
						{
							$totalPages = ceil($totalProducts / 10);
							
							$return_values['TotalPages'] = $totalPages;
							$return_values['NextPage'] = ($totalPages > $_POST['page'] ? $_POST['page']+1 : $totalPages);
							
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
						
				}
				catch(PDOException $e)
				{
					$return_values['ERROR'] = $e->getMessage();
					die(json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
				}
			}
			else
			{
				$return_values['ERROR'] = "401";
			}
			echo json_encode($return_values,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "GET") 
	{
		if(isset($_GET['qtype']) && $_GET['qtype'] == '1')
		{			
			//get category of merchant
			$return_values = array();
			$user = $_SESSION['user'];
			
			try
			{
				$cat = "select `category`.`category_id`,`category`.`parent_id`,`categorydescription`.`cat_name`,`categorydescription`.`cat_description`,`categorydescription`.`cat_meta_keyword`,`category`.`dateAdded`,`category`.`image_id` from `category`,`categorydescription` where `category`.`category_id` = `categorydescription`.`category_id` && `category`.`Merchant_id` = ?"; 
				$stmt = $conn->prepare($cat);
				$stmt->execute(array($user['merchant_id']));
				
				if($stmt->rowCount() > 0)
				{
					$return_values['result'] = 1;

					$return_values['items'] = $stmt->fetchAll();
					$i = 0;
					foreach($return_values['items'] as $cat)
					{
						if($cat['parent_id'] !== "")
						{
							$stmt = $conn->prepare('select * from `categorydescription` where `category_id` = ?');
							$stmt->execute(array($cat['parent_id']));
							if($stmt->rowCount() > 0)
							{
								$return_values['items'][$i]['parent_name'] = $stmt->fetch()['cat_name']; 
							}
						}
						$i++;
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
		else if(isset($_GET['qtype']) && $_GET['qtype'] == '2')
		{			
			//get index category
			$return_values = array();
			
			try
			{
				$cat = "select `category`.`category_id`,`category`.`parent_id`,`categorydescription`.`cat_name`,`categorydescription`.`cat_description`,`categorydescription`.`cat_meta_keyword`,`category`.`dateAdded`,`category`.`image_id` from `category`,`categorydescription` where `category`.`category_id` = `categorydescription`.`category_id` && `category`.`isTop`=? &&  `category`.`parent_id`= 1"; 
				$stmt = $conn->prepare($cat);
				$stmt->execute(array(1));
				
				if($stmt->rowCount() > 0)
				{
					$return_values['result'] = 1;

					$return_values['items'] = $stmt->fetchAll();
					$i = 0;
					foreach($return_values['items'] as $cat)
					{
						if($cat['parent_id'] !== "")
						{
							$stmt = $conn->prepare('select * from `categorydescription` where `category_id` = ?');
							$stmt->execute(array($cat['parent_id']));
							if($stmt->rowCount() > 0)
							{
								$return_values['items'][$i]['parent_name'] = $stmt->fetch()['cat_name']; 
							}
						}
						$i++;
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
		}else if(isset($_GET['qtype']) && $_GET['qtype'] == '3')
		{			
			//get category single category
			$return_values = array();
			
			try
			{
				$cat = "select `category`.`category_id`,`category`.`parent_id`,`categorydescription`.`cat_name`,`categorydescription`.`cat_description`,`categorydescription`.`cat_meta_keyword`,`category`.`dateAdded`,`category`.`image_id` from `category`,`categorydescription` where `category`.`category_id` = `categorydescription`.`category_id` && `category`.`parent_id`= ?"; 
				$stmt = $conn->prepare($cat);
				$stmt->execute(array($_GET['id']));
				
				if($stmt->rowCount() > 0)
				{
					$return_values['result'] = 1;

					$return_values['items'] = $stmt->fetchAll();
					$i = 0;
					foreach($return_values['items'] as $cat)
					{
						if($cat['parent_id'] !== "")
						{
							$stmt = $conn->prepare('select * from `categorydescription` where `category_id` = ?');
							$stmt->execute(array($cat['parent_id']));
							if($stmt->rowCount() > 0)
							{
								$return_values['items'][$i]['parent_name'] = $stmt->fetch()['cat_name']; 
							}
						}
						$i++;
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
?>	