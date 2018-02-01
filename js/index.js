window.onload = function(){
	
	var sub_btn = document.getElementById('btn-sgn');
	sub_btn.onclick = function(){
		
		if(form_validate(document.getElementById('btn-sgn'),document.getElementById('vs')))
		{			
			var form = document.getElementById('sgn-form');
			var formData = new FormData(form);
			
			xhr_call(
				'POST',
				'customer/add',
				formData,
				function(xhttp){
					document.location = "/b2c/";
				},
				function(xhttp){
					
				}
			);
		}
	};
};

