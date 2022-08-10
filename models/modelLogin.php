<?php

require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";

// DATABASE FUNCTIONS FOR login.php

// Create new users
function createUser($user, $pass, $mail, $name, $code){
    // Connect to DB
    $db = connect();
    // Prepare query
    $sql_insert = $db->prepare("INSERT INTO user (user, passw, email, name, salt) VALUES (?, ?, ?, ?, ?)");
    // Bind parameters (x5 strings = sssss)
    $sql_insert->bind_param("sssss", $user, $pass, $mail, $name, $code);
    // Execute query
    $sql_insert->execute();
    // Close
    $sql_insert->close();  
    mysqli_close($db);    
}

// login with user and password
function login($user, $pass){
    // Connect to DB
    $db = connect();   
    // Query -> get password according to user selected
    $sql_select = $db->prepare("SELECT passw FROM user WHERE user = ?");
    $sql_select->bind_param("s", $user); // Bind parameters
    $sql_select->execute(); // Execute query
    // Store password hash in $hash
    $sql_select->store_result();
    $sql_select->bind_result($hash);
    $sql_select->fetch();
    // Prepare password introduced (add "salt")
    $salt = getSalt($user);
    $pass = $pass . $salt;
    // Check password
    if (password_verify($pass, $hash)) {
        return true;
    } else {
        return false;
    }
}

// CHECK FOR REPEATED USERS - EMAILS (when creating users)
// Get all users
function getUsers(){
    // Connect to DB
    $db = connect();   
    // Query
    $sql_select = "SELECT user,email,name FROM user";
    $result = mysqli_query($db, $sql_select);
    mysqli_close($db);// Close DB

    return $result;   
}

?>