<?php

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Product name | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script src="js/prdct.js" language="JavaScript" type="text/javascript"></script>
		
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
    <div class="main-container" itemscope itemtype="http://schema.org/Product">
    </div>
<div class="dialog" id="dg1">
	<div id="dhead">
	Ask Question
	<span class="fa right" onclick="this.parentElement.parentElement.style.display='none';document.getElementsByClassName('blurdfg')[0].style.display='none';">
		&times;
		</span>
		<div class="clearfix"></div>
	</div>
	<div class="dialog-body">
		<form class="jk-form">
			<textarea name="qna_question" placeholder="Ask Question(255 char allowed)"></textarea>
			<input type="button" id="q_a_btn" value="Ask" class="btn btn-success btn-sm" style="margin:2px;"></input>
		</form>
	</div>
</div>
	<?php
		//including footer
		include 'footer.php';
    ?> 
</body>
</html>