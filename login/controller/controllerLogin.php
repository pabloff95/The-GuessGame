<?php

    /* ------------------------------------------------------------------------------------------------
    FUNCTIONS TO CONTROL THE INFORMATION DISPLAYED ON login.php ACCORIDNG TO USER ACTIONS AND THE DB
    ---------------------------------------------------------------------------------------------------*/
    // To be printed  under normal scenario
    function loginScreen(){
        echo    "<h1>Login</h1> 
                 <input type='text' name='user' required maxlength='20' placeholder =' User Name' value='" . autoFill("user") ."'></br>                 
                 <div class='passwordElement'>
                    <input type='password' name='pass' id='logPass' class='passwordField' required maxlength='30' placeholder =' Password' value='" . autoFill("pass") ."'>
                    <img src='../resources/pictures/other/eyeClose.svg' id='seeLogPass' class='passImg' ></br>                 
                </div>
                 <label id='characterError' class='error'>Character not allowed (<, >)</label>
                 " .logFail(). // propts message when user and password do not match
                 "<button type='button' class='menuButton'>LOGIN</button> </br>                 
                 <input type='hidden' name='login'>";
                 printSoundHiddenInput();
        echo "</form>
              <form action='changepass/changepass.php' method='POST' id='changePassForm' >
              <div >
                <p>Forgotten password? </br>
                <a href='javascript:document.getElementById(\"changePassForm\").submit();' >Reset password</a>
                </p>
                </div>";
                printSoundHiddenInput();
        echo "</form>
              <div id='border'></div>              
              <form method='POST' action='login.php' id='createAccount'>
                    <h1>Create a new user</h1>
                    <button type='button' class='menuButton'>REGISTER</button>
                    <input type='hidden' name='newUser'>";
                    printSoundHiddenInput();
                    
    }
    // To be printed when create user is clicked
    function newUser(){
        echo "<h1>New user</h1> 
              <label>User Name:</label> 
              <input type='text' name='user' required maxlength='20' value='" . autoFill("user") ."'></br>
              ". duplicatedUser() . // propts message when user already exists in the DB
              "<label>Password:</label> 
              <div class='passwordElement'>
                <input type='password' name='pass' class='passwordField' id='pass' required maxlength='30' value='" . autoFill("pass") ."' >
                <img src='../resources/pictures/other/eyeClose.svg' id='seePass' class='passImg' ></br>                               
              </div>
              <label>Repeat password:</label> 
              <div class='passwordElement'>
                <input type='password' name='pass2' class='passwordField' id='pass2' required maxlength='30' value='" . autoFill("pass2") ."' >
                <img src='../resources/pictures/other/eyeClose.svg' id='seePass2' class='passImg' ></br>                 
              </div>
              <label id='passVerif' class='error'>The passwords do not match</br></label>
              <label>Email:</label>
              <input type='email' name='email' id='emailInput' required maxlength='100' value='" . autoFill("email") ."' ></br>
              ". duplicatedEmail() . // propts message when email already exists in the DB
              "
              <label> Game Name:</label>
              <input type='text' name='gameName' required maxlength='15' value='" . autoFill("gameName") ."' > </br>
              ". duplicatedName() . // propts message when email already exists in the DB
              "
              <div id='consent'>
                <p><input type='checkbox' id='consentCheckbox' >
                By creating an user you agree with the storage and handling of your data in this website.</p>
                <p class='errorMessage' id='consentError'>Consent acceptance required</p>
              </div>              
              <label id='characterError' class='error'>Character not allowed (<, >)</label>
              <label id='emailError' class='error'>Wrong email</label>
              <button type='button' id='creatingButton' class='menuButton'>CREATE</button>                 
              <input type='hidden' name='creating'>";
              printSoundHiddenInput();
        echo "</form>
          <form method='POST' action='login.php'>
              <button type='button' class='menuButton' >BACK</button>
              <input type='hidden' name='toLogin'>";
              printSoundHiddenInput();
    }

    // To be printed when clicked on button "create" (after sending mail with details for user account verification). Note: password is encrypted
    function verifCount(){
        echo "<h1>Verification</h1>
              <div id='verificationText'><label>A code has been sent to your email.</label> </br></br>
              <label>Please, introduce the code received to verify your data:</label> </br></div>
              <input type='text' name='userCode' id='code' maxlength='6' />
              <label id='characterError' class='error'>Character not allowed (<, >)</label>";                
        if (isset($_GET['code']) && $_GET['code'] == "error"){ // When there was a mistake in the code
            echo "<label id='codematch' class='error'></br>Wrong code</label></br>";
        }
        echo "<button type='button' name='created' id='createButton' class='menuButton'>CREATE</button>
              <input type='hidden' name='created'>";
              printSoundHiddenInput();
        echo "</form>";
        echo "<form action='login.php' method='POST'>
                <p>Send email again? <input type='submit' value='Click here' id='anchorButton' /> </p>
                <input type='hidden' name='newCode' />";                
              printSoundHiddenInput();
    }

    // Screen to be printed after code verification: confirmation of user created
    function confirmation(){
        echo "<div id='userVerified'><h1>Welcome!</h1>
              <p>User correctly created!</p>
              <button type='button' class='menuButton'>PLAY</button>
              </div>";
              printSoundHiddenInput();
    }


    // Print form according to user actions, and perform required accitions
    function printForm(){        
        if (!isset($_POST['newUser']) && !isset($_POST['creating']) && !isset($_POST['created']) && !isset($_GET['code']) && !isset($_POST['newCode'])) { // user login
            loginScreen();           
            // Allow login (user-password match)
            if (isset($_POST['login']) && login($_POST['user'], $_POST['pass'])){                                                    
                $_SESSION['user'] = $_POST['user']; // Set user name 
                $_SESSION['salt'] = getSalt($_POST['user']); // Save salt from user for later verification of logged user in next screens
                $_SESSION['sound'] = $_POST['sound']; // Save sound preferences
                session_write_close();
                header("Location:../menu/menu.php"); // to menu screen
                exit();
            }           
        } else if (isset($_POST['newUser']) && !isset($_POST['creating'])){ // create new user            
            newUser();
        }  else if (isset($_POST['creating']) && compareDB($_POST['user'], 'user') && compareDB($_POST['email'], 'email') && compareDB($_POST['gameName'], 'name')){ // Go to verify account with email code           
            $code = getCode(); 
            $salt = generateSalt();
            // Generate session variables            
            $_SESSION['code'] = md5($code);
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['newUser'] = $_POST['user'];
            $_SESSION['salt'] = $salt; 
            $_SESSION['pass'] = password_hash($_POST['pass'] . $salt, PASSWORD_DEFAULT); // Encrypt password + "salt"
            $_SESSION['gameName'] = $_POST['gameName'];
            // send verification code via email
            sendMail($_SESSION['email'], $_SESSION['newUser'], $code); 
            verifCount();
        } else if (isset($_GET['code']) && $_GET['code'] == "error"){ // When the code introduced is wrong            
            verifCount();
        } else if (isset($_POST['newCode'])){ // When requested new email
            $code = getCode(); 
            sendMail($_SESSION['email'], $_SESSION['newUser'], $code); // send new verification code email
            $_SESSION['code'] = md5($code);
            verifCount();
        }  else if (isset($_POST['creating']) && (!compareDB($_POST['user'], 'user') || !compareDB($_POST['email'], 'email') || !compareDB($_POST['gameName'], 'name'))){ // Activated when duplicated data (user, email, name) is introduced            
            newUser();
        } else if (isset($_POST['created'])){ // User correctly created
            checkCode(); // Check if the code introduced is correct, otherwise, redirects towards code verification screen
            createUser($_SESSION['newUser'], $_SESSION['pass'], $_SESSION['email'], $_SESSION['gameName'], $_SESSION['salt']); // create user
            $_SESSION['user'] = $_SESSION['newUser']; // Set user name 
            session_write_close();
            confirmation();            
        }
    }


    // Compare introduced $input with all users $field
    function compareDB($field, $input){
        $dbUsers = getUsers();    
        // Print ranks in selected range
        while ($row = mysqli_fetch_assoc($dbUsers)){
            if ($row[$input] == $field){            
                return false; // user name exists already
            }
        }
        return true; // user name doesn't exist
    }

    // change form action attribute if new user is created
    function printAction(){
        if (isset($_POST['created'])){ // When user has been created --> go to main menu
            echo "../menu/menu.php";
        } else {
            echo "../login/login.php";
        }
    }

    // Check if code introduced is correct (matches with email code)
    function checkCode(){
        $userCode = md5($_POST['userCode']);
        $verifCode = $_SESSION['code'];
        if ($userCode != $verifCode) {
            header("Location:../login/login.php?code=error"); // to introduce code screen
            exit();
        }
    }

    /* ----------------------------------------
    Generate "salt" fragment
    ------------------------------------------*/
    function generateSalt() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /* --------------------------------------------
    Send verification email
    ---------------------------------------------*/
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
    // Send email to user (creating accound)
    function sendMail ($mail, $name, $code){
        // Parameters
        $to = $mail;
        $subject = "GuessGame account verification";
        $message = "Hello ". $name .",\r\n \r\n".        
        "Welcome to GuessGame! In this email you can find the verification code to verify your new account: \r\n".
        "\r\n".
        $code . "\r\n".
        "\r\n".
        "If you have not requested to create an account at the GuessGame, please ignore this email.\r\n \r\n".
        "Thank you!";
        $header = 'From: XXX@XXX.XXX'; // Fill with valid email
        // Send email
        mail($to, $subject, $message, $header);
    }
    /*
    https://stackoverflow.com/questions/72113637/how-to-use-phpmailer-after-30-may-2022-when-less-secure-app-is-no-longer-an-o
    https://github.com/PHPMailer/PHPMailer/wiki/Using-Gmail-with-XOAUTH2
    */
    /*------------- Error messages -------- */
    // User and password do not match
    function logFail(){
        if (isset($_POST['login'])){
            return "<label class='errorMessage'> Incorrect user or password </label> </br>";                        
        }                  
    }    
    // Duplicated user in DB
    function duplicatedUser(){
        if (isset($_POST['creating']) && !compareDB($_POST['user'], 'user')){
            return "<label class='errorMessage' >User name is not available</label> </br>";                        
        }      
    }
    // Duplicated email in DB
    function duplicatedEmail(){
        if (isset($_POST['creating']) && !compareDB($_POST['email'], 'email')){
            return "<label class='errorMessage'>Email already in use</label> </br>";                        
        }      
    }
    // Duplicated name in DB
    function duplicatedName(){
        if (isset($_POST['creating']) && !compareDB($_POST['gameName'], 'name')){
            return "<label class='errorMessage'>Name already in use</label> </br>";                        
        }      
    }
    // Autofill values after submiting post and staying in the same form
    function autoFill($field){
        if (isset($_POST[$field])){
            return $_POST[$field];
        } else {
            return "";
        }
    }
?>