<?php
   require 'sqlConfig.php';
   session_start();
if(isset($_POST['REQ_TYPE'])){ 
    if($_POST['REQ_TYPE'] == "9001"){
        if (isset($_POST['username']) and isset($_POST['password'])){
            //Assigning posted values to variables.
            $username = $_POST['username'];
            $password = $_POST['password'];
            //Checking the values are existing in the database or not
            $query = "SELECT * FROM `customers` WHERE username='$username' and password='$password'";
             
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            $count = mysqli_num_rows($result);
            //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
            if ($count == 1){
            $_SESSION['username'] = $username;
            }else{
            //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
            $fmsg = "Invalid Login Credentials.";
            header('Location: login.php?cred=false');
            }
            }
            //3.1.4 if the user is logged in Greets the user with message
            if (isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            header('Location: index.php');
            }
    }
}
else{
    //return error
}


?>