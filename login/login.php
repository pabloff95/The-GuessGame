<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <title>GuessGame</title>        
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="login.css">
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="/guessgame/login/controller/controllerEventsLogin.js"></script>
        <script src="../resources/code/sounds.js"></script>
        <script src="/guessgame/resources/code/validation.js"></script>
        <?php             
            // load php files 
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelLogin.php"; // load model
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/login/controller/controllerLogin.php"; // load controller
        ?>
        <link rel="shortcut icon" href="#">
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
    </head>
    <body>        
        <?php       
            session_start();
            // Destroy session variables when user clicked on logout
            if (isset($_POST['logout'])){                
                $_SESSION = array();
                session_destroy();                
            }         
        ?> 
        <button id="soundButton">
            <?php
            // Print sound button <img>
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/resources/code/soundController.php"; // load sound controller
            printSoundIcon();
            ?>  
        </button>

        <div id="middle-column"></div>     
        
        <div id="container">
            <div id="leftForm" class="logForm">
                <img id="logo">  
                <div id="playContainer">
                <div id="playFrame">
                    <form method="POST" action="../menu/menu.php" id="formNologin">
                        <h1>Don't want to login?</h1>
                        <input type="hidden" name="noLogin">
                        <?php printSoundHiddenInput(); ?>
                        <button type="button" class="menuButton" id="noLogin">PLAY</button>
                    </form>
                </div>
                </div>
            </div>
                  
            <div class="logForm" id="rightForm">                
                <div id="loginFrame">                    
                    <div id="login">                    
                        <form method="POST" action="<?php printAction() ?>" id="loginForm">                
                        <?php                     
                            printForm();
                        ?>                
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </body>    
</html>