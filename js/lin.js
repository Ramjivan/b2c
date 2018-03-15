window.onload = function(){
	
	var arr = document.location.toString().match(/redir=(http:\/\/)([\w+]*)/g);
	
	arr = arr[0].split('=');
	
	document.forms['g-signin']['redirurl'].value = arr[arr.length-1]; 	
	
	
	
	
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
					document.location = arr[arr.length-1];
				},
				function(xhttp){
					
				}
			);
		}
	};
};