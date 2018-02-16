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

function cb(fn)
{
	fn(arguments);
}

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
				case 404:
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

function imageZoom(imgID, resultID) {
	var img, lens, result, cx, cy;
	img = document.getElementById(imgID);
	result = document.getElementById(resultID);
	/*create lens:*/
	lens = document.createElement("DIV");
	lens.setAttribute("class", "img-zoom-lens");
	/*insert lens:*/
	img.parentElement.insertBefore(lens, img);
	/*calculate the ratio between result DIV and lens:*/
	cx = result.offsetWidth / lens.offsetWidth;
	cy = result.offsetHeight / lens.offsetHeight;
	/*set background properties for the result DIV*/
	result.style.backgroundImage = "url('" + img.src + "')";
	result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
	/*execute a function when someone moves the cursor over the image, or the lens:*/
	lens.addEventListener("mouseenter", function(){result.style.display='block'});
	lens.addEventListener("mouseleave", function(){result.style.display='none'});
	lens.addEventListener("mousemove", moveLens);
	img.addEventListener("mousemove", moveLens);
	/*and also for touch screens:*/
	lens.addEventListener("touchmove", moveLens);
	img.addEventListener("touchmove", moveLens);
	result.style.display = "none";
	function moveLens(e) {
	  var pos, x, y;
	  /*prevent any other actions that may occur when moving over the image*/
	  e.preventDefault();
	  /*get the cursor's x and y positions:*/
	  pos = getCursorPos(e);
	  /*calculate the position of the lens:*/
	  x = pos.x - (lens.offsetWidth / 2);
	  y = pos.y - (lens.offsetHeight / 2);
	  /*prevent the lens from being positioned outside the image:*/
	  if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
	  if (x < 0) {x = 0;}
	  if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
	  if (y < 0) {y = 0;}
	  /*set the position of the lens:*/
	  lens.style.left = x + "px";
	  lens.style.top = y + "px";
	  /*display what the lens "sees":*/
	  result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
	}
	function getCursorPos(e) {
	  var a, x = 0, y = 0;
	  e = e || window.event;
	  /*get the x and y positions of the image:*/
	  a = img.getBoundingClientRect();
	  /*calculate the cursor's x and y coordinates, relative to the image:*/
	  x = e.pageX - a.left;
	  y = e.pageY - a.top;
	  /*consider any page scrolling:*/
	  x = x - window.pageXOffset;
	  y = y - window.pageYOffset;
	  return {x : x, y : y};
	}
} 
  
  

xhr_call(
	'GET',
	'/b2c/apies/index/category',
	null,
	function(xhttp){
	var tar = document.getElementById('32t3g05');
	var tar2 = document.getElementById('32tfg05');
	if(tar !== null && tar2 !== null)	
		if(xhttp.responseText.length > 0)
		{
			var json = JSON.parse(xhttp.responseText);
			if(json.result > 0)
			{
				for(var i = 0 ; i < json.items.length ; i++)
				{
					tar.innerHTML += '<a href="mcat='+json.items[i].category_id+'">'+json.items[i].cat_name+'</a>';
					tar2.innerHTML += '<a href="mcat='+json.items[i].category_id+'">'+json.items[i].cat_name+'</a>';
				}
			}
		}
	},
	function(xhttp){
		
	}
);
