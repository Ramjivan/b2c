<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			B2C | HOME
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
	<div class="main-container">
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
		<div class="jk-table-container log-table ">
			<table class="stripped highlight bordered">
				<thead>
					<tr>
						<th>heading1</th>
						<th>heading2</th>
						<th>heading3</th>
						<th>heading1</th>
						<th>heading2</th>
						<th>heading3</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
					</tr>
					<tr>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
					</tr>
					<tr>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
						<td>value1</td>
						<td>value2</td>
						<td>value3</td>
					</tr>
				</tbody>
				
			</table>
		</div>
	</div>


	<div class="form-card"> 
		some tex blal
		<div style="display:block-inline;">
			<div class="form-group col-3">
				<input type="text" class="jk-textbox wi-right" value=""/>
				<span class="fa fa-user jk-input-ico-right"></span>
			</div>
			<div class="form-group col-3">
				<input type="text" class="jk-textbox wi-right" value=""/>
				<span class="fa fa-user jk-input-ico-right"></span>
			</div>
		</div>
		

		<input type="password" class="jk-textbox wi-left wi-right" placeholder="Enter Your Password Here!">
		<span class="fa fa-lock jk-input-ico-left"></span>
		<span class="fa fa-eye jk-input-ico-right"></span>
		
		<input type="tel" class="jk-textbox wi-left">
		<span class="fa fa-phone jk-input-ico-left"></span>
		
		<input type="url" class="jk-textbox wi-right">
		<span class="fa fa-link jk-input-ico-right"></span>

		<input type="color" class="jk-textbox wi-right">
		<span class="fa fa-paint-brush jk-input-ico-right"></span>

		<input type="email" class="jk-textbox wi-right">
		<span class="fa fa-envelope jk-input-ico-right"></span>

		<input type="file" class="jk-textbox wi-right">
		<span class="fa fa-file jk-input-ico-right"></span>

		<input type="number" class="jk-textbox">

		<input type="search" class="jk-textbox wi-left">
		<span class="fa fa-search jk-input-ico-left" ></span>

		<input type="range">
		

		<input type="time" class="jk-textbox">
		<span class="fa fa-clock-o jk-input-ico-right"></span>

		<select name="" class="jk-select">	
			<option value="" >option 1</option>
			<option value="">option 2</option>
			<option value="">option 3</option>
			<option value="">option 4</option>
		</select>
		<span class="fa fa-chevron-down jk-input-ico-right"></span>


		<div class="radio-group">
			<div class="jk-radio">
				<input id="1" type="radio" name="g" checked>
				<label for="1">Option 1</label>
			</div>
			<div class="jk-radio">
				<input id="2" type="radio" name="g">
				<label for="2">Option 2</label>
			</div>
		</div>
		
		<div>
    
    
  </div>
  <div>
    <div class="jk-radio jk-radio-inline">
      <input id="3" type="radio" name="g2" checked>
      <label for="3">Option 3</label>
    </div>
    <div class="jk-radio jk-radio-inline">
      <input id="4" type="radio" name="g2">
      <label for="4">Option 4</label>
    </div>
  </div>
  <div>
  <div class="jk-checkbox">
  <input id="i2" type="checkbox" checked>
  <label for="i2">Item 1</label>
</div>
<div class="jk-checkbox">
  <input id="i1" type="checkbox">
  <label for="i1">Item 2</label>
</div>
	</div>

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>