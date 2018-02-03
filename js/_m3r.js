window.onload = function(){
	var loc_arr = window.location.toString().split('/');
	switch(true)
	{
		case /product.php/.test(loc_arr[loc_arr.length-1]):
		
			var formvalidation = [
				{'id':'name','name':'Email Address','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
				{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
				{'id':'price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
				{'id':'category','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null},
				{'id':'stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
				{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null},
				{'id':'hlgt1','name':'Hightlight1','regex':null,'length':null,'min_length':5,'max_length':null},
				{'id':'sp_name1','name':'Spec Name 1','regex':null,'length':null,'min_length':5,'max_length':null},
				{'id':'sp_value1','name':'Spec Value 1','regex':null,'length':null,'min_length':5,'max_length':null}
			];
			
			function get()
			{
				var method = "GET";
				var url = "/b2c/apies/product";
				var formData = null;
				var success = function(xhttp){
					var tab = document.getElementById('p-tab');
					if(tab !== null)
					{
						document.getElementsByTagName('table tbody').innerHTML = "";
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
				
				get(); //get data
				
				var btn = document.getElementById('add');
				if(btn !== null)
				{
					var success = function(xhttp){
						get();
					};
					var fail = function(xhttp){
						alert(xhttp.responseText+"dfdf");
					};
					btn.addEventListener('click',function(){
						submit_form('pctafm',formvalidation,'vs','/b2c/apies/product/add','POST',success,fail);
					});
				}
			})();
			
		break;
		
		
		case /Orders.php/.test(loc_arr[loc_arr.length-1]):
			
		break;
		
		
		case /qna.php/.test(loc_arr[loc_arr.length-1]):

		break;
		
		default:
		break;
	}
};