<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			B2C | HOME
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/indx.js"></script>
		
		<?php
			//include head
			include 'headTags.php';
		?>
	</head>
<body class="body">
	<?php
		//including header
		include 'header.php';
	?>
	
		<div class="main-grid"> 
			
			<div class="main-container">
				<div class="col-6">
					<div class="center">
						<ul class="index-main-cat-ul">
							<li><a href="#">Electronics</a></li>
							<li><a href="#">Electronics</a></li>
							<li><a href="#">Electronics</a></li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="main-container">
				<div class="col-6">
					<div class="main-sl">
					<div class="slideshow-container center">
						
						<div class="mySlides">
							<div class="numbertext"> </div>
							<div class="text"></div>
							<img src="apies\products\uploads\14558d5e356ca3862328b35c1592733b.jpg" style="width:100%">
                        </div>
						<div class="mySlides">
							<div class="numbertext"></div>
							<div class="text"><b></b></div>
							<img src="apies\products\uploads\029ebf514bbdaec0dd0a38ff58c1749b.jpg" style="width:100%">
                        </div>
					
						<a class="prev" onclick="plusSlides(-1,'mySlides')"><div>&#10094;</div></a>
						<a class="next" onclick="plusSlides(1,'mySlides')"><div>&#10095;</div></a>
					</div>
					</div>
				</div>
			</div>
		
		
		
		
			<div class="prdct-grids row">
				<div class="prdct">
				<a class="prdct-lnk-a" href="http://localhost/b2c/product?25c84c7af1">
					<div class="img">
						<img src="apies/products/uploads/22be20b1bf2190a3ecccc3dea69d7ae3.jpg"/>
					</div>
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
				</a>
				</div>
			</div>
		</div>

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>