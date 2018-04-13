<!DOCTYPE html>
<html>
	<head>
		<title>
			new Page | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/mcat.js"></script>

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
	<!--Content Here-->
	
		<div class="main-container clearfix" style="padding:4px;">
			
			<div class="row">
				
				<div class="col-1 clearfix">
					<div class="fil-container col-6">
						<h3>Filter</h3>
						<div class="col-6">
							<h4>Price</h4>
							<div id="p-ranger" class="p-ranger">
								<div id="p-ranger-rail" class="p-ranger-rail">
								</div>
								<div class="ranger" id="rng1"></div>
								<div class="ranger" id="rng2"></div>
							</div>
						</div>
						<div class="col-6">
							<h4></h4>
						</div>
						<div class="col-6">
						
							<h4>Availability</h4>
							<div class="jk-checkbox">
								<input id="stck" type="checkbox">
								<label for="stck">Include Out of Stock</label>
							</div>
						
						</div>
						<div class="col-6">
							<h4></h4>
						</div>
					</div>
				</div>
			
				<div class="col-5">
					
					<div class="col-6">			
						
						<div class="col-6">
							<div class="col-2">
								
								<div class="col-1">
									<p style="margin-top: 8px;margin-bottom: 0px;"><b>Sort By</b></p>
								</div>

								<div class="col-5">
									<select id="srtspnr" name="" class="jk-select">	
										<option value="">Relevance</option>				
										<option value="">Price(low-to-high)</option>
										<option value="">Price(high-to-low)</option>
										<option value="">Newest First</option>
									</select>
									<span class="fa fa-chevron-down jk-input-ico-right"></span>
								</div>

							</div>
						</div>
						
						<div class="col-6" id="cat_hed">
						</div>	
						
						<div class="subctcont col-6" id="cat_sub_">
						</div>
					</div>
					
					<div class="col-6">
						<div class="prdct-grids row" id="mpc_cont_12">
						</div>
					</div>
				
				</div>
			</div>
			
		</div>
	
	<!--Content Here-->

	<?php
		//including footer
		include 'footer.php';
	?>
	<script>
		
		var main = document.getElementById('p-ranger');

		var rail = document.getElementById('p-ranger-rail');

		var range1 = document.getElementById('rng1'),range2 = document.getElementById('rng2'),initX,firstX;

		var max = document.getElementById('rng2').offsetWidth;

		var min = range1.offsetLeft;

		//mouse down starts
		range1.addEventListener('mousedown',function(event){
			
			event.preventDefault();
			initX = range1.offsetLeft;
			firstX = event.pageX;

			rail.addEventListener('mousemove',drag_rng1);
			this.addEventListener('mouseup',function(){rail.removeEventListener('mousemove',drag_rng1,false);},false);
			main.addEventListener('mouseup',function(){rail.removeEventListener('mousemove',rng1,false);},false);
			
		});

		range2.addEventListener('mousedown',function(event){
			
			event.preventDefault();

			initX = range2.offsetLeft;
			firstX = event.pageX;

			rail.addEventListener('mousemove',drag_rng2);
			this.addEventListener('mouseup',function(){rail.removeEventListener('mousemove',drag_rng2,false);},false);
			main.addEventListener('mouseup',function(){rail.removeEventListener('mousemove',drag_rng2,false);},false);

		});


		function drag_rng1(event){
			if( (initX+event.pageX-firstX) > 0 && (initX+event.pageX-firstX) <= max)
			{
				range1.style.left = (initX+event.pageX-firstX) +'px';
			}

			min = (initX+event.pageX-firstX);

			//logic
			
			//logic

		}

		function drag_rng2(event){
			if( (initX+event.pageX-firstX) > min && (initX+event.pageX-firstX) <= max)
			{
				range2.style.left = (initX+event.pageX-firstX) +'px';
			}
			max = (initX+event.pageX-firstX);

			//logic
			
			//logic

		}
		//mouse down ends


		//touch starts
		range1.addEventListener('touchstart',function(event){
			
			event.preventDefault();

			initX = range1.offsetLeft;
			var touch =  event.touches;
			firstX = touch[0].pageX;

			this.addEventListener('touchmove',swipe_rng1);
			
			this.addEventListener(
				'touchend',
				function(){
					rail.removeEventListener('touchmove',swipe_rng1,false);
					
				},
				false
			);

			main.addEventListener('touchend',function(){rail.removeEventListener('touchmove',swipe_rng1,false);},false);
			
		});

		range2.addEventListener('touchstart',function(event){
			
			event.preventDefault();

			initX = range2.offsetLeft;
			var touch =  event.touches;
			firstX = touch[0].pageX;

			this.addEventListener('touchmove',swipe_rng2);
			this.addEventListener('touchend',function(e){e.preventDefault();rail.removeEventListener('touchmove',swipe_rng2,false);},false);
			main.addEventListener('touchend',function(e){e.preventDefault();rail.removeEventListener('touchmove',swipe_rng2,false);},false);
			

		});


		function swipe_rng1(event){
			if( (initX+event.touches[0].pageX-firstX) > 0 && (initX+event.touches[0].pageX-firstX) <= max)
			{
				range1.style.left = (initX+event.touches[0].pageX-firstX)-1 +'px';
			}

			min = (initX+event.touches[0].pageX	-firstX);
			//logic
			
			//logic
		}

		function swipe_rng2(event){
			if( (initX+event.touches[0].pageX-firstX) > min && (initX+event.touches[0].pageX-firstX) <= max)
			{
				range2.style.left = (initX+event.touches[0].pageX-firstX) +2  +'px';
			}
			max = (initX+event.touches[0].pageX-firstX);

			//logic

			//logic

		}

		//touch ends

	</script>

</body>
</html>