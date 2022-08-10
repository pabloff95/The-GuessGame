<?php

// Fill table with data from all ranked players in the DB
function printNames($nRanks){
    // Get query results
    $result = printRankingPage($nRanks);    
    
    // Print query
    if (!mysqli_num_rows($result)) { // no rows found
        echo "<tr><td colspan='3'>No records available</td></tr>"; 
        for ($i = 0; $i < 9; $i++){
            echo    "<tr><td> &nbsp; </td><td> &nbsp; </td><td> &nbsp; </td></tr>";
        }
        return false;

    } else {
       // Print ranks in selected range
       $rank = ($_GET['page']-1)*$nRanks;   // Used to calculate the rank (gets the lower limit of the page)
       $counter = 0; // used in next while loop
        while ($row = mysqli_fetch_assoc($result)){
            $rank++;
            $counter++;
            echo    "<tr>
                        <td>". $rank ."</td>
                        <td>". scape($row['name']) ."</td>
                        <td>". scape($row['points'])."</td>
                    </tr>";
        }
        // if the query did not contain 10 rows, then prints white spaces, so the table size does not change
        while ($counter <10){
            $counter++;
            echo    "<tr>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                    </tr>";
        }
    }
    return true;
}


// Print data when searching an specific user (by user name)
function findRank($name, $totalDisplayed, $maxRanks)   {
    $name = scape($name); // scape data introduced by user
    // Get rank of selected name
    $userRank = getNameRank($name);
    // Get lower rank displayed (here +1 is needed) 
    $lower = $userRank - ($totalDisplayed/2 -1);
    if ($userRank <=$totalDisplayed) { // rank in the first top half, display from the begining (nr.1)
        $lower = 0;        
    }
    else if (($lower + $totalDisplayed)>$maxRanks){ // rank in the last bottom half, display last 10 positions
        $lower = $maxRanks - $totalDisplayed;
    }
    // Get rank range (to display 10 in the screen)
    $result = getRankRange($name, $totalDisplayed, $maxRanks);
    // Print rank on screen
    if ($userRank!= "") { // In case the name selected is not in the DB
        while ($row = mysqli_fetch_assoc($result)){
            $lower++;
            if ($row['name'] != $name){
            echo    "<tr>
                        <td>". $lower ." </td>
                        <td>". scape($row['name']) ."</td>
                        <td>". scape($row['points']) ."</td>
                    </tr>";
            } else if ($row['name'] == $name) {
            echo    "<tr>
                        <td class='userField'> ". $lower ." </td>
                        <td class='userField'>". scape($row['name']) ."</td>
                        <td class='userField'>". scape($row['points']) ."</td>
                    </tr>";
            }            
        }
    } else { // When name selected is not in the DB
        echo "<tr> <td colspan='3'> Name not found </td> </tr> ";
        // Complete table with 9 empty rows (keep height proportion)
        for ($i = 0; $i<9; $i++) {
            echo    "<tr>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                    </tr>";
        };
    }
}

// Change difficulty tables 
function changeDiffEasier(){ // to easier
    $diff = $_REQUEST['diff'];
    switch ($diff){
        case "easy":
            echo "ranks.php?page=1&diff=easy";
            break;
        case "medium":
            echo "ranks.php?page=1&diff=easy";
            break;
        case "hard":
            echo "ranks.php?page=1&diff=medium";
            break;
        case "extreme":
            echo "ranks.php?page=1&diff=hard";
            break;
    }
}
function changeDiffHarder(){ // to harder
    $diff = $_REQUEST['diff'];
    switch ($diff){
        case "easy":
            echo "ranks.php?page=1&diff=medium";
            break;
        case "medium":
            echo "ranks.php?page=1&diff=hard";
            break;
        case "hard":
            echo "ranks.php?page=1&diff=extreme";
            break;
        case "extreme":
            echo "ranks.php?page=1&diff=extreme";
            break;
    }
}















?>