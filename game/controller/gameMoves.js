// This file controlls all the events related to the game colour-movements functionalities

$(document).ready(function(){ 
    $("#selectedColourContainer").hide(); // Hide colour selected img box by default (box indicating colour selected by the user)
    // Variables
    var color = ""; // used to clone color from the pallette    
    var lastClickBox; // used when there is reordering of the colors that are already in the round boxes
    var boxColor =""; // refers to colors (.color) that are already in the box (.box)
    document.body.style.cursor = "default";
    // On click on each color in pallette, clone the color (whole <div>)
    $(".color").on("click", function(){   
        color = "";         
        color = $(this).clone(); // Clone <div>        
        // change cursor        
        var colorId = color.find(".colorImg").attr("id"); // Get color URL
            // Change cursor according to whether the picture is for normal or blind color version
            var blind = $("#colorBlindButton").attr("value"); // color blind button value
            if (blind == "OFF"){
                var url = "/guessgame/resources/pictures/gamePage/cursors/resize" + colorId + ".png";
            } else if (blind == "ON"){
                var url = "/guessgame/resources/pictures/gamePage/cursors/blind/resize" + colorId + ".png";
            }
        document.body.style.cursor = "url('" + url + "'), pointer"; // Change cursor
        // Reset variables        
        lastClickBox ="";
        boxColor= ""; 
        parentColor2 = ""; 
        // Display selected colour on screen     
        displaySelectedColour();  
    });      
    // Paste colors in the round boxes (.box)
    $(document).on("click",".box", function(){        
        // When there is no reordering in the round boxes going on (normal situation)    
        if (boxColor == "") {             
            // if the color picked is not empty, remove elements from the box (allows adding the color, in case there were other color already inside)
            if (color != ""){
                $(this).empty();
                // Copy color in the box        
                color.appendTo($(this));        
                // Clean div (required to click again in the color panel)
                color= "";          
                // Return cursor to normal
                document.body.style.cursor = "default";
            }            
        } // if there is a reordering of the colors whithin the round boxes and  there is no color already in the new (round)box
        else if (boxColor != "" && $(this).text() === ""){                                    
            boxColor.appendTo($(this)); // add color
            lastClickBox.empty();       // clean former round box
            // restart variables                         
            boxColor= "";    
            // Return cursor to normal
            document.body.style.cursor = "default";           
        }        
        // Display selected colour on screen
        displaySelectedColour();
    });
    // When the box contains already a color and the user wants to reorder(move colors in round boxes to other boxes)
    $('.box').on( 'click', '.color', function(){                        
        // Case 1: no color change in the round boxes. It is the first click on the color. box. element (--> color1)
        if (boxColor == "" && color == ""){ // color == "", avoids entering in these conditionals, when clicking on a color in round box, after clicking in the pallette
            // Get color (.color)
            boxColor = $(this);              
            // Get parent of the color (.box)
            lastClickBox = $(this).parent();
            // change cursor        
            var colorId = boxColor.find(".colorImg").attr("id"); // Get color URL

                // Change cursor according to whether the picture is for normal or blind color version
                var blind = $("#colorBlindButton").attr("value"); // color blind button value
                if (blind == "OFF"){
                    var url = "/guessgame/resources/pictures/gamePage/cursors/resize" + colorId + ".png";
                } else if (blind == "ON"){
                    var url = "/guessgame/resources/pictures/gamePage/cursors/blind/resize" + colorId + ".png";
                }

            document.body.style.cursor = "url('" + url + "'), pointer"; // Change cursor
        }

        // Case 2: there is reordering of colors in the round boxes (--> 2nd click, on color 2 to change orer between color 1 and 2)
        else {                                    
            // Variables:
                //$(this) = color 2 (second click); parentColor2 = parent of color2
                //boxcolor = color 1 (first click); lastclickbox = parent of color1
            // Get parent of second clicked color            
            var parentColor2 = $(this).parent();
            // Empty parent of color1 and add there color 2
            if (lastClickBox != "") {
                lastClickBox.empty(); 
            }            
            $(this).appendTo(lastClickBox);
            // Now append color 1 into parent of color 2            
            boxColor.appendTo(parentColor2);                       
            // restart variables
            color = "";
            lastClickBox ="";
            boxColor= ""; 
            parentColor2 = "";
            // Return cursor to normal
            document.body.style.cursor = "default";                 
        }
        // Display selected colour on screen
        displaySelectedColour();
    });      
});


function displaySelectedColour(){
    // Get colour URL, according to mouse URL
    var cursorURL = document.body.style.cursor;
    cursorURL = cursorURL.substring(
        cursorURL.indexOf("\"") + 1, 
        cursorURL.lastIndexOf("\"")
    );
    // Change img src
    document.getElementById("selectedColour").src = cursorURL;        
    // Show / hide box containing the picture when a colour is selected (img with valid src -> contains "resize__.png")
    if (document.getElementById("selectedColour").src.includes("resize")){
        $("#selectedColourContainer").show();
    } else {
        $("#selectedColourContainer").hide();
    }
}




