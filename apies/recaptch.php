<?php
function reCaptchAuth($gRecaptchResponce){
    
    //your site secret key
    $secret = '6LcB-VIUAAAAAL3hR-ZOlrgmhyzyQ6z9j4wLr_C5';
    //get verify response data
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$gRecaptchResponce);
    $responseData = json_decode($verifyResponse);
    if($responseData->success){
        return true;
    }
    else{
        return false;
    }
}
?>
