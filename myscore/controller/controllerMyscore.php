<?php
// CONSTANTS (used to define table styles)
define("NO_DATA", "-"); // Printed when there is no information to display of the user
define ("N_DECIMALS", 2); // Number of decimals displayed (Avg. rounds, Avg. points)
define("EASY", "easy"); // Table name - difficulty easy
define("MEDIUM", "medium"); // Table name - difficulty medium
define("HARD", "hard"); // Table name - difficulty hard
define("EXTREME", "extreme"); // Table name - difficulty extreme

// ---------------------------------------------------------------------------
// ----------------------------PRINT TABLE ROWS ------------------------------
// ---------------------------------------------------------------------------

// All functions required to print the table values (obtained from the DB by the model (modelMyscore.php))

// Print number of games
function printGames($user){
    echo "<tr>
            <th>GAMES</th>
            <td>". scape(getGames($user, EASY))    ."</td>
            <td>". scape(getGames($user, MEDIUM))  ."</td>
            <td>". scape(getGames($user, HARD))    ."</td>
            <td>". scape(getGames($user, EXTREME)) ."</td>
          </tr>";
}

// Print number of victories
function printVictories($user){
    echo "<tr>
            <th>VICTORIES</th>
            <td>". scape(getVictories($user, EASY))    ."</td>
            <td>". scape(getVictories($user, MEDIUM))  ."</td>
            <td>". scape(getVictories($user, HARD))    ."</td>
            <td>". scape(getVictories($user, EXTREME)) ."</td>
          </tr>";
}

// Print win ratio
function printWinRatio($user){
    echo "<tr>
            <th>WIN RATIO</th>
            <td>". scape(getWR($user, EASY))     ."</td>
            <td>". scape(getWR($user, MEDIUM))   ."</td>
            <td>". scape(getWR($user, HARD))     ."</td>
            <td>". scape(getWR($user, EXTREME))  ."</td>
          </tr>";
}

// Print best time
function printBestTime($user){
    echo "<tr>
            <th>BEST TIME</th>
            <td>&nbsp;". scape(getBestTime($user, EASY))    ."&nbsp;</td>
            <td>&nbsp;". scape(getBestTime($user, MEDIUM))  ."&nbsp;</td>
            <td>&nbsp;". scape(getBestTime($user, HARD))    ."&nbsp;</td>
            <td>&nbsp;". scape(getBestTime($user, EXTREME)) ."&nbsp;</td>
          </tr>";
}
// Average number of rounds per game
function printAvgRound($user){
    echo "<tr>
            <th>AVG. ROUNDS&nbsp;</th>
            <td>". scape(getAvgRounds($user, EASY))    ."</td>
            <td>". scape(getAvgRounds($user, MEDIUM))  ."</td>
            <td>". scape(getAvgRounds($user, HARD))    ."</td>
            <td>". scape(getAvgRounds($user, EXTREME)) ."</td>
          </tr>";
}

// Average number of points per game
function printAvgPoints($user){
    echo "<tr>
            <th>AVG. POINTS&nbsp;</th>
            <td>". scape(getAvgPoints($user, EASY))    ."</td>
            <td>". scape(getAvgPoints($user, MEDIUM))  ."</td>
            <td>". scape(getAvgPoints($user, HARD))    ."</td>
            <td>". scape(getAvgPoints($user, EXTREME)) ."</td>
          </tr>";
}

// Average user rank in rankings
function printRanking($user){
    echo "<tr>
            <th>RANKING</th>
            <td>". scape(getRank($user, "rankeasy"))    ."</td>
            <td>". scape(getRank($user, "rankmedium"))  ."</td>
            <td>". scape(getRank($user, "rankhard"))    ."</td>
            <td>". scape(getRank($user, "rankextreme")) ."</td>
          </tr>";
}

?>