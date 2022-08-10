<?php
//------------------------------------------------------------------------
// 0 - MAIN MENU
//------------------------------------------------------------------------
// Print main manu of account.php
function menuForm(){
    echo "
    <form action='account.php' method='POST'>
            <button type='button' class='menuButton'>CHANGE PASSWORD</button></br>
            <input type='hidden' name='changePass'>";
            printSoundHiddenInput();
    echo "</form>
        <form action='account.php' method='POST'>
            <button type='button' class='menuButton'>CHANGE EMAIL</button></br>
            <input type='hidden' name='newEmailButton'>";
            printSoundHiddenInput();
    echo "</form>
        <form action='account.php' method='POST'>
            <button type='button' class='menuButton'>DELETE ACCOUNT</button></br>
            <input type='hidden' name='deleteAccount'>";
            printSoundHiddenInput();
    echo "</form>
        </br>
        <form action='../menu/menu.php' method='POST'>
            <button type='button' class='menuButton'>BACK</button>
            <input type='hidden' name='toMenu'>";
            printSoundHiddenInput();
    echo "</form>";
}

//------------------------------------------------------------------------
// 1 - CLICK IN "CHANGE PASSWORD"
//------------------------------------------------------------------------
// Print change password form
function changePasswordForm(){
    echo "<form action='account.php' method='POST' id='accountForm1'>
            <div class='passwordElement'>
                <input type='password' name='oldPass' class='passwordField' id='oldPass' placeholder=' Old password' maxlength='30' >
                <img src='../resources/pictures/other/eyeClose.svg' id='seeOldPass' class='passImg' ></br>                 
            </div>
                <label style='visibility: hidden' id='wrongOldPass' class='errorMessage'>Wrong password</br></label>
            <div class='passwordElement'>
                <input type='password' name='newPass' class='passwordField' id='newPass1' placeholder=' New password' maxlength='30' > 
                <img src='../resources/pictures/other/eyeClose.svg' id='seeNewPass1' class='passImg' ></br>                 
            </div>
            <div class='passwordElement'>
                <input type='password' id='newPass2' class='passwordField' placeholder=' Repeat password' maxlength='30' >
                <img src='../resources/pictures/other/eyeClose.svg' id='seeNewPass2' class='passImg' ></br>                                  
            </div>
                <label id='characterError' class='error'>Character not allowed (<, >)</label></br>
                <label id='notMatchPasswords' class='errorMessage'>The passwords introduced do not match</label></br></br>
                <button type='button' id='changePass' class='menuButton'>CHANGE</button>
                <input type='hidden' name='passChanged'>
                ";
            printSoundHiddenInput();
    echo "</form>
          <form action='account.php' method='POST'>
                <button type='button' class='menuButton'>CANCEL</button>
                <input type='hidden' name='cancel'>";
                printSoundHiddenInput();
    echo "</form>";
}

// Print confirmation message
function confirmationPassword(){
    echo "<form action='account.php' method='POST'>
                <h1>Password succesfully changed!</h1>
                <button type='button' class='menuButton'>BACK TO ACCOUNT</button>
                <input type='hidden' name='confirmated'>";
                printSoundHiddenInput();
    echo "</form>
          <form action='../menu/menu.php' method='POST'>
                <button type='button' class='menuButton'>MENU</button>
                <input type='hidden' name='toMenu'>";
                printSoundHiddenInput();
    echo "</form>";
}
//------------------------------------------------------------------------
// 2 - CLICK IN "CHANGE EMAIL"
//------------------------------------------------------------------------
// Print change email form
function changeEmailForm(){
    echo "<form action='account.php' method='POST' id='accountForm2'>
                <div class='passwordElement'>
                    <input type='password' name='pass' id='passEmail' class='passwordField' placeholder=' Password' maxlength='30' >
                    <img src='../resources/pictures/other/eyeClose.svg' id='seePassEmail' class='passImg' ></br>                 
                </div>
                <label style='visibility: hidden' id='wrongPassEmail' class='errorMessage'>Wrong password</br></label>
                <input type='email' name='newEmail' id='newEmail1' placeholder=' New email' maxlength='100' ></br>                 
                <input type='email' id='newEmail2' placeholder=' Repeat email' maxlength='100' ></br>   
                <label id='characterError' class='error'>Character not allowed (<, >)</label></br>              
                <label id='notMatchEmails' class='error'>The emails introduced do not match</br></label>
                <label id='registeredEmail' style='visibility: hidden' class='errorMessage'>Email already registered</label></br></br>
                <button type='button' id='changeEmail' class='menuButton'>CHANGE</button>
                <input type='hidden' name='emailChanged'>";
                printSoundHiddenInput();
    echo "</form>
          <form action='account.php' method='POST'>
                <button type='button' class='menuButton'>CANCEL</button>
                <input type='hidden' name='cancel'>";
                printSoundHiddenInput();
    echo "</form>";
}

