$(document).ready(function(){
    // On any key pressed, location moved to menu
    $("body").on("keypress", function() {
        location.replace('/guessgame/login/login.php');
    });   
    // On screen interaction (phones), location moved to menu
    $('body').on("touchstart", function(){ 
        location.replace('/guessgame/login/login.php');
    });

    // Show logo after the animation of the "Welcome (...)" text has ended
    $("#logo").hide(); // hide
    setTimeout(function(){$('#logo').fadeIn(1000);},3500); // show
});
