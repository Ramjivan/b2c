<?php
	session_start();
	if(isset($_SESSION['user'])){
		Header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Login | B2C
		</title>
		<script>
        function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        document.forms['g-signin']['ID'].value = profile.getId();
        document.forms['g-signin']['First_Name'].value = profile.getGivenName();
        document.forms['g-signin']['Last_Name'].value = profile.getFamilyName();
        document.forms['g-signin']['Full_Name'].value = profile.getName();
        document.forms['g-signin']['Image_URL'].value = profile.getImageUrl();
        document.forms['g-signin']['Email'].value = profile.getEmail();
        
        // The ID token you need to pass to your backend:
        document.forms['g-signin']['ID_Token'].value = googleUser.getAuthResponse().id_token;

        //submitting the form
        $('[name="g-signin"]').submit();
        
      };        
    </script>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="340871764456-pqe4gcc4c2ojfkreg031uelvcs9b19c6.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="js/validate.js"></script>
        <script src="js/lin.js"></script>
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
    <div class="form-card">
		<div class="row">
			<div class="col-6">
				<div class="spform">
					<h3>Login</h3>
					<form id="signin-form" class="jk-form">
						<div id="vs">
							<h3 id="vsh3">Something Went wrong</h3>
						</div>
						<div class="form-group">
                            <input class="jk-textbox wi-left" id="email" onchange="validate({'id':'email','name':'Email Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':8,'max_length':null})" type="text" placeholder="E-mail Address (eg. example@example.org)" name="mail"/>
                            <span class="fa fa-user jk-input-ico-left"></span>
						</div>
						<div class="form-group">
                            <input class="jk-textbox wi-left" id="password" onchange="validate({'id':'password','name':'Email Address','regex':null,'length':null,'min_length':8,'max_length':null})" placeholder="8 character password" type="password" name="paswrd" minlength="8" />
                            <span class="fa fa-lock jk-input-ico-left"></span>
						</div>
                        <input type="hidden" name="redirurl" value="<? echo $_SERVER['HTTP_REFERER']; ?>">
						<div class="form-group">
							<input type="button" id="lgn" class="btn btn-primary-color" value="Login"/>
						</div>
					</form>
                    <div ></div> Not a mamber SignUp Now
				</div>
                <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
			</div>
		</div>
	</div>
    
    
    <fb:login-button 
    scope="public_profile,email"
    onlogin="checkLoginState();">
    </fb:login-button>

	<?php
		//including footer
		include 'footer.php';
	?>
    <form action="apies/verify-g-token.php" method="POST" name="g-signin">
        <input type="hidden" name="ID">
        <input type="hidden" name="Full_Name">
        <input type="hidden" name="First_Name">
        <input type="hidden" name="Last_Name">
        <input type="hidden" name="Image_URL">
        <input type="hidden" name="Email">
        <input type="hidden" name="ID_Token">
        <input type="hidden" name="redirurl" value="" />
    </form>
    <!--Scripts-->
    

    <script>
    $( document ).ready(function() {

    $('#signin-form').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        type: 'post',
        url: 'post.php',
        data: $('form').serialize(),
        success: function () {
        alert('form was submitted');
        }
    });

    });

    });
    </script>
    
    <script>
    //facebook javascript sdk
    window.fbAsyncInit = function() {
        FB.init({
        appId      : '2089771331266779',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.12'
        });
        
        FB.AppEvents.logPageView();   
        
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
</body>
</html>