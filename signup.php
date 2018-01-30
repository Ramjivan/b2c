<html id="fh4jf">
	<head>
		<title>
			B2C | Signup
		</title>
		<script language="JavaScript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="style.js"></script>
		<script language="JavaScript" type="text/javascript" src="validate.js"></script>
		<link rel="stylesheet" href="style.css" type='text/css' media="all"/>
		<link rel="stylesheet" href="responsive.css" type='text/css' media="all"/>
		<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	</head>
<body class="body">
	<div class="row">
		<div class="col-1" id="sidebar">
			<nav class="navbar side-nav">
				<div class="nav-header">
					<div>
					B2C
						<div class="return-btn right">
							&times;
						</div>
					</div>
					
				</div>
				<div class="nav-item"><span class="fa fa-1x fa-home"></span><a href="#">Home</a></div>
				<div class="nav-item"><span class="fa fa-1x fa-user-circle"></span><a href="#">Sign up / Sign in</a></div>
				<div class="nav-item"><span class="fa fa-1x fa-search"></span><a href="#">Explore</a></div>
				<div class="nav-item"><span class="fa fa-1x fa-question-circle-o"></span><a href="#">Help</a></div>
			</nav>
		</div>
	<div class="clearfix"></div>

		<div class="col-6">
			<div class="header">	
				
				<div class="nav-item"><a class="opn-btn" href="#"><div class="dash"></div><div class="dash"></div><div class="dash"></div></a></div>
				<nav class="navbar top-nav">
					<div class="nav-item"><span class="fa fa-1x fa-home"></span><a href="#">Home</a></div>
					<div class="nav-item"><span class="fa fa-1x fa-user-circle"></span><a href="#">Sign up / Sign in</a></div>
					<div class="nav-item"><span class="fa fa-1x fa-search"></span><a href="#">Explore</a></div>
					<div class="nav-item"><span class="fa fa-1x fa-question-circle-o"></span><a href="#">Help</a></div>
					<div class="clearfix"></div>
				</nav>
			</div>
		</div>
	</div>
		
	<div class="signup">
		<div class="row">
			<div class="col-6">
				<div class="spform">
					<h3>Sign up</h3>
					<form class="signup-form">
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
							<input type="button" onclick="form_validate(this,document.getElementById('vs'))" class="btn btn-primary-color" value="Register"/>
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