window.onload = function(){
	function decodeURI()
	{
		var serializedArray = [];
		var params = [];
	
			params = document.location.toString().split('?');
	
	
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

	
		return serializedArray;
	}	
	
		var url = decodeURI();
	
	
	lgn.onclick = function(){
		
		if(login(document.getElementById('vs')))
		{			
			var form = document.getElementById('signin-form');
			var formData = new FormData(form);
			
			xhr_call(
				'POST',
				'apies/session',
				formData,
				function(xhttp){
					if(url !== undefined)
					{
						document.location = url['redirurl'];
					}
					else
					{
						document.location = "/";
					}				
				},
				function(xhttp){
					
				}
			);
		}
	};
};