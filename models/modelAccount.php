<?php
require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";

//------------------------------------------------------------------------
// 1 - CLICK IN "CHANGE PASSWORD"
//------------------------------------------------------------------------
// Check whether old password is correct
function checkOldPassword($oldPass){
    $db = connect();
    // Query    
    $sql_select = $db->prepare("SELECT passw FROM user WHERE user = ? ");
    $sql_select->bind_param("s", $_SESSION['user']);
    $sql_select->execute();
    // Store password hash in $hash
    $sql_select->store_result();
    $sql_select->bind_result($hash);
    $sql_select->fetch();
    // Prepare password introduced (add "salt")
    $salt = getSalt($_SESSION['user']);
    $oldPass = $oldPass . $salt;
    // Check password
    if (password_verify($oldPass, $hash)) {
        return true;
    } else {
        return false;
    }
}

// Change password funtion
function changePassword($newPass){
    $db = connect();
    // Prepare password 
    $salt = getSalt($_SESSION['user']);
    $newPass = password_hash($newPass . $salt, PASSWORD_DEFAULT);
    // Prepare query
    $sql_update = $db->prepare("UPDATE user SET passw= ? WHERE user = ? ");
    $sql_update->bind_param("ss", $newPass, $_SESSION['user']);
    $sql_update->execute();
    // Close
    $sql_update->close();
    mysqli_close($db); 
}

//------------------------------------------------------------------------
// 2 - CLICK IN "CHANGE EMAIL"
//------------------------------------------------------------------------
// Check if email exists
function checkEmail($email){
    $db = connect();
    // Prepare query
    $sql_select = $db->prepare("SELECT name FROM user WHERE email = ?");
    $sql_select->bind_param("s", $email);
    $sql_select->execute();
    // Return true/false according to whether match was performed
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

// Change email funtion
function changeEmail($newEmail){
    $db = connect();    
    // Prepare query
    $sql_update = $db->prepare("UPDATE user SET email= ? WHERE user = ? ");
    $sql_update->bind_param("ss", $newEmail, $_SESSION['user']);
    $sql_update->execute();
    // Close
    $sql_update->close();
    mysqli_close($db); 
}

//------------------------------------------------------------------------
// 3 - CLICK IN "DELETE ACCOUNT"
//------------------------------------------------------------------------
// Delete games
function deleteGames($table){
    $db = connect();    
    // Get user name
    $name = getUserName($_SESSION['user']);
    // Prepare query
    $sql_delete = $db->prepare("DELETE FROM ". $table ." WHERE name = ? "); // Table cannot be passed as parameter in prepared statement
    $sql_delete->bind_param("s", $name);
    $sql_delete->execute();
    // Close
    mysqli_close($db); 
    $sql_delete->close();
}

// Delete user
function deleteUser(){
    $db = connect();       
    // Prepare query
    $sql_delete = $db->prepare("DELETE FROM user WHERE user = ? ");
    $sql_delete->bind_param("s", $_SESSION['user']);
    $sql_delete->execute();
    // Close
    mysqli_close($db); 
    $sql_delete->close();
}

?> 