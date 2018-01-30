function validate(arr)
{
	var raiseError = false;
	var Message = "";
	this.document.getElementById(arr.id).value.toString();
	
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

	if(raiseError == true)
	{
		document.getElementById(arr.id).style.borderColor = 'red';
		//return false;
	}
	else
	{
		document.getElementById(arr.id).style.borderColor = '#BADA55';
	}

	//return true;
}

