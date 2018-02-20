window.onload = function(){
	
	var formvalidation  = [
		{'id':'adt_n','name':'House No. / House Name / Customer Name','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':4,'max_length':16},
		{'id':'adt_m','name':'Mobile','regex':/^[0-9]*$/,'length':10,'min_length':null,'max_length':null},
		{'id':'adt_p','name':'Pincode','regex':/^[0-9]*$/,'length':6,'min_length':null,'max_length':null},
		{'id':'adt_al1','name':'Address Line 1','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null},
		{'id':'adt_al2','name':'Address Line 2','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null},
		{'id':'adt_l','name':'Landmark','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':8,'max_length':64},
		{'id':'adt_s','name':'State','regex':/^([A-Za-z]*)$/,'length':null,'min_length':3,'max_length':128},
		{'id':'adt_c','name':'City','regex':/^([A-Za-z]*)$/,'length':null,'min_length':3,'max_length':128},
		{'id':'adt_t','name':'Type','regex':/^[0-9]*$/,'length':1,'min_length':null,'max_length':null},
	];
	
	var btn = document.getElementById('ad2te');
		if(btn !== null)
		{
			var success = function(xhttp){
				var json = JSON.parse(xhttp.responseText);
				if(json.success !==  undefined && json.success  == '1')
				{
					document.getElementById('adresform').reset();
				}
				else if(JSON.parse(xhttp.responseText).ERROR !== undefined)
				{
					alert("Connection lost while connecting to Server");
				}
			};
			var fail = function(xhttp){
				alert(xhttp.responseText);
			};
			btn.addEventListener('click',function(){
				submit_form('adresform',formvalidation,'vsap','/b2c/apies/address/add','POST',success,fail);
			});
		}
};