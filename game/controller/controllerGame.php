<?php

// Print the number of colors according to selected level
function printPalette(){
    $level = (int)$_POST['level'];        
    $colors = array("red", "blue", "green", "yellow", "purple", "orange");
    
    for ($x = 0; $x < $level; $x++){
      echo "<div class='color'>
                <img src='../resources/pictures/gamePage/colours/" . $colors[$x] . ".png' id='" . $colors[$x] . "' class='colorImg' />
                <input type='hidden' value='" . $x . "' class='valueBox'>
            </div>";
    }   
    echo "<input type='hidden' id='level' value='" . $_POST["level"]."' >"; // Used in JS to get the level selected          
}

// Print the round boxes (x10)
function printRoundBoxes(){
    for ($x = 9; $x>-1; $x-- ){
       echo "<div class='round' id='round_".$x."'>                   
                <div class='roundBox'></div>
                <div class='roundBox'></div>
                <div class='roundBox'></div>
                <div class='roundBox'></div>                
                <div class='points' id='points".$x."'></div>
            </div>";
    }
}
?>