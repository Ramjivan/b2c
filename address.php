<?php
include('sess_val.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Customer Address | B2C
		</title>
		<base href="/b2c/" target="_blank">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/adr_ctmr.js" language="JavaScript" type="text/javascript"></script>
		
		<?php
			//include head
			include 'headTags.php';
        ?>
    
</head>

<body class="body">
	<?php
		//including header
		include 'header.php';
	?>
	<!--Content Here-->
		<div id="cart-container" class="main-container clearfix" style="padding:4px;">
		<h3>Addresses</h3>
			
			<div class="row">
				<div class="jk-address-tile col-3">
					<div class="col-6">
						<div class="col-6">
							House No. XYZ ABC
						</div>
						<div class="col-6">
							Address line 1 | address line 2
						</div>
						<div class="col-6">
							Landmark,City,State,Country
						</div>
						<div class="col-3">
							Type
						</div>
						<div class="col-3">
							<button>Del btn</button> 
						</div>
					</div>
				</div>
				<div class="col-3">
					1
				</div>
				<div class="col-3">
					1
				</div>
				<div class="col-3">
					1
				</div>
			</div>
			
		</div>
	<?php
		//including footer
		include 'footer.php';
    ?> 
</body>
</html>