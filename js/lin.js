window.onload = function(){
	
	var lgn = document.getElementById('lgn');
	lgn.onclick = function(){
		
		if(login(document.getElementById('vs')))
		{			
			var form = document.getElementById('signin-form');
			var formData = new FormData(form);
			
			xhr_call(
				'POST',
				'/b2c/apies/session',
				formData,
				function(xhttp){
					alert(xhttp.responseText);
					//document.location = "/b2c/";
				},
				function(xhttp){
					
				}
			);
		}
	};
};