<?php
include('sess_val.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Customer Address | B2C
		</title>
		<base href="/">
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
			
			<div id="addressrow" class="row gutter">
				<a href="customer/address/add">
				<div class="jk-address-tile-container col-2">
					<div class="jk-address-tile col-6">
						<div class="jk-address-tile-add-div"><i class="fa fa-plus"></i></div>
					</div>
				</div>
				</a>
			</div>
			
		</div>
	<?php
		//including footer
		include 'footer.php';
    ?> 
</body>
</html>