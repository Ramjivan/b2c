<!DOCTYPE html>
<html>
	<head>
		<title>
			Payment | B2C
		</title>
		<meta name="description" content="">
        <meta name="keywords" content="">
        <script language="JavaScript" src="/js/hndp.js" type="text/javascript"></script>
		
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
					<form class="jk-form pdct-form" action="/apies/hdlpm.php" id="stafrm" method="POST" enctype="multipart/form-data">
						<div id="vsap" class="vs">
							<h3 id="vsh3" class="vs">Something Went wrong</h3>
						</div>
                        <!--Don't include this when adding money to Pay balance render only when paying for order and balance is greater then zero-->
						<div id="pybal_co" class="form-group">
                            
                        </div>
                        <hr>
                        <div class="pay-mthd" class="inline-block">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="upi-rd" type="radio" value="102" name="pay-method">
                                    <label for="upi-rd">UPI</label>
                                </div>
                                <div class="pay-grp" id="upi-gp">
                                    <div class="form-group">
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
                                    <input id="cardP" type="radio" value="103" name="pay-method">
                                    <label for="cardP">Debit/Credit Card</label>
                                </div>
                            </div>
                            <div class="pay-grp" id="card-gp">
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
                                            <option value="" >-- Expiry MM --</option>
                                            
                                        </select>
                                        <span class="fa fa-chevron-down jk-input-ico-right"></span>
                                    </div>
                                    <div class="form-group col-3">
                                        <select id="yearPicker" name="" class="jk-select">	
                                            <option value="" >-- Expiry YYYY --</option>                                    
                                        </select>
                                        <span class="fa fa-chevron-down jk-input-ico-right"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="jk-textbox wi-right" placeholder="Enter CVV...">
                                    <span class="fa fa-key jk-input-ico-right"></span>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="pay-mthd">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="net-bk" type="radio" value="104" name="pay-method">
                                    <label for="net-bk">Net Banking</label>
                                </div>
                            </div>
                            <div class="form-group pay-grp" id="nb-gp">
                                <select id="netBankPicker" name="" class="jk-select">	
                                <option value="" selected="selected">Choose an Option</option><option value="ICI">ICICI Bank</option><option value="SBI">State Bank of India</option><option value="UTI">Axis Bank</option><option value="HDF">HDFC Bank</option><optgroup label="-----------------"></optgroup><option value="ATP">Airtel Payments Bank</option><option value="ALB">Allahabad Bank</option><option value="ADB" ="">Andhra Bank</option><option value="BDN" ="">Bandhan bank</option><option value="BBK" ="">Bank of Bahrain and Kuwait</option><option value="BBC">Bank of Baroda - Corporate Banking</option><option value="BBR">Bank of Baroda - Retail Banking</option><option value="BOI" ="">Bank of India</option><option value="BOM">Bank of Maharashtra</option><option value="BCB" ="">Bassien Catholic Co-Operative Bank</option><option value="BMN" ="">Bharatiya Mahila Bank</option><option value="CNB" ="">Canara Bank</option><option value="CSB">Catholic Syrian Bank</option><option value="CBI">Central Bank of India</option><option value="CUB">City Union Bank</option><option value="CRP" ="">Corporation Bank</option><option value="COB">Cosmos Bank</option><option value="DCB">DCB Bank</option><option value="DEN">Dena Bank</option><option value="DBK">Deutsche Bank</option><option value="DLB">Dhanlakshmi Bank</option><option value="DBS">Digibank by DBS</option><option value="FBK">Federal Bank</option><option value="IDB">IDBI Bank</option><option value="IDN">IDFC Bank</option><option value="ING" ="">ING Vysya Bank</option><option value="INB">Indian Bank</option><option value="IOB">Indian Overseas Bank</option><option value="IDS">IndusInd Bank</option><option value="JKB">Jammu &amp; Kashmir Bank</option><option value="JSB">Janata Sahakari Bank</option><option value="KJB" ="">Kalyan Janata Sahakari Bank</option><option value="KBL">Karnataka Bank Ltd</option><option value="KVB">Karur Vysya Bank</option><option value="162">Kotak Bank</option><option value="LVC">Laxmi Vilas Bank - Corporate</option><option value="LVR">Laxmi Vilas Bank - Retail</option><option value="OBC">Oriental Bank of Commerce</option><option value="PNY">PNB YUVA Netbanking</option><option value="PMC" ="">Punjab &amp; Maharashtra Co-operative Bank</option><option value="PSB">Punjab &amp; Sind Bank</option><option value="CPN">Punjab National Bank - Corporate Banking</option><option value="PNB" ="">Punjab National Bank - Retail Banking</option><option value="RTN">RBL Bank Limited</option><option value="SWB" ="">Saraswat Bank</option><option value="SVC">Shamrao Vitthal Co-operative Bank</option><option value="SIB">South Indian Bank</option><option value="SCB">Standard Chartered Bank</option><option value="SBJ" ="">State Bank of Bikaner &amp; Jaipur</option><option value="SBH" ="">State Bank of Hyderabad</option><option value="SBM" ="">State Bank of Mysore</option><option value="SBP" ="">State Bank of Patiala</option><option value="SBT" ="">State Bank of Travancore</option><option value="SYD">Syndicate Bank</option><option value="TJB" ="">TJSB Bank</option><option value="TNC">Tamil Nadu State Co-operative Bank</option><option value="TMB">Tamilnad Mercantile Bank Ltd.</option><option value="MSB" ="">The Mehsana Urban Co Op Bank Ltd</option><option value="RBS" ="">The Royal Bank of Scotland</option><option value="UBI" ="">Union Bank of India</option><option value="UNI">United Bank of India</option><option value="VJB">Vijaya Bank</option><option value="YBK">Yes Bank Ltd</option>                                 
                                </select>
                                <span class="fa fa-chevron-down jk-input-ico-right"></span>
                            </div>
                        </div>

                        <div class="pay-mthd">
                            <div class="form-group">
                                <div class="jk-radio">
                                    <input id="cod" type="radio" value="105" name="pay-method">
                                    <label for="cod">Cash On Delivary (COD).</label>
                                </div>
                            </div>
                        </div>
                        
						<div class="form-group">
							<button id="st_s_btn" class="btn btn-success"> Continue </button>
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


