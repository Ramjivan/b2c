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
    <div class="jk-radio">
      <input id="1" type="radio" name="g" checked>
    </div>
    <div class="jk-radio">
      <input id="2" type="radio" name="g">
      <label for="2">Option 2</label>
    </div>
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