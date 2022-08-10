<?php
require $_SERVER['DOCUMENT_ROOT'] . "/guessgame/models/coreModel.php";

// Get table name (not SQL query, but used in all the SQL queries functions)
function getTable(){
    $diff = strtolower($_REQUEST['diff']);    
    return scape("rank" . $diff);
}

// Select all ranking classification
function getRanking(){
    // Connect to DB
    $db = connect();
    // table
    $table = getTable();
    // Query
    $sql_select = "SELECT name, points FROM ".$table;
    // Perform query
    $result = mysqli_query($db, $sql_select);
    mysqli_close($db);
    if (!mysqli_num_rows($result)) {
        return 1; // no rows found
    } else {
        return mysqli_num_rows($result); // returns number of rows found
    }    
}

// Obtain the specific rank values number ($nrank) per page 
function printRankingPage($nRanks){
    // Connect to DB
    $db = connect();
    // table
    $table = getTable();
    // Get the ranking (lower) range to be printed (ex.: from number 20th  to 30th)
    $lowLimit = ($_GET['page']-1)*$nRanks;  
    // Query
    $sql_select = $db->prepare("SELECT name, points FROM ".$table." ORDER BY points DESC LIMIT ?, ? ");
    $sql_select->bind_param("ii", $lowLimit, $nRanks);
    $sql_select->execute();
    $result = $sql_select->get_result();
    // Close
    $sql_select->close();
    mysqli_close($db);   

    return $result;
}

// Select specific name rank
function getNameRank($name){
    // Connect to DB
    $db = connect();
    // table
    $table = getTable();
    // Query    
    $sql_select = "SELECT name FROM ".$table." ORDER BY points DESC";    
    // Perform query
    $result = mysqli_query($db, $sql_select);
    mysqli_close($db);
    $rank = 0;
    while ($row = mysqli_fetch_assoc($result)){                
        $rank++;
        if ($row['name'] == $name){
            return $rank;
        }
    }
}

// Print rank of name selected
function getRankRange($name, $totalDisplayed, $maxRanks){
    // Get rank of selected name
    $userRank = getNameRank($name);          
    // Query range (number of rows displayed ($totalDisplayed), selected name will be highlited in the middle)
    $lower = $userRank - ($totalDisplayed/2);     // Lower limit of the query
    if ($userRank <=$totalDisplayed) { // rank in the top (first page), display from the begining (nr.1)
        $lower = 0;        
    }
    else if (($lower + $totalDisplayed)>$maxRanks){ // rank in the last part of the rank, display last 10 positions
        $lower = $maxRanks - $totalDisplayed;
    }
    // table
    $table = getTable();
    // Query
    $db = connect();
    $sql_select = $db->prepare("SELECT * FROM ".$table." ORDER BY points DESC LIMIT ?, ?");
    $sql_select->bind_param("ii", $lower, $totalDisplayed);
    $sql_select->execute();
    $result = $sql_select->get_result();
    // Close    
    $sql_select->close();
    mysqli_close($db);  

    return $result;
}


?>