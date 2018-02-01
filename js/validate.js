function validate(arr)
{
	var raiseError = false;
	var Message = "";
	
	if(arr.length !== null && (document.getElementById(arr.id).value.toString().trim().length > arr.length  || document.getElementById(arr.id).value.toString().trim().length < arr.length) )
	{
		raiseError = true;
		Message = arr.name+" should be "+arr.length+" Long ! Length : "+document.getElementById(arr.id).value.toString().trim().length;
	}
	else if(arr.regex !== null && document.getElementById(arr.id).value.match(arr.regex) == null)
	{
		raiseError = true;
		Message = arr.name+" was not valid";
	}
	else if(arr.min_length !== null && document.getElementById(arr.id).value.toString().trim().length < arr.min_length)
	{
		raiseError = true;
		Message = "Min "+arr.min_length+" char required for "+arr.name;
	}
	else if(arr.min_length !== null && document.getElementById(arr.id).value.toString().trim().length < arr.min_length)
	{
		raiseError = true;
		Message = "Max "+arr.min_length+" char allowed for "+arr.name;
	}
	
	else if(arr.max_length !== null && document.getElementById(arr.id).value.toString().trim().length < arr.max_length)
	{
		raiseError = true;
		Message = arr.name+"'s length should be "+arr.max_length+" long !";
	}
	
	if(raiseError == true)
	{
		document.getElementById(arr.id).style.borderColor = 'red';
		return Message;
	}
	else
	{
		document.getElementById(arr.id).style.borderColor = '#BADA55';
	}

	return "";
}


function form_validate(elem,validation_summary)
{
	
	elems = [
		{'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
		{'id':'email','name':'Email Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':8,'max_length':null},
		{'id':'m-num','name':'mobile','regex':/([0-9]*)/,'length':10,'min_length':null,'max_length':null},
		{'id':'password','name':'Password','regex':null,'length':null,'min_length':8,'max_length':null}
	];
	
	validation_summary.innerHTML = "";
	var header = document.createElement("h3");
	var headernode = document.createTextNode("Something Went wrong");
	header.appendChild(headernode);
	validation_summary.appendChild(header);
	
	var raiseError = false;
	
	for(var i = 0 ; i < elems.length ; i++)
	{
		var ret = validate(elems[i]);
		
		if(ret.length > 0)
		{
			
			var para = document.createElement("p");
			para.innerHTML = '<span class="fa fa-exclamation-circle"></span>';
			var node = document.createTextNode(ret);
			para.appendChild(node);
			
			
			
			validation_summary.appendChild(para);		
			raiseError = true;
		}
		
		if(raiseError)
		{
			validation_summary.style.display = "block";
		}
		else
		{
			validation_summary.style.display = "none";
		}
	}
	
	if(raiseError)
	{
		return false;
	}
	return true;
}



