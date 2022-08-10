$(document).ready(function(){ 
    // PASSWORD VERIFICATION
    $("#passVerif").hide();
    if ($("#pass").length){
        var pass1 = $("#pass").val();
        var pass2 = $("#pass2").val();
        if (pass1 == pass2 && pass1.length == 0){
            $("#creatingButton").prop("disabled",true);
    }
    }
    // Text input in password 1
    $("#pass").bind("input", function() { 
        pass1 = $("#pass").val();
        pass2 = $("#pass2").val();       
        if (pass1 ==""){ // password 1 has not been filled: NOT OK
            $("#creatingButton").prop("disabled",true);
            $("#passVerif").hide();
        } else if (pass1 == pass2 && pass1 != ""){ // same password and password 1 is not empty: OK
            $("#passVerif").hide();
            $("#creatingButton").prop("disabled",false);
        } else if (pass1 != pass2 && pass1 != "" && pass2 != ""){ // different password, but both have been filled: NOT OK
            $("#passVerif").show();
            $("#creatingButton").prop("disabled",true);
        }
    });
    // Text input in password 2
    $("#pass2").bind("input", function() {
        pass1 = $("#pass").val();
        pass2 = $("#pass2").val();       
        if (pass1 != pass2 && pass1 !=""){ // different passwords and password 1 is not empty: NOT OK
            $("#passVerif").show();
            $("#creatingButton").prop("disabled",true);
            if (pass2 == ""){
                $("#passVerif").hide();
            }
        } else if (pass1 == pass2 && pass1 != ""){ // same password and password 1 not empty: OK
            $("#passVerif").hide();
            $("#creatingButton").prop("disabled",false);
        } else if (pass1 =="" && pass2 != ""){ // if password 1 is empty, but 2 is not: NOT OK
            $("#creatingButton").prop("disabled",true);
            $("#passVerif").show();
        } 
    });
    
    // SEE PASSWORD 
    $("#seePass").on("click", function(){
        seePass("pass", this.id);
    });
    $("#seePass2").on("click", function(){
        seePass("pass2", this.id);
    });
    $("#seeLogPass").on("click", function(){
        seePass("logPass", this.id);
    });

    // Consent checkbox while creating new user
    $("#consentError").hide();
    $("#loginForm").on("submit", function(event){
        // If exists the checkbox in the page (same form id displayed in different situations, according to user actions)
        if($("#consentCheckbox").length){
            if(!document.getElementById('consentCheckbox').checked) {
                event.preventDefault();
                $("#consentError").show();
            }
        }
    });
});

// Function to hide/show password (+ change icon picture accordingly)
function seePass(id, imgId){
    var pass = document.getElementById(id);    
    var img = document.getElementById(imgId);
    if (pass.type === "password"){
        img.src = '../resources/pictures/other/eyeOpen.svg';
        pass.type = "text";
    } else {
        img.src = '../resources/pictures/other/eyeClose.svg';
        pass.type = "password";        
    }
}