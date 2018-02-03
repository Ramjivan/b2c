<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			qna | dashoboard
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
		<hr>
		<h2 class="askWidgetHeader">Customer questions and answeres</h2>

		<form action=""method="POST">
			<div class="search-container">
				<i class="fa fa-search"></i>
				<input type="text" class="search-input" placeholder="Have a question? Search for answers"
				onfocus="addShadow()" onblur="rmShadow()" onchange="getQuestions()">
			</div>
		</form>
		<div class="space-1em"></div>
		<div style="margin-top:1em; text-align:center;">
		<span style="display:inline-block;">Don't see what you're looking for? </span>
		<button>Ask the Community</button>
		</div>
		<div class="question-container">
			<hr class="hr-v">
			<p><span class="qa-left">Question : </span>
			<span class="qa-right qa-right-q">What the hell is this?</span>
			</p>
			<p>
				<span class="qa-left">Answere:</span>
				<span class="qa-right qa-right-a">This is the Answere Looking Nice isn't it?</span>
			</p>
		</div>
		
		
	</div>

	<?php
		//including footer
		include 'footer.php';
	?>
	<script>
	function getQuestions(){

	}
	function addShadow(){
		$(".search-container").css("border","1px solid orange");
		$(".search-container").addClass("shadow");
	}
	function rmShadow(){
		$(".search-container").css("border","1px solid gray");
		$(".search-container").removeClass("shadow");
	}
	</script>
</body>
</html>