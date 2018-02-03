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

			   /********************************************
				***************starts here******************
				********************************************/
 
	$id = "";
	
	$return_values = array();
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
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
									'cat_meta_keyword' => ""
									);
					
					
						foreach($indexes as $index => $value)
						{
							is_set($indexes[$index],$index,$ERROR_FLAG);
						}
						
						if($ERROR_FLAG == 0)
						{
							
							$last_id = $conn->lastInsertId();
							$indexes['category_id'] = $last_id;
							$stmt = $conn->prepare("INSERT INTO `categorydescription`(`category_id`, `cat_name`, `cat_description`, `cat_meta_keyword`) VALUES (:category_id,:cat_name,:cat_description,:cat_meta_keyword)");
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
						$return_values['fail'] = 0;	
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
	}
	else if($_SERVER['REQUEST_METHOD'] == "POST") 
	{
		
	}
?>	