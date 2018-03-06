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
						<div class="col-6">
							<img src="default-user.png" class="dashboard-img">
							<small>Hello ! </small> User
						</div>
						<div class="subhead">
							<h5>Manage</h5>
						</div>
						<ul class="dshul">
							<li class="col-2"><a href="cusotmer/address"><div>Address</div><p>Add,Delete Addresses</p></a></li>
							<li class="col-2"><a href="wallet.php"><div>wallet</div><p>Send Money,Check Your Previous statements...much more</p></a></li>
							<li class="col-2"><a href="customer/orders"><div>orders</div><p>Track,View Orders</p></a></li>
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