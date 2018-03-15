window.onload = function(){
	
	try {
	
		var arr = document.location.toString().match(/redir=(http:\/\/)([\w+]*)/g);
	
		arr = arr[0].split('=');
		
		document.forms['g-signin']['redirurl'].value = arr[arr.length-1]; 	
			
	} catch (error) {
		arr = undefined;
	}
	
	
	
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
					if(arr !== undefined)
					{
						document.location = arr[arr.length-1];
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