		var storename = window.location.search.substr(1);
				var url = "/apies/store/kingston";
				$.ajax({
				type: "GET",
				url: url,
				data: {q: storename},
				dataType : 'JSON',
					success:function(data){
							
							var  x= {
								"result":1,
								"store":{
									"id":123,
									"name":"storeName",
									"logo":"imagePath",
									"merchant_id":1234567,
									"contact":{
										"phone":"8003209000",
										"email":"store@b2c.com",
										"gpsCord":{
											"lonitude":"value",
											"latitude":"value"
										}
									},
									"address":{
										"adt_fullname": "HOME",
										"adt_mob": "755256668",
										"adt_pincode": "342001",
										"adt_addressline1": "test line 1",
										"adt_addressline2": "test line 2",
										"adt_landmark": "testing",
										"adt_city": "Jodhpur",
										"adt_state": "Rajsathan"
									},
									"socialLinks":{
										"facebook":"fb-link",
										"twitter":"twitter-link",
										"instagram":"insta-link",
										"youtube":"youTybeURL",
										"whatsapp":"number",
										"google-plus":"g+ link"
									}
								},
								"cat": [	
									{	
										"0": "6",	
										"1": "Mobiles", 
										"2": "Mobiles",
										"3": "Mobiles",
									   "4": "b72c423c5b5",
										"category_id": "6",
										"cat_name": "Mobiles",
										"cat_description": "Mobiles",
										"cat_meta_keyword": "Mobiles",
										"Merchant_id": "b72c423c5b5"
									},
									{
										"0": "5",
										"1": "Electronics",
										"2": "All Electronic Items",
										"3": "Test Test",
										"4": "b72c423c5b5",
										"category_id": "5",
										"cat_name": "Electronics",
										"cat_description": "All Electronic Items",
										"cat_meta_keyword": "Test Test",
										"Merchant_id": "b72c423c5b5"
									}
								]
							};
							var obj = JSON.parse(JSON.stringify(x));

							$('title').text(obj.store.name);
							$('.storeNameR').text(obj.store.name);
							$('.phoneR').html('<a href="tel:'+obj.store.contact.phone+'">'+obj.store.contact.phone+'</a>');
							$('.emailR').html('<a href="mailto:'+obj.store.contact.email+'">'+obj.store.contact.email+'</a>');
							
							var addString = obj.store.address.adt_addressline1 + ' , ' +
											obj.store.address.adt_addressline2 + '<br>' +
											obj.store.address.adt_city + ' , '+
											obj.store.address.adt_state + '<br>'+
											obj.store.address.adt_pincode; 

							$('.addressR').html(addString);

							copyrightStr = '© '+(new Date()).getFullYear()+' '+obj.store.name+' Store. All rights reserved | Designed and Powered by <a href="rooturl/">B2C Stores!</a>';
							$('.cpoyrightR').html(copyrightStr);
							for (var key in obj.store.socialLinks) {
								if (obj.store.socialLinks.hasOwnProperty(key)) {
									var val = obj.store.socialLinks[key];
									if(val){
										str = '<li><a href="'+val+'" class="'+key+'"><i class="fa fa-'+key+'" aria-hidden="true"></i></a></li>';
										$('.socialLinksR').append(str);
										
									}
								}
							}
							
							
							//categories
							
							for (i = 0; i < obj.cat.length; i++) {
								
								$('.categoryR').append('<li><a href="pbc.html?n='+obj.cat[i].cat_name+'">'+obj.cat[i].cat_name+'</a></li>');
							
							}
							

					}     
				});
		
