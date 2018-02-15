<!DOCTYPE html>
<html>
	<head>
		<title>
			Product name | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		
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
	<!--Content Here-->
    <div class="main-container">
        <ul class="breadcrumb">
            <li><a href="#">Electronics</a></li>
            <li><a href="#">Mobile</a></li>
            <li><a href="#">Mi</a></li>
            <li>Mi A1</li>
        </ul>
        
        <div class="img-zoom-container">
            <img id="myimage" src="img/IMG_2618_LI (2).jpg" hight="300" width="300" >
            <div id="myresult" class="img-zoom-result"></div>
        </div>
        
        <div>
            <h3>
                Highlights
            </h3>
            <ul type="bullet">
                <li>highligh no. 1</li>
                <li>highligh no. 2</li>
                <li>highligh no. 3</li>
                <li>highligh no. 4</li>
                <li>highligh no. 5</li>
            </ul>
        </div>
        
        <hr>
        <h3>Product specifications</h3>

        <div class="jk-table-container log-table ">
			<table class="stripped">
				<thead>
					<tr>
						<th>Specification</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
                    <tr>
                        <td>spec1</td>
                        <td>val1</td>
                    </tr>
                    <tr>
                        <td>spec2</td>  
                        <td>val2</td>
                    </tr>
                    <tr>
                        <td>spec1</td>
                        <td>val1</td>
                    </tr>
                    <tr>
                        <td>spec2</td>  
                        <td>val2</td>
                    </tr>
                    <tr>
                        <td>spec1</td>
                        <td>val1</td>
                    </tr>
                    <tr>
                        <td>spec2</td>  
                        <td>val2</td>
                    </tr>
				</tbody>
				
			</table>
		</div>
    </div>
    <div class="jk-user-rating">
			<span class="heading">User Rating</span>
			<span class="fa fa-star checked"></span>
			<span class="fa fa-star checked"></span>
			<span class="fa fa-star checked"></span>
			<span class="fa fa-star checked"></span>
			<span class="fa fa-star"></span>
			<p>4.1 average based on 254 reviews.</p>
			<hr style="border:3px solid #f1f1f1">

		<div class="row">
		<div class="side">
			<div>5 star</div>
		</div>
		<div class="middle">
			<div class="bar-container">
			<div class="bar-5"></div>
			</div>
		</div>
		<div class="side right">
			<div>150</div>
		</div>
		<div class="side">
			<div>4 star</div>
		</div>
		<div class="middle">
			<div class="bar-container">
			<div class="bar-4"></div>
			</div>
		</div>
		<div class="side right">
			<div>63</div>
		</div>
		<div class="side">
			<div>3 star</div>
		</div>
		<div class="middle">
			<div class="bar-container">
			<div class="bar-3"></div>
			</div>
		</div>
		<div class="side right">
			<div>15</div>
		</div>
		<div class="side">
			<div>2 star</div>
		</div>
		<div class="middle">
			<div class="bar-container">
			<div class="bar-2"></div>
			</div>
		</div>
		<div class="side right">
			<div>6</div>
		</div>
		<div class="side">
			<div>1 star</div>
		</div>
		<div class="middle">
			<div class="bar-container">
			<div class="bar-1"></div>
			</div>
		</div>
		<div class="side right">
			<div>20</div>
		</div>
		</div>

		</div>
        
    </div>

	<?php
		//including footer
		include 'footer.php';
    ?>
    
    <script>
        imageZoom("myimage", "myresult");
    </script> 
</body>
</html>