<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GuessGame</title>     
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="../resources/code/sounds.js"></script>
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
    </head>
    <body>
        <?php           
            session_start(); 
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";
            // Determine whether user is logged    
            if (isset($_POST['noLogin'])){ // used clicked on play without login
                $session = false;
            } else if (!isset($_POST['noLogin'])){            
                if (isset($_SESSION['user']) && checkSessionUser($_SESSION['user'], $_SESSION['salt'])){ // user loged or is in menu after creating new user (stays loged)            
                    $session = true;
                }  else {
                    session_destroy(); // user accessed directly to menu through URL (skipping log/not log screen)
                    $session = false;
                }           
            }
            
            // if user access directly by the URL, it redirects (unless it's already loged in another page (session active))
                // noLogin: access from login screen (without login)
                // session: user is logged
                // toMenu: when pressed back to menu from other screens
            if (!isset($_POST['noLogin']) && !$session && !isset($_POST['toMenu'])){
                header("location:../login/login.php");            
                exit();
            }

        ?>
        <button id="soundButton">
            <?php
            // Print sound button <img>
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/resources/code/soundController.php"; // load sound controller
            printSoundIcon();
            ?>  
        </button>
        <div id="centerScreen">
        <div id="logoContainer">
            <img src="/guessgame/resources/pictures/other/logo_nobg.png" id="logo">
        </div>

        <div id="container">
            <div id="content">
        <form action="../game/difficultyMenu/difficulty.php" method="POST">
            <button type="button" class="menuButton">PLAY</button>
            <input type='hidden' name='toDiff'>
            <?php printSoundHiddenInput(); ?>
        </form>
        <form method="POST" action="../howtoplay/howtoplay.php">
            <button type="button" class="menuButton">HOW TO PLAY</button>
            <input type='hidden' name='toRules'>
            <input type='hidden' name="sound" class="soundTracker">
            <?php printSoundHiddenInput(); ?>
        </form>
        <form action="../ranking/difficultyMenu/difficulty.php" method="POST">
            <button type="button" class="menuButton">RANKING</button>
            <input type='hidden' name='toRanks'>
            <input type='hidden' name="sound" class="soundTracker">
            <?php printSoundHiddenInput(); ?>
        </form>
        <?php 
        if ($session){
            echo "<form action='../myscore/myscore.php' method='POST'>
                    <button type='button' class='menuButton'>MY SCORE</button>";
                    printSoundHiddenInput();
            echo "</form>";     
            echo "<form action='../account/account.php' method='POST'>
                        <button type='button' class='menuButton'>ACCOUNT</button>
                        <input type='hidden' name='account'>";
                        printSoundHiddenInput();
            echo "</form>";     
            echo "<form action='../login/login.php' method='POST'>
                        <button type='button' class='menuButton'>LOGOUT</button>
                        <input type='hidden' name='logout'>";
                        printSoundHiddenInput();
            echo "</form>";     

        } else if (!$session) {
            echo "<form action='../login/login.php' method='POST'>
                        <button type='button' class='menuButton'>BACK</button>";
                        printSoundHiddenInput();
            echo "</form>";     
        }     
        ?>
            </div>
        </div>
        </div>
    </body>
</html>