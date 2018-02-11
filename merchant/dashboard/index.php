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
	
	<div class="form-card"> 
		some tex blal
		<input type="text" class="jk-textbox wi-right" value=""/>
		<span class="fa fa-user jk-input-ico-right"></span>

		<input type="password" class="jk-textbox wi-left">
		<span class="fa fa-lock jk-input-ico-left"></span>
		
		<input type="tel" class="jk-textbox wi-left ">
		<span class="fa fa-phone jk-input-ico-left"></span>
		
		<input type="url" class="jk-textbox">
		<span class="fa fa-link jk-input-ico-right"></span>

		<input type="tel" class="jk-textbox">
		<span class="fa fa-phone jk-input-ico-right"></span>

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