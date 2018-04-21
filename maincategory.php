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
	
		<div class="main-container" style="padding:4px;">
			
			<div class="row">
			<form id="hdn_fltr" enctype="form-data/multi-part">
				<div class="col-1">
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
								<p>min:</p><input id="p_min" name="min" class="jk-textbox clearfix" value="0" type="number" />
								<p>max:</p><input id="p_max" name="max" class="jk-textbox clearfix" value="10000" type="number" />
							</div>
							<div class="col-6">
							
								<h4>Availability</h4>
								<div class="jk-checkbox">
									<input id="stck" name="stock" value="b2xc" type="checkbox"/>
									<label for="stck">Include Out of Stock</label>
								</div>
							
							</div>
							<div class="col-6">
								<input type="button" class="btn btn-info" id="q45hgv" value="fillter"/>
							</div>
						</div>
				</div>
			
				<div class="col-5 clearfix">
					
					<div class="col-6">			
						
						<div class="col-6">
							<div class="col-2">
								
								<div class="col-1">
									<p style="margin-top: 8px;margin-bottom: 0px;"><b>Sort By</b></p>
								</div>

								<div class="col-5">
									<select id="srtspnr" name="sort" class="jk-select">	
										<option value="401">Relevance</option>				
										<option value="402">Price(low-to-high)</option>
										<option value="403">Price(high-to-low)</option>
										<option value="404">Newest First</option>
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

					<div class="col-6">
						<div id="pagecnt" class="pager_grid">
							
						</div>
					</div>

				</div>
				</form>
			</div>
			<?php
		//including footer
		include 'footer.php';
	?>
		</div>
	
	<!--Content Here-->
	<script>
		
		var main = document.getElementById('p-ranger');

		var rail = document.getElementById('p-ranger-rail');

		var range1 = document.getElementById('rng1'),range2 = document.getElementById('rng2'),initX,firstX;

		var max = range2.offsetleft;
		p_max.value = Math.ceil((range2.offsetLeft / rail.offsetWidth * 100) * 100) ;
		var p_max_val = p_max.value;

		var min = range1.offsetLeft;
		p_min.value = Math.ceil((min / rail.offsetWidth * 100) * 100) ;
		var p_min_val = p_min.value;

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
				range1.style.left = Math.ceil((initX+event.pageX-firstX)) +'px';

				min = (initX+event.pageX-firstX);

			}

			//logic
			p_min.value = Math.ceil((min / rail.offsetWidth * 100) * 100 );
			p_min_val = p_min.value;
			//logic

		}

		function drag_rng2(event){
			if( (initX+event.pageX-firstX) > min && (initX+event.pageX-firstX) <= rail.offsetWidth)
			{
				range2.style.left = Math.ceil((initX+event.pageX-firstX)) +'px';
				max = (initX+event.pageX-firstX);
			}
			//logic
			p_max.value = Math.ceil((max / rail.offsetWidth * 100) * 100);
			p_max_val = p_max.value;
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
				range1.style.left = Math.ceil((initX+event.touches[0].pageX-firstX)) +'px';
				min = Math.ceil((initX+event.touches[0].pageX-firstX));		
			}
			//logic
			p_min.value = Math.ceil((min / rail.offsetWidth * 100)  * 100);
			p_min_val = p_min.value;
			//logic
		}

		function swipe_rng2(event){
			if( (initX+event.touches[0].pageX-firstX) > min && (initX+event.touches[0].pageX-firstX) <= rail.offsetWidth)
			{
				range2.style.left = Math.ceil((initX+event.touches[0].pageX-firstX))+'px';
				max = Math.ceil(initX+event.touches[0].pageX-firstX);
			}

			//logic
			p_max.value = Math.ceil((max / rail.offsetWidth * 100) * 100 );
			p_max_val = p_max.value;
			//logic

		}

		//touch ends

		p_min.addEventListener('change',function(event){
			var val = this.value;
			var offset = Math.ceil((val/100 * rail.offsetWidth)/100);
			
			if(val <= p_max_val && offset > min && offset <= max)
			{
				range1.style.left=offset+"px";
			}
			else
			{
				this.value=p_min_val;
			}

		});
		p_max.addEventListener('change',function(event){
			var val = this.value;
			var offset = Math.ceil((val/100 * rail.offsetWidth)/100);

			if(val >= p_min_val &&  offset > min && offset <= rail.offsetWidth)
			{
				range2.style.left=offset+"px";
			}
			else
			{
				this.value=p_max_val;
			}
		});


	</script>

</body>
</html>