window.onload = function(){
	
	var sub_btn = document.getElementById('btn-sgn');
	var elems = [
		{'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
		{'id':'email','name':'Email Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':8,'max_length':null},
		{'id':'m-num','name':'mobile','regex':/([0-9]*)/,'length':10,'min_length':null,'max_length':null},
		{'id':'password','name':'Password','regex':null,'length':null,'min_length':8,'max_length':null}
	];
	var url = "apies/customer/add";
	var method = "POST";
	var success = function(){document.location="/"};
	var fail = function(){alert("Server Error.")};
	var formid = 'sgn-form';
	var validation_summary = "vs";
	if(sub_btn !== null)
	{		
		sub_btn.addEventListener("click",function(){
			submit_form(formid,elems,validation_summary,url,method,success,fail)
		});
	}
	
	
};





