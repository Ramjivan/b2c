<?php
require_once 'sess_val.php';
?>
<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			Orders | dashoboard
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script language="JavaScript" type="text/javascript" src="/js/_m3r.js"></script>

		
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
	
		<div class="container"> 
			<div class="center-block">
				<h3>Orders</h3>
				<!--div class="ord_filter">
					<form id="kj46fn" name="filfrm">
						<div class="row form-card">
							<div class="col-2">
								<div class="">
									<select class="jk-select" name="tspan">
										<option value="28">1 Month</option>
										<option value="56">2 Month</option>
										<option value="168">6 Month</option>
									</select>
									<span class="fa fa-chevron-down jk-input-ico-right" style="z-index:1;"></span>
								</div>
							</div>
							
							<div class="col-2">
								<div class="">
									<select class="jk-select" name="tspan">
										<option value="1_pending">Pending</option>
										<option value="2_confirmed">Confirmed</option>
										<option value="3_shipped">Shipped</option>
										<option value="4_delivered">Delivered</option>
									</select>
									<span class="fa fa-chevron-down jk-input-ico-right" style="z-index:2;"></span>
								</div>
							</div>
							
							<div class="col-2">
								<button class="btn btn-default btn-primary-color">Apply Fillter</button>
							</div>
						</div>
					</form>
				</div-->
				<div class="log-table">
					<table id="p-tab" class="stripped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Status</th>
								<th>Item count</th>
								<th>Payment Method</th>
								<th>Invoice</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="tbdy">
						</tbody>
					</table>
				</div>		
			</div>
		</div>

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>