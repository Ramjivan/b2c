		var storename = window.location.search.substr(1);
				var url = "/apies/store/b72c423c5b5/6/page/1";
				$.ajax({
				type: "GET",
				url: url,
				
				dataType : 'JSON',
					success:function(data){
                            
                        var x = {
                            "cat_name": "Name of the Category",
                            "products": [
                                {
                                    "product_id": "25c84c7af1",
                                    "p_name": "Product Edited",
                                    "p_price": "2400",
                                    "p_stock": "200",
                                    "images": {
                                        "0": "22be20b1bf2190a3ecccc3dea69d7ae3.jpg",
                                        "1": "products/uploads/",
                                        "img_name": "22be20b1bf2190a3ecccc3dea69d7ae3.jpg",
                                        "img_dir": "products/uploads/"
                                    },
                                    "ratingAvg": 4.5,
                                    "ratingCount": "3"
                                }
                            ],
                            "result": 1,
                            "TotalPages": 1,
                            "NextPage": 1
                        };
                        

                        	var obj = JSON.parse(JSON.stringify(x));
                            console.log(obj.cat_name);
                            //putting category name
                            $('.categoryNameR').text(obj.cat_name);
							for(var i = 0; i < obj.products.length; i++){
                                var pdt = obj.products[i];
                                str = productParse(pdt);
                                $('.productR').append(str);
                            }
                            function productParse(pdt){
                                var str = '<div class="col-md-3 w3ls_w3l_banner_left w3ls_w3l_banner_left_asdfdfd">\
                                <div class="hover14 column">\
                                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">\
                                    <div class="agile_top_brand_left_grid_pos">\
                                        <img src="images/offer.png" alt=" " class="img-responsive" />\
                                    </div>\
                                    <div class="agile_top_brand_left_grid1">\
                                        <figure>\
                                            <div class="snipcart-item block">\
                                                <div class="snipcart-thumb">\
                                                    <a href="single.html"><img src="images/37.png" alt=" " class="img-responsive" /></a>\
                                                    <p>'+pdt.p_name+'</p>\
                                                    <h4>'+pdt.p_price+'<span class="priceBeforDiscount"></span></h4>\
                                                    \
                                                </div>\
                                                <div class="snipcart-details">\
                                                    <form action="#" method="post">\
                                                        <fieldset>\
                                                            <input type="hidden" name="id" value="'+pdt.product_id+'" />\
                                                            <input type="submit" name="submit" value="Add to cart" class="button" />\
                                                        </fieldset>\
                                                    </form>\
                                                </div>\
                                            </div>\
                                        </figure>\
                                    </div>\
                                </div>\
                                </div>\
                            </div>';
                            return str;
                            }
					}     
				});
		