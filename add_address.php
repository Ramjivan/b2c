<?php
include('sess_val.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Customer Address | B2C
		</title>
		<base href="/b2c/">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/_add_adr_ctmr.js" language="JavaScript" type="text/javascript"></script>
		
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
		<h3>Add Address</h3>
			<form class="jk-form center-block" id="adresform">
				<div id="vsap" class="vs">
					<h3 id="vsh3" class="vs">Something Went wrong</h3>
				</div>
				<div class="form-group">
					House No. / House Name / Customer Name
					<input id="adt_n" onchange="validate({'id':'adt_n','name':'House No. / House Name / Customer Name','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':4,'max_length':16})" type="text" name="adt_fullname" placeholder="House No. / House Name (eg. I-30 or Basant Kunj)"/>
				</div>
				
				<div class="form-group">
					Mobile Number
					<input id="adt_m" onchange="validate({'id':'adt_m','name':'Mobile','regex':/^[0-9]*$/,'length':10,'min_length':null,'max_length':null})" type="tel" name="adt_mob" class="jk-textbox wi-left" placeholder="(+91)1234567890">
					<span class="fa fa-phone jk-input-ico-left"></span>
				</div>
				
				<div class="form-group">
					Pincode
					<input id="adt_p" onchange="validate({'id':'adt_p','name':'Pincode','regex':/^[0-9]*$/,'length':6,'min_length':null,'max_length':null})" type="tel" name="adt_pincode" class="jk-textbox wi-left" placeholder="6 Digit Pincode">
					<span class="fa fa-envelope jk-input-ico-left"></span>
				</div>				
				
				<div class="form-group">
					Address Line 1
					<input id="adt_al1" onchange="validate({'id':'adt_al1','name':'Address Line 1','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null})" type="text" name="adt_addressline1" class="jk-textbox wi-left" placeholder="Address Line 1">
					<span class="fa fa-minus jk-input-ico-left"></span>
				</div>				
				
				<div class="form-group">
					Address Line 2
					<input id="adt_al2" onchange="validate({'id':'adt_al2','name':'Address Line 2','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null})" type="text" name="adt_addressline2" class="jk-textbox wi-left" placeholder="Address Line 2">
					<span class="fa fa-minus jk-input-ico-left"></span>
				</div>				
				
				<div class="form-group">
					Landamrk
					<input id="adt_l" onchange="validate({'id':'adt_l','name':'Landmark','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+/,'length':null,'min_length':8,'max_length':64})" type="text" name="adt_landmark" class="jk-textbox wi-left" placeholder="Landmark">
					<span class="fa fa-landmark jk-input-ico-left"></span>
				</div>

				<div class="form-group">
					State
					<select id="adt_s" class="jk-select" onchange="validate({'id':'adt_s','name':'Landmark','regex':/^([A-Za-z]*)$/,'length':null,'min_length':4,'max_length':128})" type="text" name="adt_state" class="jk-textbox wi-left"><option value="test">test</option></select>
					<span class="fa fa-caret-down jk-input-ico-right"></span>
				</div>	
				
				<div class="form-group">
					City
					<select id="adt_c" class="jk-select" onchange="validate({'id':'adt_c','name':'Landmark','regex':/^([A-Za-z]*)$/,'length':null,'min_length':4,'max_length':128})" type="text" name="adt_city" class="jk-textbox wi-left"><option value="test">test</option></select>
					<span class="fa fa-caret-down jk-input-ico-right"></span>
				</div>
				<div class="form-group">
					Address Type
					<select id="adt_t" class="jk-select" onchange="validate({'id':'adt_t','name':'Landmark','regex':/^[0-9]*$/,'length':1,'min_length':null,'max_length':null})" type="text" name="adt_type" class="jk-textbox wi-left">
						<option value="1">
							Home / Residential
						</option>		
						<option value="1">
							Office / Industrial
						</option>
					</select>
					<span class="fa fa-caret-down jk-input-ico-right"></span>
				</div>	

				<div class="form-group">
					<input type="button" class="btn btn-default btn-primary-color btn-wide" id="ad2te" value="ADD"/>
				</div>
			
			</form>
		</div>
	<?php
		//including footer
		include 'footer.php';
    ?> 
</body>
</html>