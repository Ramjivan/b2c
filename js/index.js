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
	var success = function(){document.location="/b2c/"};
	var fail = function(){alert("Server Error.")};
	var formid = 'sgn-form';
	var validation_summary = "vs";
	sub_btn.addEventListener("click",function(){
		submit_form(formid,elems,validation_summary,url,method,success,fail)
	});
};



function submit_form(formid,formvalidation,validation_summary,url,method,success,fail)
{
	alert(formvalidation.toString());
	if(form_validate(document.getElementById(validation_summary),formvalidation))
	{			
		var form = document.getElementById(formid);
		if(form !== null)
		{
			var formData = new FormData(form);
			xhr_call(
				method,
				url,
				formData,
				success,
				fail
			);
		}
		else
		{
			alert('Some Fields are not eligible');
		}
	}
}

