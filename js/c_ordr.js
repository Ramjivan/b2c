window.onload = function(){
		function st(i)
		{
			if(i == 1)
			{
				return "pending";
			}
			else if(i == 2)
			{
				return "confirmed";
			}
			else if(i == 3)
			{
				return "shipped";
			}
			else if(i == 4)
			{
				return "delivered";
			}
		}
		
		function pm(i)
		{
			if(i == 101 )
			{
				return "Pay Balance";
			}
			else if(i == 102)
			{
				return "UPI";
			}
			else if(i == 103)
			{
				return "Credit/Debit Card";
			}
			else if(i == 104)
			{
				return "Net Banking";
			}
			else if(i == 105)
			{
				return "Cash On Delivery(COD)";
			}
		}
		
		function get()
		{		
			xhr_call(
				'GET',
				'apies/customer/order/time/28',
				null,
				function(xhttp){					
					
					var response = xhttp.responseText;
					var json = JSON.parse(response);
					var tar = document.getElementById('tbdy');
					
					if(json.result)
					{
						var append = "";
						
						json.items.forEach(function(item){
							
							
							var append = '<tr>\
											<td>'+item.ord_date_time+'</td>\
											<td>'+st(item.ord_status)+'</td>\
											<td>'+item.pl_count+'</td>\
											<td>'+pm(item.ord_payment_method)+'</thd>\
											<td>'+(item.ord_invoice_id !== null ? '<a href="/ivcx?'+item.ord_invoice_id+'">invoice</a>' : 'No Invoice')+'</td>\
											<td><a class="btn btn-primary-color text-center" href="order/'+item.ord_pl_id+'"><i class="fa fa-arrow-right"></i></a></td>\
										</tr>';	
							tar.innerHTML += append;
						});
					}
					
				},
				function(xhttp){
					
				}
			);
	
		}
		
		(function(){get();})();
		
		
};