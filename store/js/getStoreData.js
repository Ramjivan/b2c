function initStoreFromServer(){

	/*$arr = window.location.toString().split('/');
	
	if($arr.length > 0)
	{
		var url = "/apies/store/get/"+$arr[$arr.length-1];
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
				*/	
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
							"facebook":"fb-url",
							"youtube":"youTybeURL",
							"whatsApp":"number",
							"instagram":"insta-link",
							"twitter":"twitter-link",
							"google-plus":"g+ link"
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

				//social Links
				sobj = obj.store.socialLinks;
				
				for (var key in sobj) {
					var str = '<li><a href="'+sobj[key]+'"><i class="fa fa-'+key+'" aria-hidden="true"></i></a></li>';
					$('.socialLinksR').append(str);		
				}
				

				
				$('.copyrightR').html('©'+(new Date()).getFullYear()+' All Rights Reserverd. '+obj.store.name+' Store with <i class="fa fa-heart-o" aria-hidden="true"></i> from <a href="#">B2C!</a>');		
		
			/*
		}     
	});*/
}



function decodeURI(){
	var serializedArray = [];
	var suburl = document.location.toString().split('?');
	var params = [];


	if(suburl.length > 1)
	{
		params = suburl[1].split('&');

		if(params.length > 0)
		{
			params.forEach(function(item,i){
				var meta = item.split('=');
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

console.log(decodeURI());
