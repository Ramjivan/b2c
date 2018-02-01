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
			new Page | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="340871764456-pqe4gcc4c2ojfkreg031uelvcs9b19c6.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="validate.js"></script>
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
    <div class="signup">
		<div class="row">
			<div class="col-6">
				<div class="spform">
					<h3>Login</h3>
					<form class="signup-form" id="lgn-btn">
						<div id="vs">
							<h3 id="vsh3">Something Went wrong</h3>
						</div>
						<div class="form-group">
							<input id="email" onchange="validate({'id':'email','name':'Email Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':8,'max_length':null})" type="text" placeholder="E-mail Address (eg. example@example.org)" name="mail"/>
						</div>
						<div class="form-group">
							<input id="password" onchange="validate({'id':'password','name':'Email Address','regex':null,'length':null,'min_length':8,'max_length':null})" placeholder="8 character password" type="password" name="paswrd" minlength="8" />
						</div>
						<div class="form-group">
							<input type="button" id="lgn" class="btn btn-primary-color" value="Login"/>
						</div>
					</form>
                    
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
    <!--Scripts-->
    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        
        console.log("ID Token: " + id_token);
        //window.location.href='verify-g-token.php?ID='+profile.getId()+'&EMAIL='+profile.getEmail()+'&token_id='+id_token;
        userData = {"ID":profile.getId(),
                "EMAIL":profile.getEmail(),
                "FIRST_NAME":profile.getGivenName(),
                "LAST_NAME":profile.getFamilyName(),
                "IMAGE_URL":profile.getImageUrl(),
                "token_id":id_token} ;

        var clientID = "340871764456-pqe4gcc4c2ojfkreg031uelvcs9b19c6.apps.googleusercontent.com";
        $.ajax({
            type: "GET",
            url: "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token="+id_token,
            dataType : 'JSON',
            success: function (data) {
                //verifying if request is coming from our google-app
                if(data.aud == clientID){
                    $.ajax({
                        type: "POST",
                        url: "verify-g-token.php",
                        data: userData,
                        
                        success: function (data) {
                            alert(data);
                            window.location.href=data;
                        }
                    });
                    alert("loggen in sucessfully");
                }

            }
        });
      };
    </script>

    <script>
    $(function () {

    $('form').on('submit', function (e) {

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
    /*window.fbAsyncInit = function() {
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
    }(document, 'script', 'facebook-jssdk'));*/
    </script>
</body>
</html>