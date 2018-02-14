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
		
		<script>
xhr_call(
	'GET',
	'/b2c/apies/cart',
	null,
	function(xhttp){
		var tar = document.getElementById('cart-container');
		var classes = [];
		if(tar !== null)
		{	
			if(xhttp.responseText.length > 0)
			{
				var json = JSON.parse(xhttp.responseText);
				
				if(json.result > 0 && json.items.length > 0)
				{
					for(var i = 0 ; i < json.items.length ; i++)
					{
						var row = json.items[i];
						var append = '<div class="item-card col-5">\
										<div class="col-1">\
											<img src="/b2c/apies/'+row.img+'" width="100%" height="80%"/>\
										</div>\
										<div class="col-3">\
											<h3>'+row.p_name+'</h3>\
											<h5 class="green">'+(row.stock ? 'In Stock' : 'Out of Stock')+'</h5>\
											<div class="col-1">\
												<span class="color-primary ">'+row.price+'&nbsp;</span><span class="fa fa-inr"></span>\
											</div>\
										</div>\
										<div class="col-1">\
											<button class="btn btn-info">Delete</button>\
										</div>\
										<div class="right">\
											<select  class="jk-select" id="9t7'+i+'">\
												<option value="1">1</option>\
												<option value="2">2</option>\
												<option value="3">3</option>\
												<option value="4">4</option>\
												<option value="5">5</option>\
												<option value="6">6</option>\
												<option value="7">7</option>\
												<option value="8">8</option>\
												<option value="9">9</option>\
												<option value="10">10</option>\
											</select>\
										</div>\
									</div>';
						tar.innerHTML += append;
						
						document.getElementById('9t7'+i).value = row.qty;
						
					}
				}
				else if(json.MESSAGE !== undefined)
				{
					alert(json.MESSAGE);
				}
			}
		}
	},
	function(xhttp){
		alert('ERROR');
	}
);
		</script>
		
	</head>
<body>
	<?php
		//including header
		include 'header.php';
	?>
		
		<div id="cart-container" class="main-container">
			<div class="item-card col-5">
				
				<div class="col-1">
					<img src="default-user.png" width="100%" height="80%"/>
				</div>
				
				<div class="col-3">
					<h3>Mi Mix 2 Black January 2018</h3>
					<h5 class="green">In Stock</h5>
					<div class="col-1">
						<span class="color-primary ">566&nbsp;</span><span class="fa fa-inr"></span>
					</div>
				</div>

				<div class="col-1">
					<button class="btn btn-info">Delete</button> 
				</div>

				<div class="right">
					<select  class="jk-select" id="9t7">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
				
			</div>
		</div>
		

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>