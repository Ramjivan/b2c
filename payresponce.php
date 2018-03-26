<!DOCTYPE html>
<html>
	<head>
		<title>
			Payment | B2C
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
		
        <div class="container"> 
			<div class="center-block" style="text-align:center;">
                <span class="fa fa-check-square" id="payresico"></span>
                <h1>Thank You! Your order for [product Name] is sucessful.</h1>
                <p>Your order id - #238703459</p>
                <p><a href="/">Go to Home Page</a> </p>
            </div>
            <div class="clearfix"></div>

            <div class="center-block" style="text-align:center;">
                <span class="fa fa-warning" id="payresico"></span>
                <h1>Error! Payment Failed.</h1>
                <p><a href="/">Retry with another Payment Method</a> OR <a href="/">Go to Home Page</a></p>
            </div>
            <div class="clearfix"></div>
		</div>
		
		

	<?php
		//including footer
		include 'footer.php';
    ?>
    
        
</body>
</html>


