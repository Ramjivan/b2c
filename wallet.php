<!DOCTYPE html>
<html>
	<head>
		<title>
			new Page | B2C
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
			<div class="tc-card col-3 center">
				<div class="row">
					<div class="col-2"><h4>#txn-c6246fbc3c</h4></div>
					<div class="col-2"><span class="amt"><span class="fa fa-inr"></span>200</span></div>
					<div class="col-2"><span class="tm"><span class="fa fa-calendar-o"></span>2018/3/6</span></div>
				</div>
			</div>
		</div>
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
		

	<?php
		//including footer
		include 'footer.php';
	?>
	<div class="blurdfg">
	</div>
	<script>
			//onclick listener for sendMoney btn 
			document.getElementById('w_sM0').onclick = function(){
				document.getElementsByClassName('dialog')[0].style.display = 'block';
				document.getElementsByClassName('blurdfg')[0].className += ' active'; 
			};
			//onclick listener for sendMoney 
			
			function sd_mo()
			{
				var fval = [
					{'id':'mob','name':'Mobile Number','regex':/^[0-9]+$/,'length':10,'min_length':null,'max_length':null},
					{'id':'amt','name':'Amount','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':5}
				];
				
				var s = function(xhttp){
					var response = xhttp.responseText;
					var json = JSON.parse(response);
					
					if(json.success)
					{						
						//closing dialog 
						document.getElementById('wdlg1a').style.display='none';
						document.getElementsByClassName('blurdfg')[0].style.display='none';
						document.getElementById('actefm').reset();
						//closing dialog
						
						document.getElementsByClassName('aS')[0].style.display='block';
					}
					else if(json.ERROR !== undefined)
					{
						alert(json.ERROR);
					}
				
				};
				var f = function(xhttp){
					alert('Error While etablishing a connection to server');
				};
				
				submit_form('actefm',fval,'valsum','apies/wallet/transfer','POST',s,f);
			}
			
			function g()
			{
				xhr_call(
					'GET',
					'apies/wallet',
					null,
					function(xhttp){
						var res = xhttp.responseText;
						var json = JSON.parse(res);
						if(json !== null)
						{								
							var tar = document.getElementById("sn_2-3b_ral_4w");
							
							if(tar !== null)
							{
								tar.innerHTML += json.wallet.balance;
							}
						}
					
					},
					function(xhttp){
						
					}
				);
			}
			
			
			//set onclick listener on form submit
				document.getElementById('tlsambtn').onclick = function(){
					cb(sd_mo);
				};
			//set onclick listener on form submit
			g();
			
	</script>
</body>
</html>