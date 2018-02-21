window.onload = function(){
		
		function a_o(){
			var form_param = new FormData();
			
			form_param.set('ord_payment_method',1);
			form_param.set('ord_address_id',1);
			
			xhr_call(
				'POST',
				'apies/order/add',
				form_param,
				function(xhttp){
					if(xhttp.responseText.length > 0)
						{
							var json = JSON.parse(xhttp.responseText);
							if(json.success)
							{
								alert('location -> Payment Gateway');
							}
						}
				},
				function(xhttp){
					
				}
			);
		}
	
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
								get();
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
		
	function get()
	{
			xhr_call(
			'GET',
			'/b2c/apies/cart',
			null,
			function(xhttp){
				var tar = document.getElementById('cart-container');
				var classes = [];
				if(tar !== null)
				{	
					tar.innerHTML = "";
					if(xhttp.responseText.length > 0)
					{
						var json = JSON.parse(xhttp.responseText);
						
						if(json.result > 0 && json.items.length > 0)
						{
							for(var i = 0 ; i < json.items.length ; i++)
							{
								var row = json.items[i];
								var append = '<div class="item-card col-6 clearfix">\
												<div class="col-1">\
													<img class="cart-item-image" src="/b2c/apies/'+row.img+'" width="100%" height="80%"/>\
												</div>\
												<div class="col-1">\
													<h2>'+row.p_name+'</h2>\
													<h5 class="green clearfix">'+(row.stock ? 'In Stock' : 'Out of Stock')+'</h5>\
												</div>\
												<div class="col-2">\
														<span class="color-primary ">'+row.price+'&nbsp;</span><span class="fa fa-inr"></span>\
													</div>\
												<div class="col-1">\
													<button id="45t'+i+'" class="btn btn-danger fa fa-trash"></button>\
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
								
							}
							
							var grand_total = 0;
							var sum = 0;
							
							var sum_span = document.getElementById('ttl-span');
							sum_span.innerHTML = "";
							
							for(var i = 0 ; i < json.items.length ; i++)
							{
								var row = json.items[i];
								const di = row.item_id;
								
								sum = row.qty * row.price;
								grand_total += sum;
								
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
							
							sum_span.innerHTML += grand_total;
							
							var btn_chck = document.getElementById('chckut-btn');
							if(btn_chck !== null)
							{
								btn_chck.onclick = function(){
									cb(a_o);
								};
							}
						}
						else
						{
							tar.innerHTML += '<center><h4>cart is empty.</h4><a class="btn btn-default btn-md btn-danger" href="/">Shop Now</a></center>';
							var sum_span = document.getElementById('ttl-span');
							sum_span.innerHTML += 0;
						}
					}
				}
			},
			function(xhttp){
				alert('ERROR');
			}
		);
	}
	
	get();
};