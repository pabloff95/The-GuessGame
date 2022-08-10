// This file controlls all the events related to the calculation of the punctuation of every round and for the ending of the game (victory/defeat)

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// CLASS: ROUND ////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

// This class is used to calculate the score of each round
class Round{
    constructor(){
        this.roundScore = ["cIncorrect", "cIncorrect", "cIncorrect", "cIncorrect"]; // Array where score is stored
        this.roundColours = document.getElementById("boxes").getElementsByClassName("valueBox"); // Colours introduced by player
    }
    
    // Function to get the values associated to the colours introduced. Returns array
    getRoundValues(){
        var roundValues = [];
        for(var i = 0; i < this.roundColours.length; i++){                
            roundValues [i] = this.roundColours[i].value;        
        }       
        return roundValues;
    }

    // Set points
    setScore(code){  
        // Get values
        var solution =  $.extend( true, {}, code ); // copy solution code in new variable (independent from code variable)
        var roundValues = this.getRoundValues(); // Game round values           

        // Compare round colours and solution colours
            // 1 - Check colour and position matches (--> green ligth)
        for (var i=0; i < 4; i++){
            if (roundValues[i] ==  solution[i]){
                this.roundScore [i] = "aCorrect"; // Color and position match
                // Change values, so they do not get used in next loops
                solution[i] = "done"; 
                roundValues[i] = "done"; 
            }
        }
            // 2 - Check if the colour is present in another position (--> yellow light)
        for (var i=0; i < 4; i++){
            // Check if value was already used (--> green light)
            if (roundValues[i] == "done"){
                continue;
            }
            // if not, loop over the solution array to check matches (--> yellow light)
            for (var j=0; j < 4; j++){
                if (roundValues[i] == solution[j]){
                    this.roundScore[i] = "bMedium"; // Match of color, but not position (-> yellow light)
                    // Change values, so they do not get used in next loops
                    solution[j] = "done"; 
                    roundValues[i] = "done";
                    break; // move to next colour in "roundValues"
                }
            }
        }
            // 3 - No match of color or position (--> red position)
        for (var i=0; i < 4; i++){
            if (this.roundScore[i] != "bMedium" && this.roundScore[i] != "aCorrect") {
                this.roundScore [i] = "cIncorrect";
            }
        }       
    
        // Order points: from left to right -> correct, medium, incorrect
        this.roundScore.sort();
    }

