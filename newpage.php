<!DOCTYPE html>
<html>
	<head>
		<title>
			new Page | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		
		<?php
			//include head
			include 'headTags.php';
		?>
		
	</head>
<body>
	<?php
		//including header
		include 'header.php';
	?>

		<div class="f_scr_slider" id="fs_slider1">
			<ul class="f_scr_content" id="fssldr_content">
				<li>
					<a href="#"><img src="apies\products\uploads\14558d5e356ca3862328b35c1592733b.jpg" /></a>
				</li>
				<li>
					<a href="#"><img src="apies\products\uploads\029ebf514bbdaec0dd0a38ff58c1749b.jpg" /></a>
				</li>	
			</ul>
			<div class="p_slider_prev" id="fs_slider_prev"><span class="fa fa-arrow-left"></span></div>
			<div class="p_slider_next" id="fs_slider_next"><span class="fa fa-arrow-right"></span></div>
		</div>
		
		<div id="cart-container" class="main-container">
			<h4>New Arrivals</h4>
			<div class="p_slider" id="u_slider_main1">		
				<div id="u_slider1" class="p_slider_content clearfix">
					
				<div class="p_slider_item">
						<img src="default-user.png" alt="pdt">
 						<div>
 							<b>Acrylic Painting</b>
						</div>
						<div class="details">
							<div class="price">
								<span class="p_prspn"><span class="fa fa-inr"></span>2299</span>
							</div>
							<div class="rating">
								<span class="ra_ti_avgr">3.5&nbsp;<span class="fa fa-star"></span></span>
							</div>
						</div>
 					</div>

				</div>
				<div class="p_slider_prev" id="u_slider_prev"><span class="fa fa-arrow-left"></span></div>
				<div class="p_slider_next" id="u_slider_next"><span class="fa fa-arrow-right"></span></div>
			</div>			
		</div>
	<?php
		//including footer
		include 'footer.php';
	?>

	
	<script>
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
						width+=100;
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
						
						measurediff = main_root.offsetWidth / childWidth;

						measurediff *= childWidth;

						if(transval > width-measurediff)
						{
							transval = width-measurediff;
						}
						
						elem.style.transform =  'translateX(-'+transval+'px)';
					};
				}

			}

			putSlider('u_slider_main1','u_slider1','u_slider_prev','u_slider_next');

			function fsSlider(root_elem_id,elem_id,prev,next)
			{
				var main_root = document.getElementById(root_elem_id);
				var elem = document.getElementById(elem_id);
				var prev = document.getElementById(prev);
				var next = document.getElementById(next);

				var transval = 0;

				if(main_root !== null && elem !== null && prev !== null && next !== null)
				{
					
					var lis = elem.children;

					for(var i = 0 ; i < lis.length ; i++)
					{
						lis[i].style.width = elem.clientWidth+'px'; 
					}

					var fsNext = function(){
						var childs = elem.children;

						for(var i = 0 ; i < lis.length ; i++)
						{
							lis[i].style.width = main_root.clientWidth+'px'; 
						}

						elem.style.width = childs.length * main_root.clientWidth+"px";
						transval += main_root.clientWidth;
						if(transval > elem.clientWidth/2)
						{
							transval = 0;
						}
						elem.style.transform =  'translateX(-'+transval+'px)';
					};

					setInterval(fsNext,2000);
				}
			}

			fsSlider('fs_slider1','fssldr_content','fs_slider_prev','fs_slider_next');
			
		</script>
		
</body>
</html>