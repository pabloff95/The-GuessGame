<!DOCTYPE html>
<head>
    <title>GuessGame</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
    <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">   
    <link rel="stylesheet" type="text/css" href="myscore.css" />
    <script src="/guessgame/resources/code/jquery.js"></script>
    <script src="../resources/code/sounds.js"></script>
    <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
</head>
<body>
    <?php
        // Load php files
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelMyscore.php"; // load model
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/myscore/controller/controllerMyscore.php"; // load controller
        session_start();
        // if accessed directly by the link, it redirects to login, the not logged users
        if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt']))){
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

    <div id="container">
            <div id="content">
                <h1>SCORE</h1>
                <table>
                    <tr id="topRow">
                        <th></th>
                        <th>&nbsp;EASY&nbsp;</th>
                        <th>&nbsp;MEDIUM&nbsp;</th>
                        <th>&nbsp;HARD&nbsp;</th>
                        <th>&nbsp;EXTREME&nbsp;</th>
                    </tr>        
                    <?php
                        printGames($_SESSION['user']);
                        printVictories($_SESSION['user']);
                        printWinRatio($_SESSION['user']);
                        printBestTime($_SESSION['user']);
                        printAvgRound($_SESSION['user']);
                        printAvgPoints($_SESSION['user']);
                        printRanking($_SESSION['user']);
                    ?>
                </table>
                </br></br>
                <form method="POST" action="../menu/menu.php">
                    <button type="button" class="menuButton" >MENU</button>
                    <input type="hidden" name="toMenu">
                    <?php printSoundHiddenInput(); ?>
                </form>    
        </div>
    </div>
</body>