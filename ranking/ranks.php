<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <title>GuessGame</title>
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">   
        <link rel="stylesheet" type="text/css" href="ranks.css" />
        <script src="/guessgame/resources/code/jquery.js"></script>
        <script src="../resources/code/sounds.js"></script>
        <script src="/guessgame/resources/code/validation.js"></script>
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
    </head>
    <body>
        <?php 
        // load php files
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelRanks.php"; // load model
        require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/ranking/controller/controllerRanks.php"; // load controller
        session_start();

        // Redirect when accessed copying the url
        if (!isset($_SESSION['user']) && !isset($_REQUEST['diff']) || (isset($_SESSION['user']) && !checkSessionUser($_SESSION['user'], $_SESSION['salt']))){
            header("location:../login/login.php"); // if user is not logged
            exit();
        } else if (isset($_SESSION['user']) && checkSessionUser($_SESSION['user'], $_SESSION['salt']) && !isset($_REQUEST['diff'])){
            header("location:../ranking/difficulty.php"); // if user is logged but no difficult to show is selected
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
                <div id="title">
                    <form action='<?php changeDiffEasier(); ?>' method='POST'>            
                        <input type='button' class="changeDiffButton" value='<' >            
                        <?php printSoundHiddenInput(); ?>
                    </form>
                    <h1><?php echo strtoupper($_REQUEST['diff']); ?> DIFFICULTY</h1>
                    <form action='<?php changeDiffHarder(); ?>' method='POST'>            
                        <input type='button' class="changeDiffButton" value='>' >            
                        <?php printSoundHiddenInput(); ?>
                    </form>
                </div>
        <?php                        
            //PAGES NAVIGATION CODE
            // Variables            
            $nRanks = 10; // number of ranks displayed per page
            $nRows = getRanking(); // Total number of rows (ranking count)                
            
            $nPage = ceil($nRows/$nRanks); // total number of pages needed            

            // If there is no page selected (just clicked on "ranking" from menu screen) or the user introduce number out of range, set page = 1
            if (!isset($_POST["userText"])){
                if (!$_GET['page'] || $_GET['page']>$nPage || $_GET['page']<=0){   
                    $_SESSION['sound'] = $_POST['sound'];
                    header('Location:ranks.php?page=1&diff='.$_REQUEST['diff']);
                    exit();
                }
            }            
            // $_REQUEST['diff] along this page, keeps track of the difficulty selected by the user in "ranking/difficulty.php"
        ?>

        <!-- Search by name -->
        <form action='<?php echo "ranks.php?page=1&diff=" . $_REQUEST['diff']; ?>'' method="POST" id="rankingForm">
            <input type="text" name="userText" placeholder=" User name" maxlength="15">
            <button type="button" class="menuButton">SEARCH</button>
            <input type='hidden' name="user">
            <?php printSoundHiddenInput(); ?>
            <br><label id='characterError' class='error'>Character not allowed (<, >)</label>
        </form>

        <!-- Print ranking table -->
        <div id="ranking">
            </br>
            <table>
                <tr>
                    <th>RANK</th>
                    <th>NAME</th>
                    <th>POINTS</th>
                </tr>
            <?php
                // Print rankings from DB               
                if (!isset($_POST['userText'])){ // all ranks
                    $results = printNames($nRanks);                    
                } else if (isset($_POST['userText'])){ // ranks by name (specific name searched)                      
                    findRank($_POST['userText'], $nRanks, $nRows);
                }
            ?>
            </table>            
        </div>

        <?php
            // Now print the final buttons
            if (isset($_POST['userText'])){ // Printed when searching an specific user                                
                echo "<form action='ranks.php?page=1&diff=" . $_REQUEST['diff'] . "' method='POST'>            
                            <button type='button' class='menuButton' >BACK</button>";    
                            printSoundHiddenInput();
                echo "</form>";
            }                
            else if (!isset($_POST["userText"])){ // Printed when searching all ranks ?>
        
            <!-- Forms PHP code: when clicked, the buttons add or subtract 1 to the $_GET['page'] value;
            disabled is added when this $_GET['page'] has reached the minimum (0) or maximum ($nPage) number of pages to show-->
            
            <?php  
                if ($results) { // Print navigation buttons only when there are results
            ?>
            <div id="navContainer">
            <form action='<?php echo "ranks.php?page=" . ($_GET['page']-1) . "&diff=" .$_REQUEST['diff']; ?>' method='POST'>
                <input type='button' class="navButton" name='prev' value='<<<' <?php echo $_GET['page']<=1? 'disabled':'' ?>>            
                <?php printSoundHiddenInput(); ?>
            </form>
            <form action='<?php echo "ranks.php?page=" . ($_GET['page']+1)  . "&diff=" .$_REQUEST['diff']; ?>' method='POST'>            
                <input type='button' class="navButton" name='next' value='>>>' <?php echo $_GET['page']>=$nPage? 'disabled':'' ?> >            
                <?php printSoundHiddenInput(); ?>
            </form>
            </div>
            
            <?php } ?>

            
            <form method="POST" action="../menu/menu.php">
                <button type="button" class="menuButton" id="menuButton" >MENU</button>
                <input type='hidden' name="toMenu">
                <?php printSoundHiddenInput(); ?>
            </form> 
        
        <?php } ?>

            </div>
        </div>
    </body>
</html>