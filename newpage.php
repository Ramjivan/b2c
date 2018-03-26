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
		var last_qty = 0;
		function e_q(args){
			var tar = args[3];
			tar.parentNode.parentNode.style.filter = 'blur(0.3px)';
			xhr_call(
				'GET',
				'/apies/cart/edit/'+args[1]+'/qty/'+args[2],
				null,
				function(xhttp){
					if(xhttp.responseText.length > 0)
					{
						var json = JSON.parse(xhttp.responseText);
						if(json.success)
						{
							tar.parentNode.parentNode.style.filter = 'none';
						}
					}
				},
				function(xhttp){
					tar.parentNode.parentNode.style.filter = 'none';
					tar.value = last_qty;
				}
			);
		}
		
		function d_q(args){
			var tar = args[2];
			tar.parentNode.parentNode.style.filter = 'blur(0.3px)';
			xhr_call(
				'GET',
				'/apies/cart/delete/'+args[1],
				null,
				function(xhttp){
					if(xhttp.responseText.length > 0)
					{
						var json = JSON.parse(xhttp.responseText);
						if(json.success)
						{
							tar.parentNode.parentNode.parentNode.removeChild(tar.parentNode.parentNode);
						}
					}
				},
				function(xhttp){
					tar.parentNode.parentNode.style.filter = 'none';
				}
			);
		}
	
xhr_call(
	'GET',
	'/apies/cart',
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
											<img src="/apies/'+row.img+'" width="100%" height="80%"/>\
										</div>\
										<div class="col-3">\
											<h3>'+row.p_name+'</h3>\
											<h5 class="green">'+(row.stock ? 'In Stock' : 'Out of Stock')+'</h5>\
											<div class="col-1">\
												<span class="color-primary ">'+row.price+'&nbsp;</span><span class="fa fa-inr"></span>\
											</div>\
										</div>\
										<div class="col-1">\
											<button id="45t'+i+'" class="btn fa fa-trash"></button>\
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
						const di = row.item_id;
						document.getElementById('9t7'+i).value = row.qty;
							
							document.getElementById('9t7'+i).onfocus = function(){
								last_qty = this.value;
							};
							
							document.getElementById('9t7'+i).onchange = function(){
								cb(e_q,di,this.value,this);
							};
							
						document.getElementById('45t'+i).onclick = function(){
							cb(d_q,di,this);
						};
					}
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
		
		
			<div class="jk-review-tile col-3">
				<div  class="jk-review-tile-header clearfix">
					<div class="col-6">
						<img style="max-width:30px;min-height:30px;height:30px;width:30px;border-radius:100%;vertical-align:middle;margin-top:-1px;" src="apies/products/uploads/22be20b1bf2190a3ecccc3dea69d7ae3.jpg">&nbsp;Kunal Awasthi
					</div>
					<div class="col-6">
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</div>
				</div>
				<div class="col-6">
					blah lblah adgdknf
					blah lblah adgdknf
					lreon ispan loren 	lreon ispan loren 
					lreon	lreon ispan loren 
					lreon ispan loren 
				 ispan loren 
					lreon ispan loren 
					lreon ispan loren 
				
					lreon ispan loren 
				
					lreon ispan loren 
					
				</div>
			</div>
		

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>