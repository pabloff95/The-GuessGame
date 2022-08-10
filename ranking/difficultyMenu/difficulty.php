<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GuessGame</title>
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="difficulty.css">    
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="/guessgame/resources/code/sounds.js"></script>
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
    </head>
    <body>
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";
            session_start();
            // Redirect to login if accessed directly by URL (unless that the user is logged in another page (!isset($_SESSION['user'])))
            if (!isset($_SESSION['user']) && !isset($_POST['toRanks']) || (isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt']))){
                header("location:/guessgame/login/login.php");
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

        <div id="container">
            <div id="content">
                <h1>SELECT RANKING</h1>
                <form action="../ranks.php" method="post">                                                           
                    <button type="button" class="menuButton" >EASY</button><br>
                    <input type='hidden' name='diff' value="easy">
                    <?php printSoundHiddenInput(); ?>
                </form>
                <form action="../ranks.php" method="post">                                                           
                    <button type="button" class="menuButton" >MEDIUM</button><br>
                    <input type='hidden' name='diff' value="medium">
                    <?php printSoundHiddenInput(); ?>
                </form>
                <form action="../ranks.php" method="post">                                                           
                    <button type="button" class="menuButton" >HARD</button><br>
                    <input type='hidden' name='diff' value="hard">
                    <?php printSoundHiddenInput(); ?>
                </form>
                <form action="../ranks.php" method="post">                                                           
                    <button type="button" class="menuButton" >EXTREME</button>
                    <input type='hidden' name='diff' value="extreme">
                    <?php printSoundHiddenInput(); ?>
                </form>
                <br>
                <form method="POST" action="../../menu/menu.php">
                    <button type="button" name="toMenu" class="menuButton" >MENU</button>
                    <input type='hidden' name='toMenu'>
                    <?php printSoundHiddenInput(); ?>
                </form>  
            </div>
        </div>
    </body>
</html>