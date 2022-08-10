<?php
require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";

// Database functions for myscore.php

// Get number of games 
function getGames($user, $table){
    $db = connect();
    // Get name
    $name = getUserName($user);
    // Query
    $sql_select = $db->prepare("SELECT * FROM ". $table ." WHERE name = ? ");
    $sql_select->bind_param("s", $name);
    $sql_select->execute();
    // Get number of games
    $sql_select->store_result();
    $rows = $sql_select->num_rows;
    // Close
    $sql_select->close();
    mysqli_close($db);

    return $rows;
}

// Get number of victories 
function getVictories($user, $table){
    $db = connect();
    // Get name
    $name = getUserName($user);
    // Query
    $sql_select = $db->prepare("SELECT * FROM ".$table." WHERE victory=1 AND name = ? ");
    $sql_select->bind_param("s", $name);
    $sql_select->execute();
    // Return result
    $sql_select->store_result();
    $rows = $sql_select->num_rows;
    $sql_select->close();// Close query
    mysqli_close($db);// Close DB
    if ($rows>0) {
        return $rows;
    } else {         
        return NO_DATA;
    }    
}

// Get Win rate
function getWR($user, $table){
    if (getGames($user, $table) == NO_DATA) { // Not games played
        return NO_DATA;
    } else if (getVictories($user, $table) == 0){ // No victories
        return "0%";
    } else { // Games played and >0 victories
        $wr = (getVictories($user, $table)/getGames($user, $table))*100;        
        return number_format($wr, N_DECIMALS, ',', '') . "%";
    }
}

// Get fastest time of all games
function getBestTime($user, $table){
    $db = connect();
    // Get name
    $name = getUserName($user);
    // Query
    $sql_select = $db->prepare("SELECT time FROM ". $table ." WHERE name = ? ORDER BY time ASC");
    $sql_select->bind_param("s", $name);
    $sql_select->execute();
    // Retrieve result in $times
    $sql_select->store_result();
    $sql_select->bind_result($times);
    $sql_select->fetch();
    // Close
    $sql_select->close(); 
    mysqli_close($db); 
    // Return results   
    if ( gettype($times)=="NULL"){ // when no data has been selected
        return NO_DATA;        
    } else {        
        return $times;        
    }    
}

// Get average rounds per game
function getAvgRounds($user, $table){
    $db = connect();
    // Get name
    $name = getUserName($user);
    // Query
    $sql_select = $db->prepare("SELECT AVG(rounds) FROM ". $table ." WHERE name = ?");
    $sql_select->bind_param("s", $name);
    $sql_select->execute();
    // Retrieve result in $rounds
    $sql_select->store_result();
    $sql_select->bind_result($rounds);
    $sql_select->fetch();
    // Close
    $sql_select->close(); 
    mysqli_close($db); 
    // Return results   
    if (gettype($rounds)=="NULL"){ // when no data has been selected
        return NO_DATA;        
    } else {        
        return number_format($rounds, N_DECIMALS, ',', '');        
    }     
}

// Get average points per game
function getAvgPoints($user, $table){
    $db = connect();
    // Get name
    $name = getUserName($user);
    // Query
    $sql_select = $db->prepare("SELECT AVG(points) FROM ". $table ." WHERE name = ? ");
    $sql_select->bind_param("s", $name);
    $sql_select->execute();
    // Retrieve result in $games
    $sql_select->store_result();
    $sql_select->bind_result($games);
    $sql_select->fetch();
    // Close
    $sql_select->close(); 
    mysqli_close($db); 
    // Return results   
    if ( gettype($games)=="NULL"){ // when no data has been selected
        return NO_DATA;        
    } else {
        return round($games);
    }     
}

// Get rank position
function getRank($user, $table){    
    // Get name
    $name = getUserName($user);
    // Connect to DB
    $db = connect();
    // Query    
    $sql_select = "SELECT name FROM ".$table." ORDER BY points DESC";    
    // Perform query
    $result = mysqli_query($db, $sql_select);
    mysqli_close($db);
    $rank = 0;
    while ($row = mysqli_fetch_assoc($result)){                
        $rank++;
        if ($row['name'] == $name){
            return $rank;
        }
    }
    return NO_DATA; // Code only returned if name is not registered in the DB
}


?>

