// This is the main file controlling all the events on game.php. There are 2 JS files to control:
    // Game movements (gameMoves.js): sequence of click events to control the colour movements 
    // Game rules (gameRules.js): scoring, end of the game, final punctuation


    // Main events:
$(document).ready(function (){ 
    // Start functions
    const code = startGuess(); // Generate random code (to be guessed)

    startTimer(); // Run timer    
    $(".buttonElement").show(); // displays buttons (hidden after finishing a game)
    $("#enter").prop("disabled",true); // starting point with check button disabled
    $("#delete").prop("disabled",false); // starting point with delete button disabled
    // If there are 4 pictures placed and is not round 10, the button "Check" will appear
    $(document).on("click", function(event){                
        if (round != 10){
            checkRound();
        }        
    });
    // Delete button
    $("#delete").on("click", function(event){
        deleteRow();
        $("#enter").prop("disabled",true);
    });
    var round = 0; // Round counter
    // Enter button
    $("#enter").on("click", function (){    
        nextRound(round);  
        setPoints(round, code); 
        round++;        
        document.getElementById("roundCounter").innerText="ROUNDS: " + round;
        winner();             
        $(this).prop("disabled",true);
        if (round == 10) { // when the max number or rounds is reached, the button is hidden.
            $(this).hide();
        }
        deleteRow();        
    });

    // Button to close the victory/defeat pannel
    $("#winnerContainer").hide(); // By default, hidden
    $("#closeVictoryWindow").on("click", function(){
        $("#winnerContainer").hide();
        $(".buttonElement").hide(); // Hide menu and reset buttons
        $("#backToPanel").show(); // Button to go back to the pannel
    });
    // Button to see again the victory/defeat pannel
    $("#backToPanel").hide(); // hidden by default
    $("#backToPanel").on("click", function(){            
        $("#winnerContainer").show();
        $("#backToPanel").hide(); // Back to hidden
    }); 
    // Sound button background-colour changes (green ON; red OFF)
    var sound = detectSoundSRC();
    if (sound){
        $("#soundButton").css('background-color','lightgreen');
    } else if (!sound){
        $("#soundButton").css('background-color','red');
    }
    $("#soundButton").on("click",function() {        
        var state = detectSoundSRC();
        if (state){
            $(this).css('background-color','lightgreen');
        } else if (!state){
            $(this).css('background-color','red');
        }
    }); 

    // Color blind button
    $("#colorBlindButton").on("click", function (){    
        // Define variables
        var state = $(this).attr("value"); // Button value
        var gameColors = document.getElementsByClassName("colorImg"); // Get all pictures containing colours img (in palette, round box and board game)
        var points = document.getElementsByClassName("roundPoint"); 

        // Deactivated --> turn to activated
        if (state == "OFF"){
            // Change button value
            $(this).val("ON"); 
            // Change button's color
            $(this).css('background-color','lightgreen');
            // Change colours in board game
            for (var i = 0; i<gameColors.length; i++){
                var src = gameColors[i].src; // Get SRC from img
                // Get the last element "blindcolor.png"
                var arSrc = src.split("/"); 
                var color = arSrc.at(-1);
                // Replace the SRC to color blind version 
                gameColors[i].src = '/guessgame/resources/pictures/gamePage/colours/colorblind/blind' + color;                
            }
            // Change punctuation images
            for (var i=0; i<points.length; i++){
                var src = points[i].src; // Get SRC from img
                // Get the last element "aCorrect.png"
                var arSrc = src.split("/"); 
                var point = arSrc.at(-1);
                // Replace the SRC to color blind version 
                points[i].src = '/guessgame/resources/pictures/gamePage/points/colorblind/' + point;                
            }
        // Activated --> turn to deactivated
        } else if (state == "ON") {
            // Change button value
            $(this).val("OFF"); 
            // Change button's color
            $(this).css('background-color','red');
            // Change colours in board game
            for (var i = 0; i<gameColors.length; i++){
                var src = gameColors[i].src; // Get SRC from img
                // Get the last element "color.png"
                var arSrc = src.split("/"); 
                var color = arSrc.at(-1);
                color = color.substring(5, color.length);
                // Replace the SRC to "normal" color version 
                gameColors[i].src = '/guessgame/resources/pictures/gamePage/colours/' + color;                
            }
            // Change punctuation images
            for (var i=0; i<points.length; i++){
                var src = points[i].src; // Get SRC from img
                // Get the last element "aCorrect.png"
                var arSrc = src.split("/"); 
                var point = arSrc.at(-1);
                // Replace the SRC to "normal" color version 
                points[i].src = '/guessgame/resources/pictures/gamePage/points/' + point;                
            }
        }    
    });
});

