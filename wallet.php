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
				'/b2c/apies/cart/edit/'+args[1]+'/qty/'+args[2],
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
				'/b2c/apies/cart/delete/'+args[1],
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
		
    <div class="main-container">
        <div class="wallet-container">
        <div class="ab-box">
            <p>
                Available Pay balance <span class="bal"><span class="fa fa-rupee"></span>5000.00</span>
             </p> 
        </div>     
        
        <hr>     
            <div class="row">
                <div class="w-box">
                    <a href="">
                        <div class="ico"><span class="fa fa-plus-square"></span></div>Add Money 
                    </a>
                </div>
                <div class="w-box">
                    <a href="">
                        <div class="ico"><span class="fa fa-send"></span></div> Send Money  
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="w-box">
                    <a href="">
                        <div class="ico"><span class="fa fa-book"></span> </div>View Statments
                    </a>
                </div>

                <div class="w-box">
                    <a href="">
                        <div class="ico"><span class="fa fa-gear"></span></div>Payment Option
                    </a>
                </div>
            </div>
                
            
            
        </div>
    </div>
            

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>