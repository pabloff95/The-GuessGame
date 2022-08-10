<?php
// This file controls the volume user preferences via PHP

// Print sound button <img>, but keeping track of volume options selected by the user
function printSoundIcon(){
    // When it has been selected in previous pages
    if (isset($_POST['sound'])){
        $sound = $_POST['sound'];
    } else if (isset($_SESSION['sound'])){
        $sound = $_SESSION['sound'];
    // When it has not been previously selected --> default: on
    } else {
        $sound = "/guessgame/resources/pictures/other/volumeon.svg";
    }
    echo "<img src='" .$sound. "' id='soundController' >";
}

// Set hidden item with sound information (hidden input to send post data to other pages)
function printSoundHiddenInput(){
    // When it has been selected in previous pages, it keeps the data stored
    if (isset($_POST['sound'])){
        $sound = $_POST['sound'];
    } else if (isset($_SESSION['sound'])){
        $sound = $_SESSION['sound'];
    // When it has not been previously selected --> default: on
    } else {
        $sound = "/guessgame/resources/pictures/other/volumeon.svg";
    }
    echo "<input type='hidden' name='sound' value='".$sound."' class='soundTracker'>";
}

?>