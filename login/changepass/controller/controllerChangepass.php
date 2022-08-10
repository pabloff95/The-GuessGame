<?php
// Print error message if data introduced does not exists in DB
function printError($user, $email){
    if (!checkData($user, $email)) {
        echo "<p class='dbError' id='dbError' >Wrong user or email</p>";
    }
}

// SEND VERIFICATION EMAIL

// Generate random code to be sended for email verification
function getCode() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Send email to user (password change)
function sendPasswordMail ($mail, $name, $code){
    // Parameters
    $to = $mail;
    $subject = "GuessGame change password";
    $message = "Hello ". $name .",\r\n \r\n".        
    "You have requested to change your password of your account at GuessGame.\r\n".
    "\r\n".
    "Here you can find the verification code to change it:\r\n".
    "\r\n".
    $code . "\r\n".
    "\r\n".
    "If you have not requested to change your password, please ignore this email.\r\n \r\n".
    "Thank you!";
    $header = 'From: XXX@XXX.XXX'; // Fill with valid email
    // Send email
    mail($to, $subject, $message, $header);
}

?>