
/**********************************************************************************
***************************this function is should be *****************************
***************************called in every custom-{pagename}.js********************
***************************fetches store essential that will modal page************
***************************and will put the data to Replace holders****************
************************************************************************************/

var store = null;

function userState(){
	$.ajax({
		type: "GET",
		url: '/apies/session/BSZC',
		success:function(responseText){
			if(responseText.length > 0 )
            {
                var json = JSON.parse(responseText);
                
                if(json.result)
                {
                    //user-state-[session]
                    var drop_dwn = document.getElementById('B5thg2w');
                    if(drop_dwn !== null)
                    {
                        if(json.items.SESSION.logged_in == true)
                        {
							drop_dwn.innerHTML += '<li><a href="/dashbaord.php" aria-hidden="true"><span>Dashboard</span></a></li>';
                            drop_dwn.innerHTML += '<li><a href="/logout.php"><span>Logout</span></a></li>';
                        }
                        else
                        {
                            drop_dwn.innerHTML += '<li><a href="/login.php?redirurl='+ window.location.href+'" aria-hidden="true"><span>Login</span></a></li>';
                        }
                    }
                    //user-state-[session]

					//cart
					var c_itm_cnt = document.getElementById('c_itm_cnt');
                    if(json.items.cart !== undefined && !json.items.cart.empty && c_itm_cnt !== undefined)
                    {
                        c_itm_cnt.style.display = "flex";
                        c_itm_cnt.innerHTML = json.items.cart.length;
					}
					else
					{
						c_itm_cnt.innerHTML = "0";
					}
                    //cart

                }
            }
		}	
	});
}


function initStoreFromServer(callback){

	userState();

	var storeName = decodeURI();
	
	if(storeName !== null)
	{
		var url = "/apies/store/get/"+storeName['name'];
	}
	else
	{
		//window.location= "/index.php";
	}


	$.ajax({
		type: "GET",
		url: url,
		dataType : 'JSON',
		success:function(Response)
		{					
			
			obj = JSON.parse(JSON.stringify(Response));

			if(obj.result)
			{
				store = obj.store; 
				//static
				$('.copyrightR').html('©'+(new Date()).getFullYear()+' All Rights Reserverd. '+obj.store.name+' Store with <i class="fa fa-heart-o" aria-hidden="true"></i> from <a href="#">B2C!</a>');

				$('#strNameR').text(obj.store.name);
				
				$('.phoneR').html('<a href="tel:'+obj.store.contact.phone+'">'+obj.store.contact.phone+'</a>');
				
				$('.emailR').html('<a href="mailto:'+obj.store.contact.email+'">'+obj.store.contact.email+'</a>');
				//static

				//login signup url

				$('.lgin').attr("href","/login.php");

				//address
				var addString = obj.store.address.adt_addressline1 + ' , ' +
								obj.store.address.adt_addressline2 + '<br>' +
								obj.store.address.adt_city + ' , '+
								obj.store.address.adt_state + '<br>'+
								obj.store.address.adt_pincode; 
				
				$('.addressR').html(addString);
				//address

				//social Links
				sobj = obj.store.socialLinks;
				var str = '';
				for (var key in sobj) {

					if(sobj[key]){

						str += '<li><a href="'+sobj[key]+'" target="_blank"><i class="fa fa-'+key+'" aria-hidden="true"></i></a></li>';

					}
				}

				$('.socialLinksR').append(str);		
				//social Links

				//Links
				$('.homeLinkR').attr('href', 'http://' + window.location.hostname + '/store/name=' + obj.store.name);
				$('.contactLinkR').attr('href', 'http://' + window.location.hostname + '/store/name=' + obj.store.name + '&section=contact');
				//Links

				//categories
				var catLiAppend = "";
				obj.categories.forEach(function(item,i){
					catLiAppend = '<li><a href="/store/name='+obj.store.name+'&catid='+item.category_id+'&catname='+item.cat_name+'">'+item.cat_name+'</a></li>';
					$('#lg-cat-drpdowns').append(catLiAppend);
					$('#md-str-catholder').append(catLiAppend);
				});
				//categories
				callback(obj.store);
			}
			else
			{
				//window.location = "index.php";
			}
		}     
	});
}

