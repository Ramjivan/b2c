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
                        <div class="pay-mthd" class="inline-block">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="upi-rd" type="radio" name="pay-method" checked>
                                    <label for="upi-rd">UPI</label>
                                </div>
                                <div >
                                    <div class="upi">
                                        <input type="text" id="upiID" placeholder="someone@abc">
                                    </div>
                                    <div class="form-group">			
                                        <input type="button" value="verify" class="btn btn-success">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="pay-mthd">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="cardP" type="radio" name="pay-method">
                                    <label for="cardP">Debit/Credit Card</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="jk-textbox wi-right" placeholder="Enter Cardholder name...">
                                <span class="fa fa-user jk-input-ico-right"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="jk-textbox wi-right" placeholder="Card Number Eg. XXXX XXXX">
                                <span class="fa fa-credit-card jk-input-ico-right"></span>
                            </div>
                            
                            <div class="inline-block">
                                <div class="form-group col-3">
                                    <select id="monthPicker" name="" class="jk-select">	
                                        <option value="" disabled>-- Expiry MM --</option>
                                        
                                    </select>
                                    <span class="fa fa-chevron-down jk-input-ico-right"></span>
                                </div>
                                <div class="form-group col-3">
                                    <select id="yearPicker" name="" class="jk-select">	
                                        <option value="" disabled>-- Expiry YYYY --</option>                                    
                                    </select>
                                    <span class="fa fa-chevron-down jk-input-ico-right"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="jk-textbox wi-right" placeholder="Enter CVV...">
                                <span class="fa fa-lock jk-input-ico-right"></span>
                            </div>
                        </div>
                        
                        
                        <div class="pay-mthd">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="net-bk" type="radio" name="pay-method">
                                    <label for="netbk">Net Banking</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <select id="netBankPicker" name="" class="jk-select">	
                                    <option value="">Choose an Option</option>                                    
                                </select>
                                <span class="fa fa-chevron-down jk-input-ico-right"></span>
                            </div>
                        </div>

                        <div class="pay-mthd">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="3" type="radio" name="pay-method">
                                    <label for="3">Cash On Delivary (COD).</label>
                                </div>
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
    <script>
    //month picker
        for(m = 1; m <= 12; m++) {
            var optn = document.createElement("OPTION");
            optn.text = m;
            // server side month start from one
            optn.value = (m);
        
            document.getElementById('monthPicker').options.add(optn);
        }
        //year picker
        for(y = (new Date()).getFullYear(); y <= 2040; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;
                
                document.getElementById('yearPicker').options.add(optn);
        }
        </script>
</body>
</html>