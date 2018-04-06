<?php
include('sess_val.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			customer | dashboard 
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">

		<?php
			//include head
			include 'headTags.php';
		?>
	</head>
<body>
	<?php
		//including header
		include 'header.php';
	?>
	<!--Content Here-->
	
		<div class="main-container full" style="padding:4px;">
			<div class="row dshbrdcon full">
				<div class="col-6 full">
					<div class="col-6">
						<div id="usrdtls_" class="col-6">
								
						</div>
						<div class="subhead">
							<h5>Manage</h5>
						</div>
						<ul class="dshul">
							<li class="col-2"><a href="/merchant/dashboard/orders.php"><div>Orders</div><p>Track,View Orders</p></a></li>
							<li class="col-2"><a href="/merchant/dashboard/store.php"><div>Store</div><p>Manage Store</p></a></li>
							<li class="col-2"><a href="/merchant/dashboard/qna.php"><div>QNA</div><p>Answere the questions</p></a></li>
							<li class="col-2"><a href="/merchant/dashboard/product.php"><div>Products</div><p>Add, Edit OR Delete the Products.</p></a></li>
							<li class="col-2"><a href="/merchant/dashboard/category.php"><div>Categories</div><p>Add, Edit OR Delete the Categories.</p></a></li>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
	
	<!--Content Here-->

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>