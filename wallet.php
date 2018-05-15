<!DOCTYPE html>
<html>
	<head>
		<title>
			Customer Wallet | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="/js/cuwlt.js"></script>
		
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
		
    <div class="main-container">
		<div class="form-card text-center aS" style="display:none;">
			
			<div class="clearfix">
				<span class="fa fa-4x fa-check-circle"  style="color:#bada55;"></span>
			</div>

			<div class="clearfix">			
				<h3>
					Sucessfully Transfered !
				</h3>
			</div>
		</div>
		
		<div class="wallet-container">
			<div class="ab-box">
				<p>
					Available Pay balance <span class="bal" id="sn_2-3b_ral_4w"><span class="fa fa-rupee"></span></span>
				</p> 
			</div>     
		
			<hr>     
			<div class="row">
				<div class="w-box">
					<a href="#">
						<div class="ico"><span class="fa fa-plus-square"></span></div>Add Money 
					</a>
				</div>
				<div class="w-box">
					<a id="w_sM0" href="#">
						<div class="ico"><span class="fa fa-send"></span></div> Send Money  
					</a>
				</div>
			</div>

			<!--div class="row">
				<div class="w-box">
					<a href="#">
						<div class="ico"><span class="fa fa-book"></span> </div>View Statments
					</a>
				</div>

				<div class="w-box">
					<a href="#">
						<div class="ico"><span class="fa fa-gear"></span></div>Payment Option
					</a>
				</div>
			</div-->
		</div>
		<div id="txn_cn" class="tc_log_container center-block clearfix">
			
		</div>

	<?php
		//including footer
		include 'footer.php';
	?>
    </div>
        
	<div class="dialog" id="wdlg1a">		
		<div id="dhead">
			<span class="fa fa-send">&nbsp;</span>Send Money
			<span class="fa btn right" onclick="this.parentElement.parentElement.style.display='none';document.getElementsByClassName('blurdfg')[0].style.display='none';document.getElementById('actefm').reset();">
				&times;
				</span>
				<div class="clearfix"></div>
		</div>
		<div class="dialog-body">
			<form class="jk-form pdct-form" id="actefm" >
				<div class="vs" id="valsum">
					<h3 id="vsh4" class="vs">Something Went wrong</h3>
				</div>
				<div class="form-group">
					To
					<input id="mob" onchange="validate({'id':'mob','name':'Mobile Number','regex':/^[0-9]+$/,'length':10,'min_length':null,'max_length':null})" type="text" placeholder="10-Digit Mobile Number" name="mob"/>
				</div>
				<div class="form-group">
					Amount
					<input id="amt" onchange="validate({'id':'amt','name':'Amount','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':5})" type="text" placeholder="Amount(in digits)" name="balance"/>
				</div>
				<div class="form-group">
					<input type="button" name="submit" value="send" id="tlsambtn" class="btn btn-default btn-primary-color"/>
				</div>
			</form>
		</div>
	</div>
	<div class="blurdfg">
	</div>
</body>
</html>