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
			<div class="center-block">
                <h2>Select a payment method</h2>
                <div id="main-str-cnr">
					<form class="jk-form pdct-form" id="stafrm" enctype="multipart/form-data">
						<div id="vsap" class="vs">
							<h3 id="vsh3" class="vs">Something Went wrong</h3>
						</div>
                        
						<div class="form-group">
                            <div class="jk-checkbox">
                                <input id="i1" type="checkbox">
                                <label for="i1">Use your <span class="fa fa-rupee"></span> 50 Pay Balance.</label>
                            </div>
                        </div>
                        
                        <hr>

                        <div class="form-group">
							<div class="jk-radio">
                                <input id="upi-rd" type="radio" name="pay-method" checked>
                                <label for="upi-rd">UPI</label>
                            </div>

                            <div class="upi">
                                <input type="text" id="upiID">
                            </div>
                        </div>
                        
						<div class="form-group">
							<div class="jk-radio">
                                <input id="3" type="radio" name="pay-method" checked>
                                <label for="3">Cash On Delivary (COD).</label>
                            </div>
						</div>

						

						

						<div class="form-group">
							<input type="button" id="st_s_btn" class="btn btn-success" value="Continue"/>
						</div>
					</form>
                </div>
            </div>
			<div class="clearfix"></div>
		</div>
		
		

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>