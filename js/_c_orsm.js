window.onload = function(){
	
	var loc_arr = window.location.toString().split('/');
	var length = loc_arr.length;
	var id = loc_arr[length-1];

	
	function get(id)
	{
		xhr_call(
			'GET',
			'/b2c/apies/order/'+id,
			null,
			function(xhttp){
				
				var response = xhttp.responseText;
				var json = JSON.parse(response);
				
				var tar = document.getElementById('ordsucont');
				
				if(tar !== null && json.result)
				{
					var h3 = document.createElement('h3');
					h3.appendChild(document.createTextNode('Order #'+id));
					
					tar.appendChild(h3);	
					
					//extra details
					var extra_details = document.createElement('div');
					extra_details.setAttribute('class','clearfix');
					//order date
					var date = document.createElement('div');
					date.setAttribute('class','col-2');
					date.style.fontSize = "12px";
					date.appendChild(document.createTextNode('Ordered on : ' +json.items.orderDetails.ord_date_time));
					//order date
					
					//orderTimeLine
					var otdiv = document.createElement('div');
					otdiv.style.fontSize = "14px";
					otdiv.setAttribute('class','float-right col-1');
					if(json.items.orderDetails.ord_status == 1)
					{
						var aot = document.createElement('a');
						aot.setAttribute('href',"#");
						aot.setAttribute('id',"aot");
						aot.appendChild(document.createTextNode('mark as confirmed'));
						otdiv.appendChild(aot);
					}
					else
					{
						var aot = document.createElement('a');
						aot.appendChild(document.createTextNode('order confirmed'));
						otdiv.appendChild(aot);
					}
					//orderTimeLine
					extra_details.appendChild(date);
					extra_details.appendChild(otdiv);
					tar.appendChild(extra_details);
					//extra_details
					
					var div = document.createElement('div');
					div.setAttribute('class','row');
					
					var address_div = document.createElement('div');
					address_div.setAttribute('class','col-2 clearfix');
					
					var payment_div = document.createElement('div');
					payment_div.setAttribute('class','col-1');
					
					var summary_div = document.createElement('div');
					summary_div.setAttribute('class','col-3');
					
					
					//address tile
					var row = json.items.address;
					
					address_div.innerHTML = '<h4>Address</h4>\
						<div class="col-6">\
						<div class="col-6">'+row.adt_fullname+'</div>\
						<div class="col-6">'+row.adt_addressline1+'</div>\
						<div class="col-6">'+row.adt_addressline2+'</div>\
						<div class="col-6">'+row.adt_landmark+','+row.adt_city+','+row.adt_state+','+row.adt_mob+'</div>\
						<div class="col-6">'+(row.adt_type == 1 ? "Type : Home / residential" : "Type : Office / Industrial")+'</div>\
						<div class="clearfix"></div>';
					
							
					tar.appendChild(address_div);
					//address tile
					
					//payment_mode_tile
						
					payment_div.innerHTML = '<h4>Payment Method</h4><div>'+pm(json.items.orderDetails.ord_payment_method)+'</div>';
					tar.appendChild(payment_div);
					
					//payment_mode_tile
					
					//Order Summary
					
					summary_div.innerHTML = '<h4>Order Summary</h4>';
					
					var table = document.createElement('table');
					table.style.width = "100%";
					
					var theadtr = document.createElement('tr');
					theadtr.innerHTML = '<th></th><th></th>';
					table.appendChild(theadtr);
					
					var total = 0; 
					
					json.items.productDetails.forEach(function(item){
						total += parseInt(item.total_price);
					});
					
					table.innerHTML += '<tr><td>Item Total</td><td class="float-right">'+total+'</td></tr>';
					
					table.innerHTML += '<tr><td><b>Grand Total</b></td><td class="float-right"><b>'+total+'</b></td></tr>';
					
					summary_div.appendChild(table);
					
					tar.appendChild(summary_div);
					
					//Order Summary
					
					
					var product_container = document.createElement('div');
					product_container.setAttribute('class','col-6');
					product_container.style.marginTop = '20px'; 
					
					json.items.productDetails.forEach(function(item){
						var app = '<div class="ordItem col-6">\
								<div class="col-6">\
									<b><a href="/b2c/product?'+item.product_id+'">'+item.p_name+'</a></b>\
								</div>\
								<div class="col-3">\
									Qty : <b>'+item.qty+'</b>\
								</div>\
								<div class="col-3">\
									Total : <b>'+item.total_price+'</b>\
								</div>\
							</div>';
							
						product_container.innerHTML += app;
					});
					
					tar.appendChild(product_container);
				}
				
			},
			function(xhttp){
				
			}
		);
	}
	
	function pm(i)
	{
		if(i == 1)
		{
			return "Pay Balance";
		}
		else if(i == 2)
		{
			return "Credit Card";
		}
		else if(i == 3)
		{
			return "Paytm";
		}
		else if(i == 4)
		{
			return "COD";
		}
	}
	
	
	get(id);
	
};