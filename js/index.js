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

function xhr_call(method,url,param,success_fun,fail_fun)
{
	var xhttp ;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4)
		{
			switch(xhttp.status)
			{
				case 200:
					success_fun(xhttp);
				break;
				
				case 400:
					fail_fun(xhttp);
				break;
				
				case 501:
					fail_fun(xhttp);
				break;
			}
		}
	};
	
	xhttp.open(method,url,true);
	xhttp.send(param);
}