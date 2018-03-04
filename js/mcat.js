window.onload = function(){
	
	var arr = window.location.toString().split('/');
	var len = arr.length;
	var temp = arr[len-1].split('=');
	var cat_id = temp[temp.length-1];
	
	function get(id,page){
		
		xhr_call(
			'GET',
			'apies/product/page/'+page+'/category/'+id,
			null,
			function(xhttp){
				var res = xhttp.responseText ;
				var json = JSON.parse(res);
				var target = document.getElementById('mpc_cont_12');
				
				if(json !== null && json.result)
				{
					//products
					var app = "";
					json.products.forEach(function(item){
						
						var avgRating = 0;
						
						for(var i = 1 ; i <= 5 ; i++)
						{
							avgRating += parseInt(item.rating[i]);
						}

						avgRating = !isFinite(avgRating/parseInt(item.rating.count)) ? 0 : avgRating/parseInt(item.rating.count);
						
						app = '<div class="prdct">\
									<a class="prdct-lnk-a" href="product?'+item.product_id+'">\
										<div class="img">\
											<img src="apies/'+item.images[1] + item.images[0] +'"/>\
										</div>\
										<div>\
											<b>'+item.p_name+'</b>\
										</div>\
										<div class="details">\
											<div class="price">\
												<span class="p_prspn"><span class="fa fa-inr"></span>'+item.p_price+'</span>\
											</div>\
											<div class="rating">\
												<span class="ra_ti_avgr">'+avgRating+'&nbsp;<span class="fa fa-star"></span></span><span>&nbsp;('+item.rating.count+')</span>\
											</div>\
										</div>\
									</a>\
								</div>';
						target.innerHTML += app;
						
					});
					//products
					
					//category
					document.title = json.category.cat_name+" | B2C";
					
					var categoryHead =  document.getElementById('cat_hed');
						
						categoryHead.innerHTML += "<h3>"+json.category.cat_name+"</h3>";
					
					var categorySub =  document.getElementById('cat_sub_');
						if(json.category.subcategory.length > 0)
							categorySub.innerHTML += "<h4>Sub-Categories</h4>";
							json.category.subcategory.forEach(function(item){
								categorySub.innerHTML += '<a class="_Sbct" href="mcat='+item.category_id+'">'+item.cat_name+'</a>';							
							});
					
					
					
					//category
				}
			},
			function(xhttp){
				
			}
		);
		
		
		
	}
	
	get(cat_id,1);
	
	
};