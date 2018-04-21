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
							avgRating += parseInt(item.rating[i])*i;
						}

						avgRating = !isFinite(avgRating/parseInt(item.rating.count)) ? 0 : avgRating/parseInt(item.rating.count);
						
						app = '<div class="prdct">\
									<a class="prdct-lnk-a" href="product?'+item.product_id+'">\
										<div class="img">\
											<img src="'+item.images[1] + item.images[0] +'"/>\
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
	
	var ef = function()
	{

		//validation start
		var raiseError =  false;
		var Message = [];
		
		if((p_min < 0 && p_max < 0) || (p_min > p_max))
		{
			raiseError = true;
			Message.push("Please Select a realistic price");
		}

		if(stck !== null)
		{
			raiseError = true;
			Message.push("Please Select availability");
		}
		//validation ends 
		

		//init
		if(raiseError)
		{
			/*put target empty*/
			var target = document.getElementById('mpc_cont_12');
			target.innerHTML = "";
			/*put target empty*/

			/*
			*put blured or loading screen*/
			target.innerHTML = "Loading"; // temp loading will change
			/*put blured or loading screen*/

			//init

			//send request

			//form data
			var fm = new FormData(hdn_fltr);
			fm.append('page',1);
			fm.append('catid',cat_id);
			if(!stck.checked)
			{
				fm.append('stock',0);	
			}
			//form data

			//calling xhr_call
			
			function sucs(xhttp){

				var target = document.getElementById('mpc_cont_12');
				target.innerHTML = "";

				var json = JSON.parse(xhttp.responseText);

				if(json.result)
				{
					json.products.forEach(function(item){
						
						var avgRating = 0;
						
						for(var i = 1 ; i <= 5 ; i++)
						{
							avgRating += parseInt(item.rating[i])*i;
						}

						avgRating = !isFinite(avgRating/parseInt(item.rating.count)) ? 0 : avgRating/parseInt(item.rating.count);
						
						app = '<div class="prdct">\
									<a class="prdct-lnk-a" href="product?'+item.product_id+'">\
										<div class="img">\
											<img src="'+item.images[1] + item.images[0] +'"/>\
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

					if(json.TotalPages > 0)
					{
						var pager = document.getElementById('pagecnt');
						if(pager !== null)
						{
							app = 'Showing Page <select id="pcntr" class="jk-select pagecount"></select> of '+json.TotalPages;
							pager.innerHTML = app;

							for(i = 1 ; i <= json.TotalPages ; i++)
							{
								pcntr.innerHTML += '<option value="'+i+'">'+i+'</option>';
							}

							pcntr.selectedIndex = json.NextPage - 1;

							pcntr.onchange = document.getElementById('q45hgv').onclick ;
						}
					}
				}
				else
				{
					//no item found
				}


			
			}

			function fail(xhttp){
				console.log(xhttp.responseText);
			}

			xhr_call(
				'POST',
				'/apies/category/fillterv1',
				fm,
				sucs,
				fail
			);

			//calling xhr_call

			//send request
		}
		else
		{
			cosole.log(Message);
		}
	}

	//putting onClick on Fillter Button
	if(document.getElementById('q45hgv') !== null)
	{
		document.getElementById('q45hgv').onclick = function(){
			cb(ef);
		};
	}
	//putting onClick on Fillter Button

	function submit_fillter(){

	}

	get(cat_id,1);
	
	
};