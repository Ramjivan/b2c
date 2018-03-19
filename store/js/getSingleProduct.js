		/*var storeName = window.location.search.substr(1);
				var url = "/apies/store/kingston";
				$.ajax({
				type: "GET",
				url: url,
                data: {q: storeName},
				dataType : 'JSON',
					success:function(data){
							*/
							var  x= {
                                "product_id": "25c84c7af1",
                                "p_name": "Product Edited",
                                "p_description": " ProductProductProductProductProductProductProductProduct  ProductProductProductProductProductProductProductProduct  ProductProductProductProductProductProductProductProduct",
                                "p_price": "2400",
                                "p_category": "6",
                                "p_stock": "200",
                                "img_list_id": "86a7dac962",
                                "Merchant_id": "b72c423c5b5",
                                "images": {
                                    "img_name": "22be20b1bf2190a3ecccc3dea69d7ae3.jpg",
                                    "img_dir": "products/uploads/"
                                    },
                                "rat": {
                                    "1": "1",
                                    "2": "0",
                                    "3": "3",
                                    "4": "0",
                                    "5": "5",
                                    "count": "3"
                                }
                                };
                                
                            
							
							var product = JSON.parse(JSON.stringify(x));

                            
                            $('.productNameR').text(product.p_name);
                            $('.pdtImgR').attr("alt",product.p_name);
                            $('.productDescriptionR').text(product.p_description);
                            $('.priceR').html('<span class="fa fa-rupee"></span> '+product.p_price +' <span class="pBDiscount"></span>');
                            
                            var avgRat = (product.rat[1] + product.rat[2] + product.rat[3] + product.rat[4] + product.rat[5])/5;
							/*

					}     
				});
		*/
