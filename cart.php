<?php
include('sess_val.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Cart | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/cart.js" language="JavaScript" type="text/javascript"></script>
		
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
		<div class="main-container clearfix" style="padding:4px;">
		<h3>Shopping Cart</h3>
			<div class="row cart-flex-box">
				<div class="col-5">
					<div id="cart-container" class="cart-content col-6">
					</div>
				</div>
				<div class="chckot-flex col-1" id="chckot-con">
					<div class="cart-content col-6">
						<div class="clearfix">
							<span class="font-13px">Total</span>
							<span class="cart-total-span"><span id="ttl-span"></span>&nbsp;<span class="fa fa-1x fa-inr"></span></span>
						</div>
						<div>
							<a class="btn btn-wide btn-primary-color center" href="/payment.php" id="chckut-btn">checkout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
		//including footer
		include 'footer.php';
    ?> 
</body>
</html>