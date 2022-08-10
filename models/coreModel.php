<?php

// Connection to database
function connect(){
    // Parameters --> to be defined when implemented
    $host = "";
    $user = "";
    $pass = "";
    $db = ""; 
    // Connection
    $connection = mysqli_connect($host, $user, $pass, $db);
    return $connection;
}

// Get user game name, by user
function getUserName($user){
    $db = connect();
    // Prepare query
    $sql_select = $db->prepare("SELECT name FROM user WHERE user = ? ");
    // Bind params
    $sql_select->bind_param("s", $user);
    // Execute query
    $sql_select->execute();
    // Retrieve result in $name
    $sql_select->store_result();
    $sql_select->bind_result($name);
    $sql_select->fetch();
    // Close
    mysqli_close($db);
    $sql_select->close();        
    return $name;
}

// -- CYBERSECURITY --
// Scape strings (avoid XSS): avoid scripts to be executed when echo data
function scape($string){
    return htmlspecialchars($string, ENT_QUOTES, "UTF-8", false);
}

// Get "salt" fragment according to user
function getSalt($user){
    $db = connect();
    // Prepared query
    $sql_select = $db->prepare("SELECT salt FROM user WHERE user = ? ");
    $sql_select->bind_param("s", $user);
    $sql_select->execute();
    // Return and close
    $sql_select->store_result();
    $sql_select->bind_result($salt);
    $sql_select->fetch();
    // Close
    mysqli_close($db);
    $sql_select->close();        
    return $salt;
}


// Check that logged user exits (according to $_SESSION['user']), matching session variable with "salt" in DB
function checkSessionUser($user, $salt){
    $db = connect();
    // Prepared query
    $sql_select = $db->prepare("SELECT user FROM user WHERE user = ? AND salt = ?");
    $sql_select->bind_param("ss", $user, $salt);
    $sql_select->execute();
    // Check match (user - salt exits in DB)
    $sql_select->store_result();
    $rows = $sql_select->num_rows;
    $sql_select->close();// Close query
    mysqli_close($db);// Close DB
    if ($rows>0) {
        return true;
    } else {         
        return false;
    } 
}

?>



























