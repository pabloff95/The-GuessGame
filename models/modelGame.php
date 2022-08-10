<?php
require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";

//----------------------------------------------------------------------------
// Get table (used in in SQL insert query)
function table ($level){
    switch($level){
        case "3":
            return "easy";
            break;
        case "4":
            return "medium";
            break;
        case "5":
            return "hard";
            break;
        case "6":
            return "extreme";
            break;
    }    
}

// Insert values on victories
function insertGame ($name, $time, $round, $level, $victory, $points) {
    $db = connect();    
    // Get table
    $table = table($level);
    // Prepare query
    $sql_insert = $db->prepare("INSERT INTO ".$table." (name, points, rounds, time, victory) VALUES (?, ?, ?, ?, ?)");
    // Bind parameters
    $sql_insert->bind_param("siisi", $name, $points, $round, $time, $victory);
    // Execute query
    $sql_insert->execute();
    // Close 
    $sql_insert->close();
    mysqli_close($db);    
}

// Update value of user game at the end of the game
function updateGame ($name, $time, $round, $level, $victory, $points) {
    $db = connect();    
    // Get table
    $table = table($level);
    // Query
    $sql_update = $db->prepare("UPDATE ".$table." 
        SET points = ?, rounds = ?, time = ?, victory = ? 
        WHERE time ='NO_DATA' AND name = ? LIMIT 1");  // Limit ensures that only updates 1 value (in case that the user leaved the screen multiple times in the past)
    $sql_update->bind_param("iisis", $points, $round, $time, $victory, $name);
    $sql_update->execute();
    // Close 
    $sql_update->close();
    mysqli_close($db);   
}


?>










