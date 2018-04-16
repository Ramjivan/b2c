window.onload = function(){
	function e3en5u(){
		var url = window.location.toString();
		
		url = url.split('?');
		
		if(url !== null && url.length > 1)
			var pid = url[1];
			var rew_fun = function(){
				xhr_call(
				'GET',
				'apies/review/product/'+pid,
				null,
				function(xhttp){
					if(xhttp.responseText.length > 0 )
					{
						var json = JSON.parse(xhttp.responseText);
						
						if(json.items.length !== undefined)
						{
							var rating = '<div class="jk-user-rating" itemprop="aggregateRating" \
							itemscope itemtype="http://schema.org/AggregateRating">\
									<span class="heading">User Rating</span>\
									<span class="fa fa-star"></span>\
									<span class="fa fa-star"></span>\
									<span class="fa fa-star"></span>\
									<span class="fa fa-star"></span>\
									<span class="fa fa-star"></span>\
									<p><span itemprop="ratingValue">'+Math.floor(json.average_rating)+'</span> average based on <span itemprop="reviewCount">'+json.rating_count+'</span> reviews.</p>\
									<hr style="border:3px solid #f1f1f1">\
								<div class="row">\
								<div class="side">\
									<div>5 star</div>\
								</div>\
								<div class="middle">\
									<div class="bar-container">\
						<div class="bar-5" style="width:'+( ( ((json.five_star_rating/json.rating_count)*100) == 0 || isNaN((json.five_star_rating/json.rating_count)*100) )  ? '0'  :((json.five_star_rating/json.rating_count)*100))+'%;"></div>\
									</div>\
								</div>\
								<div class="side right">\
									<div>'+json.five_star_rating+'</div>\
								</div>\
								<div class="side">\
									<div>4 star</div>\
								</div>\
								<div class="middle">\
									<div class="bar-container">\
									<div class="bar-4" style="width:'+(( ((json.four_star_rating/json.rating_count)*100) == 0 || isNaN((json.four_star_rating/json.rating_count)*100) ) ? '0' :((json.four_star_rating/json.rating_count)*100))+'%;"></div>\
									</div>\
								</div>\
								<div class="side right">\
									<div>'+json.four_star_rating+'</div>\
								</div>\
								<div class="side">\
									<div>3 star</div>\
								</div>\
								<div class="middle">\
									<div class="bar-container">\
									<div class="bar-3" style="width:'+( ( ((json.three_star_rating/json.rating_count)*100) == 0 || isNaN((json.three_star_rating/json.rating_count)*100) ) ? '0' :((json.three_star_rating/json.rating_count)*100))+'%;"></div>\
									</div>\
								</div>\
								<div class="side right">\
									<div>'+json.three_star_rating+'</div>\
								</div>\
								<div class="side">\
									<div>2 star</div>\
								</div>\
								<div class="middle">\
									<div class="bar-container">\
						<div class="bar-2" style="width:'+(( ((json.two_star_rating/json.rating_count)*100) == 0 || isNaN((json.two_star_rating/json.rating_count)*100) )  ? '0' :((json.two_star_rating/json.rating_count)*100))+'%;"></div>\
									</div>\
								</div>\
								<div class="side right">\
									<div>'+json.two_star_rating+'</div>\
								</div>\
								<div class="side">\
									<div>1 star</div>\
								</div>\
								<div class="middle">\
									<div class="bar-container">\
									<div class="bar-1" style="width:'+(( ((json.one_star_rating/json.rating_count)*100) == 0 || isNaN((json.one_star_rating/json.rating_count)*100) )  ? '0' :((json.one_star_rating/json.rating_count)*100))+'%;"></div>\
									</div>\
								</div>\
								<div class="side right">\
									<div>'+json.one_star_rating+'</div>\
								</div>\
								</div>\
								</div>\
							</div>';
							
							//apeending
							var tar = document.getElementById('rat-con');
							tar.innerHTML += rating;
							//appending
							
							var stars = tar.getElementsByClassName('fa-star');
								for(var i = 0 ; i < Math.floor(json.average_rating); i++)
								{
									stars[i].className += " checked";
								}
								
							
							
							var rew = document.getElementById('rew_con');
							rew.innerHTML += "<h3>Reviews</h3>";
							if(json.items.length > 0)
							{
								for(var i = 0 ; i < json.items.length ; i++)
								{
									var row = json.items[i];
										
									//review section starts
									var upper_first_leg = '<div itemprop="review" itemscope itemtype="http://schema.org/Review" class="jk-review-tile col-3 clearfix">\
										<div  class="jk-review-tile-header clearfix">\
											<div class="col-6">\
												<img style="max-width:30px;min-height:30px;height:30px;width:30px;border-radius:100%;vertical-align:middle;margin-top:-1px;" src="'+(row.ppImg_id !== null ? row.cusotmer_image.img_dir+row.cusotmer_image.img_name : 'default-user.png')+'">&nbsp;<span itemprop="author">'+row.c_fullname+'</span>\
											</div>';
											
											
									var upper_second_leg = '<div class="col-6">';
										
										for(var j = 1;j <= 5 ;j++)
										{
											if(j <= row.rew_rating)
												upper_second_leg += '<span class="fa fa-star checked"></span>';
											else
												upper_second_leg += '<span class="fa fa-star"></span>';
										}
										
									upper_second_leg += '</div>';
											
									var bottom = '</div>\
										<div class="col-6" itemprop="description">'+row.rew_text+'</div>\
									</div>';
									
									rew.innerHTML += (upper_first_leg + upper_second_leg + bottom);
								}
								rew.innerHTML +='<form id="rvfm" method="post" class="detail-card jk-form col-3">\
														<div id="vsap" class="vs">\
															<h3 id="vsh3" class="vs">Something Went wrong</h3>\
														</div>\
													<div class="form-group">\
														<select id="str_rt" name="rew_rating">\
															<option value="1">1 - Star</option>\
															<option value="2">2 - Star</option>\
															<option value="3">3 - Star</option>\
															<option value="4">4 - Star</option>\
															<option value="5">5 - Star</option>\
														</select>\
														<textarea name="rew_text" id="txt_rt" placeholder="Write a Review(255 char allowed)"></textarea>\
													</div>\
													<input type="hidden" name="product_id" value="">\
													<input id="ra_v_btn" type="button" class="btn btn-default btn-success btn-wide" value="Rate & Review"/>\
													</form>\
													<div class="clearfix"></div>';
								qna_fun();
								//review section ends
								imageZoom("myimage", "myresult");
							}
							else
							{
								var rew = document.getElementById('rew_con');
								rew.innerHTML += '<h4><center>no reviews found.</center></h4>\
												<form id="rvfm" method="post" class="detail-card jk-form col-3">\
													<div id="vsap" class="vs">\
														<h3 id="vsh3" class="vs">Something Went wrong</h3>\
														</div>\
														<div class="form-group">\
															<select id="str_rt" name="rew_rating">\
																<option value="1">1 - Star</option>\
																<option value="2">2 - Star</option>\
																<option value="3">3 - Star</option>\
																<option value="4">4 - Star</option>\
																<option value="5">5 - Star</option>\
															</select>\
															<textarea id="txt_rt" max="255" name="rew_text" placeholder="Write a Review(255 char allowed)"></textarea>\
														</div>\
														<input type="hidden" name="product_id" value="">\
												<input id="ra_v_btn" type="button" class="btn btn-default btn-success btn-wide" value="Rate & Review"/>\
												</form>\
												<div class="clearfix"></div>';
								qna_fun();
								imageZoom("myimage", "myresult");
								
							}							
							
							//add event listener on review & rate button[xhr_call]
							
							if(document.getElementById('ra_v_btn') !== null)
							{
								var fv = [
									{'id':'str_rt','name':'Rating','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':1},
									{'id':'txt_rt','name':'Review Description','regex':null,'length':null,'min_length':null,'max_length':255}		
										];
								var ul = "/apies/review/add";
								var sc = function(){};
								var fl = function(){};


								var fn = function(arg){
									if(rvfm!==null && rvfm.product_id !== null)
									{
										rvfm.product_id.value = pid;
										submit_form('rvfm',arg[1],'vsap',arg[2],'POST',arg[3],arg[4]);
									}
								};

								document.getElementById('ra_v_btn').onclick = function(){
									cb(fn,fv,ul,sc,fl);
								};
							}

							
							//add event listener on review & rate button[xhr_call]
							

						}
					}
				},
				function(xhttp){
					
				}
			);
			};
			
		    var qna_fun = function(){
				xhr_call(
				'GET',
				'apies/qna/product/'+pid,
				null,
				function(xhttp){
					if(xhttp.responseText.length > 0 )
					{
						var json = JSON.parse(xhttp.responseText);
						
						if(json.items.length !== undefined && document.getElementById('qa_con') !== null)
						{
							var qa_con = document.getElementById('qa_con');
							qa_con.innerHTML = '<h3 class="askWidgetHeader">Customer questions and answer</h3>\
													<form action=""method="POST">\
														<div class="search-container">\
															<i class="fa fa-search"></i>\
															<input type="text" class="search-input" placeholder="Have a question? Search for answers"\
															onfocus="addShadow()" onblur="rmShadow()" onchange="getQuestions()">\
														</div>\
													</form>\
													<div class="space-1em"></div>\
													<div style="margin-top:1em; text-align:center;">\
													<span style="display:inline-block;">Don&#39;t see what you&#39;re looking for ?</span>\
													<button id="qa_add" class="btn btn-info">Ask Seller</button>\
													</div>';
							
							
							for(var i = 0;i < json.items.length ; i++)
							{
								var row = json.items[i];
								
								var app = '<div class="question-container">\
									<p><span class="qa-left">Question : </span>\
									<span class="qa-right qa-right-q">'+row.qna_question+'</span>\
									</p>\
									<p>\
										<span class="qa-left">Answer:</span>\
										<span class="qa-right qa-right-a">'+( row.qna_answer == null ? "not answered yet." :row.qna_answer)+'</span>\
									</p>\
								</div>';
								
								qa_con.innerHTML += app;
								
							}
							
							document.getElementById('qa_add').onclick = function(){
								document.getElementById('dg1').style.display = 'block';
							};
							
							
						}
					}
				},
				function(xhttp){
					
				}
			);
			};
			xhr_call(
				'GET',
				'apies/product/'+pid,
				null,
				function(xhttp)
				{
					if(xhttp.responseText.length > 0 )
					{
						var json = JSON.parse(xhttp.responseText);
						
						if(json.items.length !== undefined && json.items.length == 1)
						{
							
							var product = json.items[0]['product'];
							var images = json.items[0]['images'];
							var spec = json.items[0]['specification'];
							var hlgt = json.items[0]['highlights'];
							var breadcrumb = json.items[0]['breadcrums'];



							document.title = product.p_name+' | B2C';
							
							var upper = '<ul class="breadcrumb">';


							breadcrumb.reverse().forEach(function(item,i){
								upper += '<li><a href="/mcat='+item['catid']+'">'+item['name']+'</a></li>';
							});

							upper += "<li><span>"+product.p_name+"</span></li>";

							upper += '</ul>';

							upper += '<div>\
							<span class="fa fa-share-alt fa-2x share-button" id="pdt-share-btn"></span> \
									<h3>Images</h3>\
									<ul id="pimglst" class="imglst">\
									</ul>\
								</div>\
								<div class="row" style="position:relative;">\
								<div class="col-3 img-zoom-container">\
									<img itemprop="image" id="myimage" src="'+images[0]['img_dir']+images[0]['img_name']+'">\
									<div id="myresult" class="img-zoom-result"></div>\
									<div class="clearfix"></div>\
								</div>';
								
								
							var mid ='<div class=" col-3 detail-card" id="d5t1ls">\
							<meta itemprop="productID" content="'+pid+'"> \
										<h3 itemprop="name">'+product.p_name+'</h3>\
										<div>\
											<h4 itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span itemprop="priceCurrency" content="INR"></span><span \
											itemprop="price" content="'+product.p_price+'">'+product.p_price+'</span>&nbsp;<span class="fa fa-inr"></span></h4>\
											'+(product.p_stock > 0 ? '<h4 class="green">In Stock</h4><button id="c-add" class="btn btn-default btn-success">ADD TO CART</button><button id="bnow" class="btn btn-default btn-primary-color">BUY NOW</button>' : '<h4 class="red">Out of Stock</h4>')+'\
										</div>\
									</div>\
									<div class="col-3 detail-card">\
										<h3>Description</h3>\
										<div itemprop="description">'+product.p_description+'</div>\
									</div>\
									</div>';
									//set product description as page meta description
									document.querySelector('meta[name="description"]').setAttribute("content", product.p_description);
									
							var highlights = 
							'<div class="detail-card">\
							<h3>\
							Highlights\
							</h3>\
							<ul id="h23ffl65f4t" type="bullet">';
							
							for(var i = 0 ; i < hlgt.length ; i++)
							{
								
								highlights += '<li>'+hlgt[i][0]+'</li>';
								
							}
							
							highlights += '</ul></div><div class="clearfix"></div>';
								
								
							var spc = '<div class=detail-card clearfix">\
										<h3>Product specifications</h3>\
										<div class="jk-table-container log-table">\
											<table id="spcv45trg" class="stripped">\
												<thead>\
													<tr>\
														<th>Specification</th>\
														<th></th>\
													</tr>\
												</thead>\
												<tbody id="sd54f4feh4">';
							
							for(var i = 0 ; i < spec.length ; i++)
							{
								
								spc += '<tr><td>'+spec[i][0]+'</td><td>'+spec[i][1]+'</td></tr>';
								
							}
							
							spc += '</tbody>\
										</table>\
										</div>\
										</div>';

							function copyToClipboard(e) {
								e.preventDefault();
								var copyText = document.getElementById('shareLinkTextbox');
								copyText.select();
								document.execCommand("copy");
								
								document.getElementById('cl45s').innerText('Copied ! ');
							}

							var shareLink = product.p_name + '  ' +window.location.href;
							var shareBox = '<!-- The Modal --> \
							<div id="shareModal" class="modal"> \
							  <div class="modal-content"> \
								<div class="modal-header"> \
								  <span class="modal-close">&times;</span> \
								  <h1>Share this Item</h1> \
								</div> \
								<div class="modal-body">';
								shareBox += '<ul class="sh-list"> \
										<li class="sl-item"><a href="whatsapp://send?text=' + shareLink + '" data-action="share/whatsapp/share" target="_blank"><span class="fa fa-whatsapp"></span>Whatsapp</a></li> \
										<li class="sl-item"><a onclick="return !window.open(this.href, \'Product Share on Facebook\', \'width=500,height=500\')" href="https://www.facebook.com/sharer/sharer.php?u='+shareLink+'" target="_blank"><span class="fa fa-facebook"></span>Facebook</a></li> \
										<li class="sl-item"><a  onclick="return !window.open(this.href, \'Product share on Twitter\', \'width=500,height=500\')" href="https://twitter.com/intent/tweet?text=' + shareLink + '" target="_blank"><span class="fa fa-twitter"></span>Twitter</a></li> \
										<li class="sl-item"><a href="sms:?body=' + shareLink + '"><span class="fa fa-mobile" target="_blank"></span>SMS</a></li>\
										<input type="hidden" value="' + shareLink + '" id="shareLinkTextbox"> \
										<li class="sl-item"><a onclick="copyToClipboard(event)" id="cl45s" href="#"><span class="fa fa-link"></span>Copy Link</a></li>';
										shareBox+='<li class="sl-item"><a href="mailto:?body=' + shareLink + '" target="_blank"><span class="fa fa-envelope"></span>Email</a></li> \
										<li class="sl-item"><a onclick="return !window.open(this.href, \'B2C Google Plus Share\', \'width=400,height=500\') "href="https://plus.google.com/share?url=' + shareLink + '" target="_top"><span class="fa fa-google-plus"></span>Google Plus</a></li> \
									</ul> \
								</div> \
							  </div> \
							</div>';
							var tar = document.getElementsByClassName('main-container')[0];
							tar.style.padding = '';
							tar.innerHTML = upper + mid + highlights + spc + shareBox + '<div id="rat-con"></div>'+ '<div id="rew_con"></div>'+'<div id="qa_con"></div>';
							
							//share modal
							var modal = document.getElementById('shareModal');
							// Get the button that opens the modal
							var btn = document.getElementById("pdt-share-btn");
							//callin popup function which will display modal
							popup(modal,btn);


							if(product.p_stock > 0)
							{
								var cart_btn = document.getElementById('c-add');
								
								function a_q(args)
								{
									xhr_call(
										'GET',
										'/apies/cart/add/'+args[1]+'/qty/1',
										null,
										function(xhttp){
											if(xhttp.responseText.length > 0)
											{
												var json = JSON.parse(xhttp.responseText);
												if(json.success)
												{
													alert('product added to cart.');
												}
												else if(json.ERROR)
												{
													alert(json.MESSAGE);
												}
											}
										},
										function(xhttp){
											alert('couldn\'t esatablish the connection.');
										}
									);
								}
								cart_btn.onclick = function(){
									cb(a_q,pid,this);
								}

								var bnow = document.getElementById('bnow');

								function bnow_q(args)
								{
									xhr_call(
										'GET',
										'/apies/cart/add/'+args[1]+'/qty/1',
										null,
										function(xhttp){
											if(xhttp.responseText.length > 0)
											{
												var json = JSON.parse(xhttp.responseText);
												if(json.success)
												{
													document.location = '/cart';
												}
												else if(json.ERROR)
												{
													alert('Something Went Wrong.');
												}
											}
										},
										function(xhttp){
											alert('couldn\'t esatablish the connection.');
										}
									);
								}

								bnow.onclick = function(){
									cb(bnow_q,pid,this);
								}

							}
							
							var img_lst = document.getElementById('pimglst');
								
								for(var i = 0 ; i < images.length ; i++){
									if(i == 0)
										img_lst.innerHTML += '<li><img class="active" src="'+images[0]['img_dir']+images[0]['img_name']+'"></li>';
									else
										img_lst.innerHTML += '<li><img src="'+images[0]['img_dir']+images[0]['img_name']+'"></li>';
										
								}
								
								rew_fun();
						}
						else
						{
							window.location = "/";
						}
					}
					else
					{
						window.location = "/";
					}
				},
				function(xhttp){
					window.location = "/";
				}
			);
	}
	e3en5u();
};