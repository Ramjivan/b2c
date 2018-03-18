$(window).on("load",function(){

	$arr = window.location.toString().split('/');
	
	if($arr.length > 0)
	{
		var url = "/apies/store/"+$arr[$arr.length-1];
	}
	else
	{
		window.location= "index.php";
	}


	$.ajax({
	type: "GET",
	url: url,
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
							"fb":"fb-url",
							"youtube":"youTybeURL",
							"whatsAppBusiness":"number",
							"insta":"insta-link",
							"twitter":"twitter-link",
							"googlePlus":"g+ link"
						}
					}
				};
				var obj = JSON.parse(JSON.stringify(x));
				$('title').text(obj.store.name);
				$('.phoneR').html('<a href="tel:'+obj.store.contact.phone+'">'+obj.store.contact.phone+'</a>');
				$('.emailR').html('<a href="mailto:'+obj.store.contact.email+'">'+obj.store.contact.email+'</a>');
				
					var addString = obj.store.address.adt_addressline1 + ' , ' +
									obj.store.address.adt_addressline2 + '<br>' +
									obj.store.address.adt_city + ' , '+
									obj.store.address.adt_state + '<br>'+
									obj.store.address.adt_pincode; 
				$('.addressR').html(addString);

				console.log(obj.store.address.adt_mob);
				console.log(obj);
						
		
			
		}     
	});
});