function getNewArrivals(store)
{
	$.ajax({
		type: "GET",
		url:"/apies/store/product/"+store.merchant_id+"/recent",
		dataType : 'JSON',
		success:function(Response)
		{					
			obj = JSON.parse(JSON.stringify(Response));

			if(obj.result)
			{
				obj.products.forEach(function(item){	
					var images = item['images'];
					$('#arrival-prdct-grid').append('<div class="product-item col-md-3 clearfix">\
														<div class="product discount product_filter">\
															<div class="product_image center-block">\
																<img src="'+images.img_dir+images.img_name+'" alt="">\
															</div>\
															<div class="favorite favorite_left"></div>\
															<div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"></div>\
															<div class="product_info">\
																<h6 class="product_name"><a href="name='+store.name+'&pid='+item.product_id+'&pname='+item.p_name+'">'+item.p_name+'</a></h6>\
																<div class="product_price"><i class="fa fa-1x fa-inr"></i>'+item.p_price+'</div>\
															</div>\
														</div>\
														<div class="red_button add_to_cart_button"><a href="#">add to cart</a></div>\
													</div>'
													);	
				});
			}
			else
			{

			}
		}     
	});	
}


function getCategory(store,catid,page){	
	var url = "/apies/store/"+store['merchant_id']+'/'+catid+'/page/'+page;
	$.ajax({
		type: "GET",
		url:url,
		dataType : 'JSON',
		success:function(Response)
		{

			obj = JSON.parse(JSON.stringify(Response));

			if(obj.result)
			{
				var productObj = obj.products;
				
				productObj.forEach(function(item){
					app = '<div class="product-item">\
											<div class="product product_filter">\
												<div class="product_image">\
													<img src="/apies/'+item.images.img_dir+item.images.img_name+'" alt="">\
												</div>\
												<div class="product_info">\
													<h6 class="product_name"><a href="name='+store.name+'&pid='+item.product_id+'&pname='+item.p_name+'">'+item.p_name+'</a></h6>\
													<div class="product_price"><span class="fa fa-1x fa-inr"></span>'+item.p_price+'</div>\
												</div>\
											</div>\
											<div class="red_button add_to_cart_button"><a href="#">add to cart</a></div>\
										</div>';
				
				});

				$('#prdc-grid').append(app);
				

				$('.page_total').html("<span>of</span>"+obj.TotalPages);

				for(var i=1 ; i <= obj.TotalPages ; i++)
				{
					$('.page_selection').append('<li><a href="#">'+i+'</a></li>');
				}

			}
		}
	});

}

