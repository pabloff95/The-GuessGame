<?php
require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php"; // load main model

// CHANGE PASSWORD DB FUNCTIONS
// Check if user - email introduced match
function checkData($user, $email){
    $db = connect();
    // Query
    $sql_select = $db->prepare("SELECT * FROM user WHERE user = ? AND email = ? ");
    $sql_select->bind_param("ss", $user, $email);
    $sql_select->execute();
    // Return true/false according to whether match was performed
    $sql_select->store_result();
    $rows = $sql_select->num_rows;
    $sql_select->close();// Close query
    mysqli_close($db);// Close DB
    if ($rows>0) {
        return true; // Exists
    } else {         
        return false; // Does not exist
    }   
}

// Function update password
function updatePassword($user, $email, $newPass){
    $db = connect();
    // Prepare variables (scape, encrypt)
    $salt = getSalt($user);
    $newPass = password_hash($newPass . $salt, PASSWORD_DEFAULT); // Encrypt password and add "salt" to find match in the DB
    // Query
    $sql_update = $db->prepare("UPDATE user SET passw= ? WHERE user = ? AND email = ? ");
    $sql_update->bind_param("sss", $newPass, $user, $email);
    $sql_update->execute();
    // Close
    mysqli_close($db);  
    $sql_update->close();
}


?>