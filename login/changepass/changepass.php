<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GuessGame</title>
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="/guessgame/login/changepass/controller/controllerEventsChangepass.js"></script>        
        <script src="/guessgame/resources/code/sounds.js"></script>
        <script src="/guessgame/resources/code/validation.js"></script>
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/menuButton.css">    
        <link rel="stylesheet" type="text/css" href="changepass.css">
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">        
        <?php                 
            // Load php files        
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelChangepass.php"; // load model
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/login/changepass/controller/controllerChangepass.php"; // load controller
            session_start();
        ?>
    </head>
    <body>        
        <button id="soundButton">
            <?php
            // Print sound button <img>
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/resources/code/soundController.php"; // load sound controller
            printSoundIcon();
            ?>  
        </button>

        <div id="container">
            <div id="content">
        <?php         
            if (isset($_POST['passwordChanged'])) { // Printed when user introduced already the new password
                $_SESSION = array();// deletes the session variables: userNam, code, emailNam
                $_SESSION['user'] = $_POST['userNam']; // Session created for when user clicks on "play" button in the next form
                $_SESSION['salt'] = getSalt($_POST['userNam']); // Save salt from user for later verification of logged user in next screens
                updatePassword($_POST['userNam'], $_POST['emailNam'], $_POST['newPass']);
        ?>
            <h2>Password changed!</h2>
            <form method="POST" action="/guessgame/menu/menu.php" >
                <input type="button" value="PLAY" class="menuButton">
                <?php printSoundHiddenInput(); ?>
            </form>
            <form method="POST" action="../login.php" >
                <button type="button" class="menuButton">BACK</button> 
                <input type='hidden' name='logout'><!-- Allows to destroy session in login.php-->
                <?php printSoundHiddenInput(); ?>
            </form>
        <?php                
            } else {
        ?>
        
        <h2>Reset password</h2>
        <?php
            $wrongCode = false;
            // Check, if form to verificate user and email has been posted, whether the information was correct ($dataVerification = true)
            if (isset($_POST['resetPass'])){
                $dataVerification = checkData($_POST['userNam'], $_POST['emailNam']);
            } else {
                $dataVerification = false; // when the form has not been posted, still is set to false
            }
            // Print according to the information introduced (or not introduced by the user)
            if (!$dataVerification && !isset($_POST['codeVerified']) && !isset($_GET['code'])) { // information not posted, or posted wrongly
        ?>
            <form method="POST" action="changepass.php" id="changepassForm">                        
                <input type="text" id="userInput" name="userNam" placeholder=' User' maxlength="20" required></br>                
                <input type="email" id="emailInput" name="emailNam" placeholder=' Email' maxlength="100" required>
                <?php
                if (isset($_POST['resetPass'])){
                    printError($_POST['userNam'], $_POST['emailNam']);
                }            
                ?>
                </br>
                <label id="emailError" class="error">Wrong email</br></label>
                <label id="characterError" class="error">Character not allowed (<, >)</br></label>
                <button type="button" class="menuButton">RESET</button>
                <!--input type="submit" value="RESET" -->
                <?php printSoundHiddenInput(); ?>
                <input type='hidden' name='resetPass'>
            </form>
            <form method="POST" action="../login.php">
                <button type="button" class="menuButton">BACK</button>
                <input type='hidden' name='logout'>
                <?php printSoundHiddenInput(); ?>
            </form>

        <?php
            } else if ($dataVerification || isset($_GET['code'])) { // Information posted is correct (to verification email screen); or returning to this page after error with the code verification
                $code = getCode();    
                if (!isset($_SESSION['userNam'])){ // set session variables
                    $_SESSION['userNam'] = $_POST['userNam'];
                    $_SESSION['emailNam'] = $_POST['emailNam']; 
                }                
                if (!isset($_GET['code'])){ // send email (first time in this page)
                    sendPasswordMail($_POST['emailNam'], $_POST['userNam'], $code);                    
                } else if ($_GET['code']=="new"){ // When clicked on send email again
                    sendPasswordMail($_SESSION['emailNam'], $_SESSION['userNam'], $code);                    
                }
        ?>
            <form method="POST" action="changepass.php" id="changepassForm2">
                <p class="codeText">Please, introduce the verification code received in your email:</p>
                <input type="text" name="userCode" maxlength="6" required>
                <label id="characterError" class="error"></br>Character not allowed (<, >)</br></label>
                <?php
                    if (isset($_GET['code']) && $_GET['code']=="error") { // Promt message when the code is incorrect
                        echo "<p class='dbError'>Incorrect code</p>";                        
                    }
                ?>
                <button type="button" class="menuButton" >VERIFY</button>
                <input type='hidden' name='codeVerified'>
                <input type="hidden" name="userNam" value="<?php 
                    echo $_SESSION['userNam']; 
                ?>">
                <input type="hidden" name="emailNam" value="<?php
                    echo $_SESSION['emailNam']; 
                ?>">
                <input type="hidden" name="genCode" value="<?php
                    if (!isset($_SESSION['code'])){
                        echo md5($code); 
                    } else {
                        echo $_SESSION['code']; 
                    }                    
                ?>">                      

                <?php printSoundHiddenInput(); ?>
            </form>
            <form action='changepass.php?code=new' method='POST' id='resendEmail' >
                <p>Send email again? <a href='javascript:document.getElementById("resendEmail").submit();' >Click here</a></p>                
                <?php printSoundHiddenInput(); ?>
            </form>
            
        <?php
            } else if (isset($_POST['codeVerified'])) { // verification email code introduced is correct                
                if (md5($_POST["userCode"]) != $_POST["genCode"]){  // if it is incorrect, redirects towards the same page, creating $_GET for the error and starting session variables to keep the data           
                    $_SESSION['code'] = $_POST["genCode"];
                    header("Location:/guessgame/login/changepass/changepass.php?code=error"); // redirect towards email code verification
                    exit();
                }
        ?>
            <form method="POST" action="changepass.php" id="changepassForm3">       
                <div class='passwordElement'>
                    <input type="password" name="newPass" id="newPass" class="passwordField" placeholder=" New password" maxlength='30'  required>
                    <img src='/guessgame/resources/pictures/other/eyeClose.svg' id='seePassword1' class='passImg' ></br>                 
                </div>
                <div class='passwordElement'>
                    <input type="password" name="newPass2" id="newPass2" class="passwordField" placeholder=" Repeat password" maxlength='30' required>
                    <img src='/guessgame/resources/pictures/other/eyeClose.svg' id='seePassword2' class='passImg' ></br>
                </div>
                <label id="newPassVerif">The passwords do not match</label>
                <input type="hidden" name="userNam" value="<?php echo $_POST['userNam']; ?>">
                <input type="hidden" name="emailNam" value="<?php echo $_POST['emailNam']; ?>">
                <label id="characterError" class="error"></br>Character not allowed (<, >)</br></label>
                <button type="button" id="passwordChanged" class="menuButton">CHANGE</button>
                <input type='hidden' name='passwordChanged'>
                <?php printSoundHiddenInput(); ?>
            </form>
        <?php

            } // Finisdes the $dataVerification (after introducing user - email)
        } // Finishes the $_POST['passwordChanged'] verification (after changing the password)
        ?>
            </div>
        </div>
    </body>    
</html>