function getProduct(pid,merchant_id)
{
	var url = '/apies/store/product/'+pid+'/'+merchant_id;
	$.ajax({
		type: "GET",
		url:url,
		dataType : 'JSON',
		success:function(Response)
		{
			var json = JSON.parse(JSON.stringify(Response));
			if(json.result == 1)
			{

				//breadcrum
				var breadcrum_ctn = document.getElementById('56g53');
				json.product.breadcrum.reverse().forEach(function(item,i){
					if(i == 0)
						breadcrum_ctn.innerHTML += '<li><a href="name='+store.name+'&catid='+item.catid+'&catname='+item.name+'">'+item.name+'</a></li>';
					else
					breadcrum_ctn.innerHTML += '<li><a href="name='+store.name+'&catid='+item.catid+'&catname='+item.name+'"><i class="fa fa-angle-right" aria-hidden="true"></i>'+item.name+'</a></li>';
				});
				breadcrum_ctn.innerHTML += '<li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>'+json.product.p_name+'</a></li>';
				//breadcrum

				//name,descriiption
				$('.productNameR').text(json.product.p_name);
				$('.descriptionR').text(json.product.p_description);
				//name,descriiption

				//price
				$('.product_price').html('<span class="fa fa-1x fa-inr"></span>'+parseFloat(json.product.p_price));
				//price
				
				//rating
				var average_rating = parseInt(json.product.rating_sum) / parseInt(json.product.rating_count);
				for(var i = 1 ; i <= 5 ; i++)
				{
					if(i <= average_rating)
					{
						$('#p_star_rating').append('<li><i class="fa fa-star" aria-hidden="true"></i></li>');
					}
					else
					{
						$('#p_star_rating').append('<li><i class="fa fa-star-o" aria-hidden="true"></i></li>');
					}
				}
				//rating

				//highlights
				json.product.highlights.forEach(function(item){
					$('.highlights_container').append('<li><span class="hlgt">'+item.pht_field_value+'</span></li>');
				});
				//highlights

				//specification
				json.product.specification.forEach(function(item){
					$('.additional_info_col').append('<p>'+item.spc_field_name+':<span>'+item.spc_field_value+'</span></p>');
				});
				//specification


				//reviews
				reviewJsonldStr = '';
				flag = true;
				json.product.review.forEach(function(item){
					
					var x = function(){
						if(item.customer_image !== undefined)
						{
							return "/apies/"+item.customer_image.img_dir+item.customer_image.img_name;
						}
						else
						{
							return "/default-user.png";
						}
					};
					var user_leg = '<div class="user_review_container d-flex flex-column flex-sm-row">\
						<div class="user">\
							<div class="user_pic"><img width="100%" style="width: 100%;height:100%;border-radius: 50%;" src="'+(x())+'" /></div>';
							
						var rating_leg = '<div class="user_rating"><ul class="star_rating">';

						
						for(var i=1 ; i<=5 ; i++)
						{
							if(i <= item.rew_rating)
							{
								rating_leg+='<li><i class="fa fa-star" aria-hidden="true"></i></li>';
							}
							else
							{
								rating_leg+='<li><i class="fa fa-star-o" aria-hidden="true"></i></li>';
							}
						}	
						rating_leg+='</ul></div></div>';

						var review_leg = '<div class="review">\
							<div class="review_date">'+item.rew_datetime+'</div>\
							<div class="user_name">'+item.c_fullname+'</div>\
							<p>'+item.rew_text+'</p>\
						</div>\
					</div>';
					if(flag){
						reviewJsonldStr += '';	
					}else{
						reviewJsonldStr += ',';
					}
					reviewJsonldStr += '{ \
						"@type": "Review", \
						"author": "' + item.c_fullname + '", \
						"datePublished": "'+ item.rew_datetime+'", \
						"description": "' + item.rew_text + '", \
						"reviewRating": { \
						  "@type": "Rating", \
						  "bestRating": "5", \
						  "ratingValue": "'+ item.rew_rating +'", \
						  "worstRating": "1" \
						} \
					  }';
					  flag = false;
					 $('.reviews_col').append(user_leg+rating_leg+review_leg);
				});
				//reviews

				//product-images
				json.product.images.forEach(function(item,i){
					if(i==0)
					{
						$('.images-gridR').append('<li class="active"><img src="'+item.img_dir+item.img_name+'" alt="" data-image="/apies/'+item.img_dir+item.img_name+'"></li>');	
						$('.single_product_image_background').attr("style","background-image:url('"+item.img_dir+item.img_name+"');");
					}
					else
					{
						$('.images-gridR').append('<li><img src="/'+item.img_dir+item.img_name+'" alt="" data-image="'+item.img_dir+item.img_name+'"></li>');	
					}
				});
				//reinit thumbnails
				if($('.single_product_thumbnails ul li').length)
				{
					var thumbs = $('.single_product_thumbnails ul li');
					var singleImage = $('.single_product_image_background');

					thumbs.each(function()
					{
						var item = $(this);
						item.on('click', function()
						{
							thumbs.removeClass('active');
							item.addClass('active');
							var img = item.find('img').data('image');
							singleImage.css('background-image', 'url(' + img + ')');
						});
					});
				}
				jsonldStr = '<script type="application/ld+json"> \
				{ \
				  "@context": "http://schema.org", \
				  "@type": "Product", \
				  "aggregateRating": { \
					"@type": "AggregateRating", \
					"ratingValue": "' + average_rating + '", \
					"reviewCount": "' + json.product.rating_count + '" \
				  }, \
				  "description": "' + json.product.p_description + '", \
				  "name": "' + json.product.p_name + '", \
				  "image": "kenmore-microwave-17in.jpg", \
				  "offers": { \
					"@type": "Offer", \
					"availability": "http://schema.org/InStock", \
					"price": "' + json.product.p_price + '", \
					"priceCurrency": "INR" \
				  }, \
				  "review": [ \
					' + reviewJsonldStr + '  \
				  ] \
				} \
				</script>';
				$('body').append(jsonldStr);

				//renint thumbnails
				//product-images
			}
			else
			{
				document.location = "/index.php";
			}
		}
	});
}

function decodeURI()
{
	var serializedArray = [];
	var suburl = document.location.toString().split('/');
	var params = [];


	if(suburl.length > 1)
	{
		params = suburl[suburl.length-1].split('&');


		if(params.length > 0)
		{
			params.forEach(function(item,i){
				var meta = item.split('=');
				meta[0] = meta[0].replace('?','');
				meta[1] = meta[1].replace('?','');
				serializedArray[meta[0]] = meta[1];	
			});

			if(!serializedArray)
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	else
	{
		return null;
	}

	return serializedArray;
}

