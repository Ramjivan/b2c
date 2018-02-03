window.onload = function(){
	var loc_arr = window.location.toString().split('/');
	switch(loc_arr[loc_arr.length-1])
	{
		case 'product.php':
		
		function get(){
			var method = "GET";
			var url = "/b2c/apies/product";
			var formData = null;
			var success = function(xhttp){
				var tab = document.getElementById('p-tab');
				if(tab !== null)
				{
					var json_response = JSON.parse(xhttp.responseText);
					if(json_response.success)
					{
						for(var i= 0 ; i < json_response.items.length ; i++)
						{
							var row = '<tr>\
										<td>'+json_response.items[i].product_id+'</td>\
										<td>'+json_response.items[i].p_name+'</td>\
										<td>'+json_response.items[i].p_description+'</td>\
										<td>'+json_response.items[i].p_price+'</td>\
										<td>'+json_response.items[i].p_category+'</td>\
										<td>'+json_response.items[i].p_stock+'</td>\
										<td>'+json_response.items[i].img_list_id+'</td>\
										<td><span class="fa fa-pencil"></span></td>\
									   </tr>';
							
							tab.innerHTML += row;
						}
					}
					else
					{
						alert(json_response.ERROR);
					}
				}
				else
				{
					alert('Fatel Error');
				}
			};
			
			var fail = function(xhttp){
				alert(xhttp.responseText);
			};
			
			xhr_call(
				method,
				url,
				formData,
				success,
				fail
			);
		}
		
		(function(){
			get();
		})();
			
		break;
		
		
		case 'Orders.php':
			
			
		break;
		
		
		case 'qna.php':

		break;
		
		default:
		break;
	}
};