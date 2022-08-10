<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GuessGame</title>
        <script src="/guessgame/resources/code/jquery.js"></script>  
        <script src="../resources/code/sounds.js"></script>
        <!-- Add JS event controller + game functionalities-->
            <script src="/guessgame/game/controller/controllerEventsGame.js"></script>        
            <script src="/guessgame/game/controller/gameRules.js"></script>
            <script src="/guessgame/game/controller/gameMoves.js"></script>                   
        <link rel="stylesheet" type="text/css" href="../resources/styles/generalStyle.css">    
        <link rel="stylesheet" type="text/css" href="../resources/styles/menuButton.css">
        <link rel="stylesheet" type="text/css" href="game.css">                
        <link rel="icon" href="/guessgame/resources/pictures/other/icon.png" sizes="16x16">
    </head>
    <body>
        <?php 
            // Add php files
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelGame.php"; // load model
            require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/game/controller/controllerGame.php"; // load controller
            
            session_start();

            // If user access directly by copying the URL (--> no difficulty was selected), redirect them
            if (!isset($_REQUEST['level'])){
                if (isset($_SESSION['user']) && checkSessionUser($_SESSION['user'], $_SESSION['salt'])){
                    header("Location:../game/difficultyMenu/difficulty.php"); // to choose difficulty when the user is logged
                    exit();
                } else {
                    header("Location:../login/login.php"); // to menu log screen when user is not logged
                    exit();
                }                
            }

            // Insert automatically a defeat in DB when user loads the page (for registered users)--> 
            // if user leaves the page, defeat is already introduced. When user loses or wins, then this is updated
            if (isset($_SESSION['user']) && checkSessionUser($_SESSION['user'], $_SESSION['salt'])){
                insertGame(getUserName($_SESSION['user']), "NO_DATA", 10, $_POST["level"], 0, 0); 
            }   

        ?>    
        <div id="pageContent"> <!-- GRIDLAYOUT ----------------------------------------- -->                  
        
            <header> <!-- GRIDLAYOUT: HEADER ----------------------------------------- -->
                <!-- Main buttons: menu and reset -->
                <div id="mainButtons">
                    <div class="buttonElement">
                        <form action="../menu/menu.php" method="POST">
                            <button type="button" id="backMenu" class="menuButton">MENU</button>
                            <input type="hidden" name="toMenu">
                            <?php 
                                require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/resources/code/soundController.php"; // load sound controller
                                printSoundHiddenInput(); 
                            ?>
                        </form>
                    </div>
                    <div class="buttonElement">
                        <form action="game.php" method="POST">
                            <button type="button" id="reset" class="menuButton">RESET</button>
                            <input type="hidden" name="level" value="<?php echo $_REQUEST['level']; ?>" >  <!-- Save chosen difficulty -->
                            <?php printSoundHiddenInput(); ?>
                        </form>
                    </div>
                    <button type="button" id="backToPanel" class="menuButton">BACK</button>
                </div>
                

                <!-- Color blind and sound buttons -->
                <div id="headerRight">                    
                    <div id="switch">
                        <div class="switchElement" id="leftSwitch">
                            <p id="colorBlindText">COLOR BLIND</p>
                        </div>
                        <div class="switchElement toolButton" id="rightSwitch">
                            <input type="button" value="OFF" id="colorBlindButton" class="panelButton">
                        </div>
                        <div class="switchElement toolButton" >
                            <button id="soundButton" class="panelButton">
                                <?php
                                // Print sound button <img>
                                printSoundIcon();
                                ?>  
                            </button>                    
                        </div>  
                    </div>
                    <div id="selectedColourContainer">
                        <img id="selectedColour">
                    </div>
                </div>
                
            </header> <!-- GRIDLAYOUT END: HEADER ----------------------------------------- -->

            <div id="sideBarLeft"><!-- GRIDLAYOUT: SIDEBAR LEFT SITE ----------------------------------------- -->
                <!-- Color panel choosing section: filled from JS -->
                <div id="colorsContainer">
                    <div id="colors">
                        <?php                               
                            // Print the number of colors according to selected level
                            printPalette();
                        ?>            
                    </div>
                </div>
            </div><!-- GRIDLAYOUT END: SIDEBAR LEFT SITE ----------------------------------------- -->

            <div id="screenCenter"><!-- GRIDLAYOUT: MAIN SCREEN ----------------------------------------- -->

                <!-- Game board --> 
                <div id="game">
                    <!-- gamer color boxes (x10 rounds) --> 
                    <div id="gameBox">
                        
                        <div id="roundBoxes">
                            <?php
                                printRoundBoxes();
                            ?>
                        </div>
                        <div id="boxes">
                            <div class="box" id="box1"></div>
                            <div class="box" id="box2"></div>
                            <div class="box" id="box3"></div>
                            <div class="box" id="box4"></div>
                        </div>
                    </div>
                </div>
                

            </div><!-- GRIDLAYOUT END: MAIN SCREEN ----------------------------------------- -->       

            <div id="sideBarRight"><!-- GRIDLAYOUT: SIDEBAR RIGHT SITE ----------------------------------------- -->
                <!-- Round counter and chronometer -->
                <div id="mainStats">
                    <div class="statElement">
                        <p id="roundCounter">ROUNDS: 0</p>
                    </div>
                    <div class="statElement" id="timerStat">
                        <p id="timer">00:00:00</p>
                    </div>
                </div>

                <div id="gameButtonsSection">
                    <div id="gameButtonColumn">                    
                        <!--game button: enter row -->        
                        <button type="button" id="enter" class="gameButton">CHECK</button>   
                        <!--game button: delete row -->   
                        <button id="delete" class="gameButton">DELETE</button>
                    </div>
                </div>

            </div><!-- GRIDLAYOUT END: SIDEBAR RIGHT SITE ----------------------------------------- -->

        </div><!-- GRIDLAYOUT END ----------------------------------------- -->       


        
                <!-- Victory Pannel (show at the end of the game) -->
                <div id="winnerContainer">
                    <div id="winner">
                        <div id="winnerInfo">
                            <!-- Information to display -->            
                            <input type="button" id="closeVictoryWindow" value="X"> <!-- Button to close window-->
                            <h1 id="result"></h1>            
                            <h2>Your score<?php  
                                if (isset($_SESSION['user'])){
                                    echo ", ".getUserName($_SESSION['user']); // Print name game, not user name
                                }                    
                                ?>:</h2>            
                            <p id="totalTime"></p>
                            <p id="totalRounds"></p>
                            <p id="totalPoints"></p>           
                        </div>

                        <!-- forms with MENU and RESTART buttons -->                    
                        <div id="winnerButtons">
                            <!-- User logged - winner pannel: button to go back to menu -->
                            <div class="winnerButton">
                                <form method="POST" action="../menu/menu.php">                                     
                                    <button type="button" id="backToMenu" class="menuButton" >MENU</button>
                                    <input type="hidden" name="toMenu">
                                    <?php printSoundHiddenInput(); ?>
                                </form>
                            </div>
                            <!-- User logged - winner pannel: button to restart -->
                            <div class="winnerButton">
                                <form method="POST" action="game.php">     
                                    <button type="button" id="resetGame" class="menuButton" >RESTART</button>
                                    <input type="hidden" name="gameFinish">                                        
                                    <input type="hidden" name="level" id="level" value="<?php echo $_REQUEST['level']; ?>" >  <!-- Save chosen difficulty -->
                                    <?php printSoundHiddenInput(); ?>
                                </form>
                            </div>
                        </div>
                    </div>           
                </div>
                
    </body>
</html>
