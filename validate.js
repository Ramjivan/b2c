function validate(arr)
{
	var raiseError = false;
	var Message = "";
	var elem = document.getElementById(arr.id);

	if(arr.length !== null && parseInt(arr.length) !== parseInt(elem.value.toString().length))
	{
		this.raiseError = true;
		this.Message = arr.name+" should be "+arr.length+" Long !"+elem.value.length;
	}
	else if(elem.value.match(arr.regex) == null)
	{
		this.raiseError = true;
		this.Message = arr.name+" was not valid";
	}

	if(this.raiseError == true)
	{
		alert(this.Message);
		return false;
	}

	return true;
}

