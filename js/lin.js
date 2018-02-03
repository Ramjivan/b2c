window.onload = function(){
	
	var lgn = document.getElementById('lgn');
	lgn.onclick = function(){
		
		if(login(document.getElementById('vs')))
		{			
			var form = document.getElementById('lgn-btn');
			var formData = new FormData(form);
			
			xhr_call(
				'POST',
				'session',
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