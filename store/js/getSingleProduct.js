		var storename = window.location.search.substr(1);
				var url = "/apies/store/kingston";
				$.ajax({
				type: "GET",
				url: url,
				data: {q: storename},
				dataType : 'JSON',
					success:function(data){
							
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
                                "rating": {
                                    "1": "1",
                                    "2": "0",
                                    "3": "3",
                                    "4": "0",
                                    "5": "5",
                                    "count": "3"
                                }
                            };
							
							var product = JSON.parse(JSON.stringify(x));

							$('.pdtImgR').attr("alt",);
							$('.productNameR').text(obj.name);
							
							

					}     
				});
		
