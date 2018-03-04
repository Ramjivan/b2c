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
		<script src="js/mcat.js"></script>

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
				<div class="col-1 full">
					<div class="col-6">
						<div class="col-6">
							<img src="default-user.png" class="dashboard-img">
							<small>Hello ! </small> User
						</div>
						<div class="subhead">
							<h5>Manage</h5>
						</div>
						<ul class="dshul">
							<li><a href="cusotmer/address">Address</a></li>
							<li><a href="wallet.php">Wallet</a></li>
						</ul>
					</div>
				</div>
				<div class="col-5 full">
					<div class="col-6">
						<h3>Personal Information</h3>
						<form action="" id="pinfm">
							<div class="form-set">
								<label for="fname">First Name</label>
								<input type="text" id="fname" name="fname"></input>
							</div>
							
							<div class="form-set">
								<label for="lname">Last Name</label>
								<input type="text" id="lname" name="lname"></input>
							</div>
							
							<input type="button" class="btn btn-default btn-primary-color btn-md" value="Edit">
						</form>
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