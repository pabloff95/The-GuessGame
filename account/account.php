<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GuessGame</title>   
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="/guessgame/account/controller/controllerEventsAccount.js"></script>        
        <script src="../resources/code/sounds.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">    
        <link rel="stylesheet" type="text/css" href="account.css">     
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
        <script src="/guessgame/resources/code/validation.js"></script>
        
        <?php
        session_start();
        // Load php files
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelAccount.php"; // load model
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/account/controller/controllerAccount.php"; // load controller        

        // Redirect to login if accessed directly by URL (allowed access to logged users)
        if (!isset($_SESSION['user']) || isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt'])){
            header("location:../login/login.php"); 
            exit();
        }
        /*
        if (!isset($_POST['toDiff']) && !isset($_SESSION['user'])){
            header("location:../login/login.php"); 
            exit();
        } */
        
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
            
            // Screen is changed according to value in $_SESSION['TODO'] (see controllerAccount.php)                       
            // Set $_SESSION['TODO'] variable
            changeScreen();

            // First if conditions: 
                // $_SESSION['TODO'] = 0 -> Account menu
                // if $_SESSION['TODO'] isn't set and $_POST("account") set -> user comes from main menu
            if ((isset($_SESSION['TODO']) && $_SESSION['TODO'] == 0) || (!isset($_SESSION['TODO']) &&  isset($_POST['account']))){                
                // Print normal HTML account menu
                menuForm();
            // Change password
            } else if (isset($_POST['changePass']) || (isset($_SESSION['TODO']) && $_SESSION['TODO'] == 1)){
                changePasswordForm(); // Print form
                $_SESSION['TODO'] = 1; 
            }
            // Change email 
            else if (isset($_POST['newEmailButton']) || (isset($_SESSION['TODO']) && $_SESSION['TODO'] == 2)){
                changeEmailForm(); // Print form
                $_SESSION['TODO'] = 2; 
            }
            // Change email 
            else if (isset($_POST['deleteAccount']) || (isset($_SESSION['TODO']) && $_SESSION['TODO'] == 3)){
                deleteAccountForm();// Print form
                $_SESSION['TODO'] = 3; 
            }
            // Print confirmation menus [TODO = 4]
            else if ((isset($_SESSION['TODO']) && $_SESSION['TODO'] == 4)){
                // Confirmation message for password changed
                if (isset($_POST['passChanged'])){
                    confirmationPassword();  
                    $_SESSION['TODO'] = 0;  
                }
                // Confirmation message for email changed
                if (isset($_POST['emailChanged'])){
                    confirmationEmail();
                    $_SESSION['TODO'] = 0; 
                }
                // Confirmation message for account deleted
                if (isset($_POST['confirmDelete'])){
                    confirmationDelete();
                    // Destroy session 
                    $_SESSION = array();
                    session_destroy();             
                }
            }
            // if used accesed directly by copying URL
            else if (isset($_SESSION['user']) && checkSessionUser($_SESSION['user'], $_SESSION['salt']) && $_SESSION['TODO'] == -1){
                // Print normal menu
                menuForm();
            }
        ?>
            </div>
        </div>
    </body>
</html>