// Print confirmation message
function confirmationEmail(){
    echo "<form action='account.php' method='POST'>
                <h1>Email succesfully changed!</h1>
                <button type='button' class='menuButton'>BACK TO ACCOUNT</button>
                <input type='hidden' name='confirmated'>";
                printSoundHiddenInput();
    echo "</form>
          <form action='../menu/menu.php' method='POST'>
                <button type='button' class='menuButton'>MENU</button>
                <input type='hidden' name='toMenu'>";
                printSoundHiddenInput();
    echo "</form>";
}
//------------------------------------------------------------------------
// 3 - CLICK IN "DELETE ACCOUNT"
//------------------------------------------------------------------------
// Print change email form
function deleteAccountForm(){
    echo "<form action='account.php' method='POST' id='accountForm3'>
                <h1>Are you sure you want to delete your account?</h1>
                <label>Please, enter your password:</label></br>
                <div class='passwordElement'>
                    <input type='password' name='passDeleteAcc' id='passDeleteAcc' class='passwordField' placeholder=' Password' maxlength='30' > 
                    <img src='../resources/pictures/other/eyeClose.svg' id='seePassAcc' class='passImg' ></br>               
                </div>
                <label id='characterError' class='error'>Character not allowed (<, >)</label></br>                
                <label style='visibility: hidden' id='wrongPassAcc' class='errorMessage'>Wrong password</label></br></br>
                <button type='button' id='confirmDelete' class='menuButton' >DELETE</button>
                <input type='hidden' name='confirmDelete'>";
                printSoundHiddenInput();
    echo "</form>
          <form action='account.php' method='POST'>
                <button type='button' class='menuButton'>CANCEL</button>
                <input type='hidden' name='cancel'>";
                printSoundHiddenInput();
    echo "</form>";
}
// Print confirmation message
function confirmationDelete(){
    echo "<form action='../login/login.php' method='POST'>
                <h1>Account succesfully deleted</h1>
                <button type='button' class='menuButton'>EXIT</button>";
                printSoundHiddenInput();
    echo "</form>";
}

//------------------------------------------------------------------------
//-------------  CHANGE SCREEN ACCORDING TO USER CLICKS ------------------
//------------------------------------------------------------------------

// Main function of account.php: Sets $_SESSION['TODO'] and performs the DB actions
    // Screen is changed according to value in $_SESSION['TODO']
        // -1 = allow to loop through all the if-else statements
        // 0 = Account menu
        // 1 = Change password
        // 2 = Change email
        // 3 = Delete account
        // 4 = Confirmation messages (same value used for all the menu options)

function changeScreen(){
    // If pressed in cancel, back to account menu
    if (isset($_POST['cancel'])){
        $_SESSION['TODO'] = 0;
    }  
    // Change password screen
    else if (isset($_SESSION['TODO']) && isset($_POST['oldPass']) && $_SESSION['TODO'] == 1){
        // Check if password matchs with user  
        $check = checkOldPassword($_POST['oldPass']);
        if ($check){ // Correct --> allow change
            changePassword($_POST['newPass']); // Update password
            $_SESSION['TODO'] = 4; // all OK-> confirmation message
        } else if (!$check){    // Incorrect --> do not allow change
            echo "<style>#wrongOldPass{visibility: visible !important;}</style>"; // Print error message
            $_SESSION['TODO'] =1; // keep screen
        } 
    }  
    // Change email screen
    else if (isset($_SESSION['TODO']) && isset($_POST['pass']) && $_SESSION['TODO'] == 2){
        // Check if password matchs with user  
        $check = checkOldPassword($_POST['pass']);
        if ($check && !checkEmail($_POST['newEmail'])){ // Password OK, email not registered --> Correct --> allow change
            changeEmail($_POST['newEmail']); // Update email
            $_SESSION['TODO'] = 4; // all OK-> confirmation message 
        } else if (!$check){    // Incorrect password --> do not allow change
            echo "<style>#wrongPassEmail{visibility: visible !important;}</style>"; // Print error message
            $_SESSION['TODO'] =2; // keep screen
        } else if (checkEmail($_POST['newEmail'])){ // registered email --> do not allow change
            echo "<style>#registeredEmail{visibility: visible !important;}</style>"; // Print error message
            $_SESSION['TODO'] =2; // keep screen
        }
    }
    // Delete account
    else if (isset($_SESSION['TODO']) && isset($_POST['passDeleteAcc']) && $_SESSION['TODO'] == 3){
        $check = checkOldPassword($_POST['passDeleteAcc']);
        if ($check){ // correct password
            // Delete game data of the user
            deleteGames("easy");
            deleteGames("rankeasy");
            deleteGames("medium");
            deleteGames("rankmedium");
            deleteGames("hard");
            deleteGames("rankhard");
            deleteGames("extreme");
            deleteGames("rankextreme");                        
            // Delete user
            deleteUser();
            // Go to confirmation menu
            $_SESSION['TODO'] = 4; 
        } else if (!$check){ // incorrect password
            echo "<style>#wrongPassAcc{visibility: visible !important;}</style>"; // Print error message
            $_SESSION['TODO'] = 3; 
        } 
    }
    // Confirmation screens
    else if (isset($_POST["confirmated"])){
        $_SESSION['TODO'] = 0; // Reset value to 0 so main account menu is printed
    }
    // No button pressed (and not comming from menu. Ej.: 1st. click on cancel, 2nd. click on an account.php button
    else if (!isset($_POST['account'])){
        $_SESSION['TODO'] = -1; 
    }
    
}


?>