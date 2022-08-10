<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GuessGame</title>
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="howtoplay.css">
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="../resources/code/sounds.js"></script>
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
        <script>
            // NOTE: JS code in page due to small lines of code requried
            $(document).ready(function(){
            // Allown only one tag from <details> open at the time
                $("details").click(function(event) {
                    $("details").not(this).removeAttr("open");
                });
            });
        </script>
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";
            session_start();
            // Redirect to login if accessed directly by URL (only allowed access to logged users)
            if ((!isset($_POST['toRules']) && !isset($_SESSION['user'])) // not comming from menu / not logged user
                || (isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt'])) // existing user session, but there is no match with DB
            ){
                header("location:../login/login.php"); 
                exit();
            } 
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
        <h1>GUESSGAME RULES</h1>      
        <div id="expandibleMenu">
        <details>
            <summary>HISTORY</summary>            
            <div class="sumContent">
            <p>The GuessGame is an independent project.</p>
            <p>Here you can find an online adaptaion to the popular boardgame Mastermind. The GuessGame project 
                allows to play different levels, to keep track of your scores and to rank your game with other registered players.</p>        
            </div>
        </details>
        <details>
            <summary>RULES</summary>
            <div class="sumContent">            
            <p>The objective of the game is to guess a secret code of 4 colours. These colours might be repeated or not</p>        
            <p>For guessing this code you will have 10 rounds.</p>
            <p>After pressing on "Check" the puntuation of the round will appear in the screen:</p>
                <ul><li>Green-light: you have guessed one colour and it is in the right position.</li>
                <li>Yellow-light: you have guessed one colour. However, its position is wrong.</li>
                <li>Red-light: no colour has been guessed.</li></ul>
            <p>The game ends when the player guess the colour (Victory!) or when the player reaches the 10<sup>th</sup> round without guessing the code (Defeat!).</p>
            </div>
        </details>
        <details>
            <summary>SCORING</summary>  
            <div class="sumContent">          
            <p>The scoring allows logged users to rank their games and compete with other players.</p>        
            <p>The scoring of every player is calculated according to the average puntuation of their games. This is done separately for every difficulty</p>
            <p>The maximum posible puntutation is 10.000 points, but how is this puntuation calculated?</p>
            <p>Up to 4.000 points can be achieved depending on the time required to guess the secret key. The less time required, the more points you get!
                Therefore, a player that would finish the game in 1 second, would make 4.000 points, but players that need more than 10 minutes, would get 0
                points.
            </p>
            <p>Up to 6.000 points can be achieved depending on the rounds played to guess the secret key. This is how it is calculated:</p>
            <table>
                <tr id="topRow">
                    <th class="col1">ROUNDS&nbsp;</th>
                    <th>POINTS&nbsp;</th>
                </tr>
                <tr>
                    <td class="col1">1</td>
                    <td>6000&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">2</td>
                    <td>5400&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">3</td>
                    <td>4800&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">4</td>
                    <td>4200&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">5</td>
                    <td>3600&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">6</td>
                    <td>3000&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">7</td>
                    <td>2400&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">8</td>
                    <td>1800&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">9</td>
                    <td>1200&nbsp;</td>
                </tr>
                <tr>
                    <td class="col1">10</td>
                    <td>600&nbsp;</td>
                </tr>                  
            </table>
            </br>
            </div>
        </details>
        <details>
            <summary>WHY TO LOGIN?</summary> 
            <div class="sumContent">           
            <p>Register at the GuessGame is not requeired to play. However, by login you will be able to keep track of your games and statistics, which will allow you 
                to keep track of your improvement.</p>
                <p>Besides, to rank your score in the global multiplayer rank, it is required to be loged.</p>        
            </div>
        </details>

        </div>
        
        <form action="../menu/menu.php" method="POST">
            <button type="button" class="menuButton">BACK</button>
            <input type="hidden" name="toMenu">
            <?php printSoundHiddenInput(); ?>
        </form>  
            </div>
        </div>
    </body>
</html>