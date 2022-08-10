<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/modelGame.php"; // load model
    require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/game/controller/controllerGame.php"; // load controller
   
    session_start();
        
    if (isset($_SESSION['user'])){ // Only for registered users
    
        // Get values to insert in DB (from JS (AJAX) in gameRules.js, insertData())
        $userVal = getUserName($_SESSION['user']);
        $timeVal = $_REQUEST['time'];
        $roundVal = $_REQUEST['round'];
        $levelVal = $_REQUEST['level'];
        $victoryVal = $_REQUEST['victory'];
        $pointsVal = $_REQUEST['points'];
        
        // Insert (update) query function
        updateGame($userVal, $timeVal, $roundVal, $levelVal, $victoryVal, $pointsVal);                        
    
    }
 
?>