    // Score getter
    getScore(code){
        this.setScore(code);
        return this.roundScore;
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// CALCULATE ROUND SCORE AND END GAME /////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

// Functions to set the round points, using the previous clase, and to show the final panel of game's end

// Function to calculate the points and finish the game (victory/defeat)
function setPoints(round, code){  
    // Obatin score
    var gameRound = new Round();
    var score = gameRound.getScore(code); // get score
    var blind = $("#colorBlindButton").attr("value"); // color blind button value

    // Print round points (append them to their clases)
    var roundPoints = $("#points" + round);
    for (var i=3; i!=-1; --i){
        if (blind == "OFF"){
            roundPoints.append("<div class='pointImg'><img src='../resources/pictures/gamePage/points/" + score[i] + ".png' class='roundPoint' /></div>");
        } else if (blind == "ON"){
            roundPoints.append("<div class='pointImg'><img src='../resources/pictures/gamePage/points/colorblind/" + score[i] + ".png' class='roundPoint' /></div>");
        }
    }
    
    // Victory/Defeat screen
    winner(score, round);
    lost(score, round, code);
}

// AJAX: activates PHP SQL query to insert into the DB a defeat record. It is introduced in the DB when the registered user
    // loads the page --> updates the value with the results of the victory / defeat
function insertData(round, score){
    // Check if its victory or defeat
    var victory = 1; // victory
    if (round == 9 && score.pop() != "aCorrect") { // only on defeats
        victory = 0;
    }
    // Define values
    var time = getTime();
    var rounds = round + 1;
    var level = document.getElementById("level").value;
    // Points
    if (victory == 0) {var points = 0}
    else {var points = getTotalPoints(round);}
    // Send data via post (AJAX)
    $.ajax({
        url: '/guessgame/game/controller/query.php', // File with the PHP SQL query
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache:false,
        // send values to php: "$_POST [name]" : "value"
        data: {
            time: time,
            round: rounds,
            level: level,
            victory: victory,
            points: points
        }, 
        type: 'post',
     });   
}



// Updates on result (victory/defeat) screen data of the game when finishes
function updateResultScreen(round, score){
    insertData(round, score); // Update data in DB via AJAX
    deleteRow(); // Delete colours from round boxes
    document.getElementById("enter").disabled=true;// Disable enter button
    document.getElementById("delete").disabled=true;// Disable enter button
    document.getElementById("winnerContainer").style.display= "unset"; // display victory/lose pannel        
    document.getElementById("totalTime").innerText = "Time: " + getTime(); // show time
    stopTime(); // stop time
    document.getElementById("totalRounds").innerText = "Rounds: " + (round + 1); // show number of rounds                
    //document.getElementById("mainButtons").style.display= "none"; // Hidde buttons    
    document.getElementsByClassName("buttonElement")[0].style.display= "none"; // Hidde buttons: Menu  
    document.getElementsByClassName("buttonElement")[1].style.display= "none"; // Hidde buttons: Delete
    document.getElementById("roundCounter").innerText="ROUNDS: " + round;    
}


// Victory: Stop game when the solution is guessed and display victory panel
function winner(score, round){
    if (typeof score !== 'undefined' && score.length > 1){ // check if the array exists
        if (score.at(-1) == "aCorrect"){ // when the last element of the array is correct = win    
            playVictory();// Play victory sound        
            document.getElementById("result").innerText = "Victory!"; // Add title
            updateResultScreen(round, score); // insert (update) data in DB
            document.getElementById("totalPoints").innerText = "Total points: " + getTotalPoints(round); // show achieved points                        
        }
    }    
}

// Lose: Stop the game at 10th round if no solution has been found
function lost (score, round, code){
    if (round == 9 && score.at(-1) != "aCorrect") {                
        playDefeat(); // Play victory sound        
        document.getElementById("result").innerText = "Defeat"; // Add title
        updateResultScreen(round, score); // insert (update) data in DB
        showSolution(code); // Print solution colours
    }
}

// Show solution pictures on defeats
function showSolution(code){
    var solutionColours = [];
    // Get array with colours
    for (var i = 0; i <4; i++){
        var box = code[i];
        switch (box){
            case 0:
                solutionColours[i] = "red";
                break;
            case 1:
                solutionColours[i] = "blue";
                break;
            case 2:
                solutionColours[i] = "green";
                break;
            case 3:
                solutionColours[i] = "yellow";
                break;
            case 4:
                solutionColours[i] = "purple";
                break;
            case 5:
                solutionColours[i] = "orange";
        }
    }
    solutionColours = solutionColours.reverse(); // reverse order to display in screen
    // Create HTML elements and append them
        // 1 <div> container
    var solutionContainer = document.createElement('div');
    solutionContainer.id = "solutionContainer";
    document.getElementById('totalPoints').appendChild(solutionContainer);
        // 2 text
    var text = document.createElement('h3');
    text.textContent = "Solution:";
    document.getElementById('solutionContainer').appendChild(text);
        // 3 Img with solution (x4)
    for (var i = 0; i<4; i++) {
        var solutionImg = document.createElement('img');
        // Show solution according to normal or blind color version
        var blind = $("#colorBlindButton").attr("value"); // color blind button value
        if (blind == "OFF"){
            solutionImg.src = '../resources/pictures/gamePage/colours/' + solutionColours[i] + '.png';
        } else if (blind == "ON"){
            solutionImg.src = '../resources/pictures/gamePage/colours/colorblind/blind' + solutionColours[i] + '.png';
        }
        
        solutionImg.className = "solutionColour";
        document.getElementById('solutionContainer').appendChild(solutionImg);
    }    
}



/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// CALCULATE FINAL PUNCTUATION //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

// Here is calculated the final punctuation (loses=0; victories, based on time and rounds required (max. 10.000))

// Maximum points possible: 10.000 - Divided in: max per rounds 6.000; max per time 4.000
// Calculate the points achieved per round in the game: -600 points when round++ (max 6000 - round 1, min 600 - round 10)
function getRoundPoints(rounds){
    var roundCoeff = 600; // - poitns per each round played
    var maxRoundPoints = 6000; // maximum points in total (finishing at round 1)
    var points = maxRoundPoints - roundCoeff*(rounds); // rounds without -1, because it starts in 0, not 1
    return points;
}
// Calculate the points achieved per time in the game: maximum of 4.000 points, for each second in the game - 6.66 points (so if the game >10 min --> 0 points)
function getTimePoints(){
    // Get secs/mins/hours
    var time = getTime();
    var timeArray = time.split(":");
    var secs = parseInt(timeArray[2]);
    var mins = parseInt(timeArray[1]);
    var hours = parseInt(timeArray[0]);
    // Calculate total secs
    var totSecs = secs + mins*60 + hours*3600;
    // Calculate points
    var maxTimePoints = 4000;
    var timeCoeff = 6.66666;
    var points = maxTimePoints - totSecs*timeCoeff;
    if (points < 0) {points = 0;} // Do not allow points to be negative
    return points;
}
// Get total points
function getTotalPoints(rounds){
    var points = getTimePoints() + getRoundPoints(rounds);
    return Math.ceil(points);
}







