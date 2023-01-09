<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GuessGame</title>
        <?php
        
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";
        session_start();
        // Redirect to login if accessed directly by URL (unless that the user is logged in another page (!isset($_SESSION['user'])))
        if (!isset($_SESSION['user']) && !isset($_POST['toDiff']) || (isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt']))){
            header("location:/guessgame/login/login.php");
            exit();
        }

        ?>
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="/guessgame/resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="/guessgame/ranking/difficultyMenu/difficulty.css"> <!-- same style as in ranking difficulty menu -->
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="/guessgame/resources/code/sounds.js"></script>
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
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
                <h1>CHOOSE LEVEL</h1>
                    <div id="difficulties">
                        <form name="difficulty" action="../game.php" method="POST">            
                            <button type="button" class="menuButton mainMenuButton" >EASY</button>    
                            <input type='hidden' name="level" value="3">
                            <?php printSoundHiddenInput(); ?>    
                        </form>
                        <form name="difficulty" action="../game.php" method="POST">            
                            <button type="button" class="menuButton mainMenuButton" >MEDIUM</button>            
                            <input type='hidden' name="level" value="4">
                            <?php printSoundHiddenInput(); ?>    
                        </form>
                        <form name="difficulty" action="../game.php" method="POST">            
                            <button type="button"  class="menuButton mainMenuButton" >HARD</button>            
                            <input type='hidden' name="level" value="5">
                            <?php printSoundHiddenInput(); ?>    
                        </form>
                        <form name="difficulty" action="../game.php" method="POST">            
                            <button type="button"  class="menuButton mainMenuButton" >EXTREME</button>            
                            <input type='hidden' name="level" value="6">
                            <?php printSoundHiddenInput(); ?>    
                        </form>
                        </br>
                        <form action="../../menu/menu.php" method="POST">
                            <button type="button" class="menuButton mainMenuButton" >BACK</button>
                            <input type='hidden' name="toMenu">
                            <?php
                            // Set hidden item with sound information
                            if (isset($_POST['sound'])){ // When it has been selected in previous pages, it keeps the data stored
                                echo "<input type='hidden' name='sound' value='".$_POST['sound']."' class='soundTracker'>";
                            } else { // When it has not been previously selected --> default: on
                                echo "<input type='hidden' name='sound' value='/guessgame/resources/pictures/other/volumeon.svg' class='soundTracker'>";
                            } ?> 
                        </form>
                    </div>
            </div>
        </div>
    </body>
</html>