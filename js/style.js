$(document).ready(function(){
	$('.opn-btn').on('click',function(){
		$('#sidebar').fadeIn();
		$('.blurdfg').toggleClass('active');
		disableScroll();
	});
	$('.return-btn').on('click',function(){
		$('#sidebar').fadeOut();
		$('.blurdfg').toggleClass('active');
		enableScroll();
	});
});


// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}

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
	if(method == "POST")
	{		
		xhttp.send(param);
	}
	else
	{		
		xhttp.send(param);
	}
}

function submit_form(formid,formvalidation,validation_summary,url,method,success,fail)
{
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
			alert('Fatal Error');
		}
	}
}