// Here is included all the JS code used to play  all the sounds in every page of the website


$(document).ready(function(){ 
    // Sound button controller --> mute or play all sounds
    var sound = detectSoundSRC(); // according to this variable all the sounds are played or not
    $("#soundButton").on("click",function() {        
        // Change sound icon accordingly to user selection preferences and changes value of sound variable
        sound = changeSoundIcon();     
        // Update hidden inputs to keep track of the volume preferences (via $_POST in php)
        var src= document.getElementById("soundController").getAttribute("src");
        $(".soundTracker").val(src);
    });

    // Normal button sound
    $(".menuButton").on("click",function() {      
        if (sound) {     
            playButton(); // button click-sound
        }
        var focus = $(this); // Get element (not accesible inside settimeout())
        // Add delay (so the form submits after playing the sound)
        setTimeout(function(){ 
            focus.closest('form').submit(); // submit closest (parent) form 
        }, 300);
        
    });
    // Game (game.php) buttons sounds
    $(".gameButton, #colorBlindButton").on("click",function() {     
        if (sound) {     
            var audio = new Audio("../resources/sounds/gameButton.wav");
            audio.play();
        }
    });
    // Normal click sound (ranks.php --> navigation buttons)
    $(".navButton, .changeDiffButton").on("click",function() {    
        if (sound) {     
            var audio = new Audio("../resources/sounds/click.mp3");
            audio.play();
        }
        var focus = $(this); // Get element (not accesible inside settimeout())
        // Add delay (so the form submits after playing the sound)
        setTimeout(function(){ 
            focus.closest('form').submit(); // submit closest (parent) form 
        }, 100);
        
    });
    // Sound on colour placement in round boxes
    $(".box").on("click", function(){
        if (sound) {     
            // Apply sound if: box is empty & colour has been copied from the palette
            if ($(this).is(':empty') && document.body.style.cursor != "default"){
                var audio = new Audio("../resources/sounds/placeColour.mp3");
                audio.play();
            }        
            // Apply sound if: box is not empty (contains child elements = colours) & colour has been copied from the palette/other box
            else if ($(this).children().length > 0 && document.body.style.cursor == "default"){
                var audio = new Audio("../resources/sounds/swapColour.mp3");
                audio.play();                        
            }        
        }
    });    
});

// --  FUNCTIONS  --

// Play sound (button click sound)
function playButton(){
    var audio = new Audio("/guessgame/resources/sounds/clickButton.mp3");
    audio.play();
}
// Play victory sound (game.php)
function playVictory(){
    var sound = detectSoundSRC();
    if (sound) {  
        var audio = new Audio("../resources/sounds/victory.wav");
        audio.play();
    }
}
// Play victory sound (game.php)
function playDefeat(){
    var sound = detectSoundSRC();
    if (sound) {  
        var audio = new Audio("../resources/sounds/lose.wav");
        audio.play();
    }
}

//------------------------------------------------------------------------------------------
//-------------------------------------SOUND CONTROL----------------------------------------
//------------------------------------------------------------------------------------------
// Set Sound variable according to the <img> SRC (if it does not exist --> default: true = sound on)
function detectSoundSRC(){
    if (document.getElementById("soundController")){ // if element exists
        var src = document.getElementById("soundController").getAttribute("src");
        if (src == '../resources/pictures/other/volumeon.svg' || src == '/guessgame/resources/pictures/other/volumeon.svg'){   
            return true; 
        } else {
            return false;
        }

    } else { // when element does not exist -> default: on
        return true;
    }
}
// Change sound button logo (replace SRC attribute)
function changeSoundIcon(){
    var img = document.getElementById("soundController");
    if (img.getAttribute("src") == '../resources/pictures/other/volumeoff.svg' || img.getAttribute("src") == '/guessgame/resources/pictures/other/volumeoff.svg'){   
        img.src = '/guessgame/resources/pictures/other/volumeon.svg';  
        return true; 
    } else {
        img.src = '/guessgame/resources/pictures/other/volumeoff.svg';        
        return false;
    }
}