/////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SET OF FUNCTIONS //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

// Get value from ID
function getColor(id){
    var color = $("#" + id).val();
    return color;
}


// Random start of colors-combination to guess --> generate secret code
function startGuess(){    
    // Get level value
    var level = document.getElementById("level").value;    
    // Create array to store solution
    var code = [];
    // Generate random code
    for (var x = 0; x < 4; x++){
        code[x] = Math.floor(Math.random() * level);        
    }

    return code;
}


/*BUTTONS FUNCTIONS*/
// Remove all <img> from the gamer box
function deleteRow(){  
    // Get the 4 boxes
    var boxes = document.getElementById("boxes");
    var box = boxes.getElementsByClassName("box");       
    var boxNumber = box.length;
    // In each box, get the <img>
    for (var i=0; i < boxNumber; i++){
        var currentBox = box[i];
        currentBox.innerText=""; // delete content of the box
    } 
}

// Function to copy the introduced colors in the "roundBox" (class name) boxes
function nextRound(round){    
    // Clone introduced colours in boxes
    var boxes = document.getElementById("boxes");
    var newRound = boxes.cloneNode(true);
    // Obtain <div class="color">. [].slice.call used to retrieve an array (getElementsByClassName retrieves an HTMLCollection)
    var colours =  [].slice.call(newRound.getElementsByClassName("color"));       
    // Append to boxes in <div class="round"> containers
    var round = document.getElementById("round_"+ round);  
    var roundBox = round.getElementsByClassName("roundBox");
    for (var i=0; i<4; i++){
        var colour = colours[i].cloneNode(true);
        roundBox[i].appendChild(colour);
        // Remove background from round boxes
        roundBox[i].style.background = 'none';
    }    
}

// Function to check if the gamer box has 4 pictures
// Remove all <img> from the gamer box
function checkRound(){  
    // Get the 4 boxes
    var boxes = document.getElementById("boxes");
    var box = boxes.getElementsByClassName("box");  
    // Total number of imgs
    var imgs = 0;         
    // count the number of <img>
    for (var i=0; i < box.length; i++){
        var currentBox = box[i];
        var img = currentBox.getElementsByTagName("img");
        var imgNumber = img.length;
        // If the box contains <img>, it is removed
        if (imgNumber != 0){          
            imgs++;
        }
    }
    // if there are 4 imgs, it is possible to go to the next round
    if (imgs == 4 ) {
        $("#enter").prop("disabled",false);
    }
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// TIMER //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
// Updated from source: https://francescricart.com/ejercicio-js-crear-un-cronometro-con-javascript/

var h = 0; // hours
var m = 0; // minutes
var s = 0; // seconds   
var stopTimer = true; // when true -> run timer; false -> stop timer
let startTimeout; // variable to clean the time out (after stop/reset timer)

// Function to start timer
function startTimer(){
    if (stopTimer == true){
        stopTimer = false;
        runTimer();
    }
}

// Function to stop the timer
function stopTime (){
    if (stopTimer == false){
        stopTimer = true;
        stopTimerCycle()
    }
}

// Function to run the timer
function runTimer() {
    if (stopTimer == false){
        s = parseInt(s);
        m = parseInt(m);
        h = parseInt(h);

        // run 1s
        s = s + 1;
        if (s == 60){
            m = m + 1;
            s = 0;
        } 
        if (m == 60){
            h = h + 1;
            m = 0;
            s = 0;
        }
        // "If seconds, minutes and/or hours are lower than 10, add a 0 in front. This is why we need to parse everything in the beginning: doing this operation they become strings"
        if (s < 10 || s == 0){
            s = '0' + s;
        }
        if (m < 10 || m == 0){
            m = '0' + m;
        }
        if (h < 10 || h == 0){
            h = '0' + h;
        }

        // Print time
        document.getElementById("timer").innerText = h + ":" + m + ":" + s;
        // make sure that every 1000ms (1s) the function is called.
        startTimeout = setTimeout("runTimer()",1000);        
    }
}

// function to clean the timeout
function stopTimerCycle(){
    clearTimeout(startTimeout);
}

// reset the timer
function resetTimer(){
    document.getElementById("timer").innerText = "00:00:00";
    stopTimer = true;
    h = 0;
    m = 0;
    s = 0;
    stopTimerCycle()
}

// Get time
function getTime(){
    var time = $('#timer').text();
    return time;
}
