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
	var success = function(xhttp){
		if(xhttp.responseText.length > 0)
		{
			var json = JSON.parse(xhttp.responseText);
			if(json.success)
			{

			}
			else if(json.ERROR)
			{
				var node = "";
				var validation_summary = document.getElementById("vs");
				validation_summary.style.display = "block";
				var para = document.createElement("p");
				para.innerHTML = '<span class="fa fa-exclamation-circle"></span>';
		
				if(json["MESSAGE"] !== undefined)
				{	
					node = document.createTextNode(json["MESSAGE"]);
				}
				
				node = document.createTextNode("Server Error");
				
				para.appendChild(node);
				validation_summary.appendChild(para);	
			}
		}
	};
	var fail = function(){alert("Server Error.")};
	var formid = 'sgn-form';
	var validation_summary = "vs";
	if(sub_btn !== null)
	{		
		sub_btn.addEventListener("click",function(){
			submit_form(formid,elems,validation_summary,url,method,success,fail)
		});
	}
	
	function putSlider(root_elem_id,elem_id,prev,next)
	{
		var main_root = document.getElementById(root_elem_id);
		var elem = document.getElementById(elem_id);
		var prev = document.getElementById(prev);
		var next = document.getElementById(next);

		var transval = 0;

		if(main_root !== null && elem !== null && prev !== null && next !== null)
		{
			var childs = elem.children; 
			var width = 0;
			var childWidth = 0;
			for(var i = 0 ; i < childs.length ; i++)
			{
				width += childs[i].clientWidth;
				
			}
			
			if(width > 0)
			{
				width+=200;
				elem.style.width = width+'px';
				childWidth = childs[0].clientWidth;
			}

			prev.onclick = function(){
				transval -= 200;
				if(transval < 0)
				{
					transval = 0;
				}
				elem.style.transform =  'translateX(-'+transval+'px)';
			};

			
			next.onclick = function(){
				transval += 200;
				
				measurediff = main_root.offsetWidth / childWidth; //how many could fit in viewport

				measurediff *= childWidth; //limiting translation by multiplaying childwidth with count 

				if(transval > width-measurediff)
				{
					transval = width-measurediff;
				}
				
				elem.style.transform =  'translateX(-'+transval+'px)';
			};
		}

	}

	

	function hpg_rc() //get recent 5 products
	{
		xhr_call(
			'GET',
			'/apies/hpg/rc',
			null,
			function(xhttp){
				var obj = JSON.parse(xhttp.responseText);

				if(obj.result)
				{
					if(u_slider1 !== null)
					{
						obj.products.forEach(function(item,i){
							var avgRating = 0;
							
							for(var i = 1 ; i <= 5 ; i++)
							{
								avgRating += parseInt(item.rating[i])*i;
							}

							avgRating = !isFinite(avgRating/parseInt(item.rating.count)) ? 0 : avgRating/parseInt(item.rating.count);

							var app = '<div class="p_slider_item">\
							<a class="prdct-lnk-a" href="product?'+item.product_id+'">\
							<img src="'+item.images[1] + item.images[0] +'" alt="pdt">\
							<div>\
								<b>'+item.p_name+'</b>\
							</div>\
							<div class="details">\
								<div class="price">\
									<span class="p_prspn"><span class="fa fa-inr"></span>'+item.p_price+'</span>\
								</div>\
								<div class="rating">\
									<span class="ra_ti_avgr">'+avgRating+'&nbsp;<span class="fa fa-star"></span></span>\
								</div>\
							</div>\
							</a>\
							</div>';

							u_slider1.innerHTML += app;
						});

						putSlider('u_slider_main1','u_slider1','u_slider_prev','u_slider_next');

					}
				}
				else if(obj.ERROR)
				{
					alert('something went worng..');
				}

			},
			function(xhttp){

			}
		);
	}
	hpg_rc();

};





