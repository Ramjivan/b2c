<html id="fh4jf">
	<head>
		<title>
			B2C | Signup
		</title>
		<script language="JavaScript" type="text/javascript" src="js/index.js"></script>
		<script language="JavaScript" type="text/javascript" src="validate.js"></script>
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
	
	<div class="signup">
		<div class="row">
			<div class="col-6">
				<div class="spform">
					<h3>Sign up</h3>
					<form class="signup-form" id="sgn-form">
						<div id="vs">
							<h3 id="vsh3">Something Went wrong</h3>
						</div>
						<div class="form-group">
							<input id="name" onchange="validate({'id':'name','name':'Email Address','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null})" type="text" placeholder="Full Name" name="c_fullname"/>
						</div>
						<div class="form-group">
							<input id="email" onchange="validate({'id':'email','name':'Email Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':8,'max_length':null})" type="text" placeholder="E-mail Address (eg. example@example.org)" name="c_email"/>
						</div>
						<div class="form-group">
							<input id="m-num" type="text" onchange="validate({'id':'m-num','name':'mobile','regex':/^[0-9]*$/,'length':10,'min_length':null,'max_length':null})" placeholder="10 Digit Mobile Number" name="c_mobile"/>
						</div>
						<div class="form-group">
							<input id="password" onchange="validate({'id':'password','name':'Email Address','regex':null,'length':null,'min_length':8,'max_length':null})" placeholder="8 character password" type="password" name="pwd" minlength="8" />
						</div>
						<div class="form-group">
							Merchant <input type="radio" name="ctus" value="1"> Customer <input type="radio" name="ctus" value="2">
						</div>
						<div class="form-group">
							<input type="button" id="btn-sgn" class="btn btn-primary-color" value="Register"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="blurdfg">
	</div>
</body>
</html>