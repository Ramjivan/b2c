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

<!-- The Modal -->
<div id="shareModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="modal-close">&times;</span>
      <h2>Modal Header</h2>
    </div>
    <div class="modal-body">
    
		<ul type="none">
			<li class="sl-item"><a href=""><span class="fa fa-whatsapp"></span>Whatsapp</a></li>
			<li class="sl-item"><a href=""><span class="fa fa-instagram"></span>Instagram</a></li>
			<li class="sl-item"><a href=""><span class="fa fa-facebook"></span>Facebook</a></li>
			<li class="sl-item"><a href=""><span class="fa fa-twitter"></span>Twitter</a></li>
			<li class="sl-item"><a href=""><span class="fa fa-sms"></span>SMS</a></li>
			<li class="sl-item"><a href=""><span class="fa fa-link"></span>Copy Link</a></li>
			
		</ul>

    </div>
    <div class="modal-footer">
      <p>Modal Footer</p>
    </div>
  </div>

</div>
    

</body>
</html>