$(document).ready(function(){     
    $("#newPassVerif").hide();
    $("#passwordChanged").prop("disabled",true);
    // Text input in password 2
    $("#newPass2, #newPass").bind("input", function() {        
        var pass1 = $("#newPass").val();
        var pass2 = $("#newPass2").val();
        if (pass1 != pass2 && pass1 !=""){ // different passwords and password 1 is not empty: NOT OK
            $("#newPassVerif").show();
            $("#passwordChanged").prop("disabled",true);
            if (pass2 == ""){
                $("#newPassVerif").hide();
            }
        } else if (pass1 == pass2 && pass1 != ""){ // same password and password 1 not empty: OK
            $("#newPassVerif").hide();
            $("#passwordChanged").prop("disabled",false);
        } else if (pass1 =="" && pass2 != ""){ // if password 1 is empty, but 2 is not: NOT OK
            $("#passwordChanged").prop("disabled",true);
            $("#newPassVerif").show();
        } else if (pass1 =="" && pass2 == ""){ // if password 1 is empty, but 2 is not: NOT OK
            $("#passwordChanged").prop("disabled",true);
            $("#newPassVerif").hide();
        } 
    });
    // Show / hide password
    $("#seePassword1").on("click", function(){
        viewPassword("newPass", this.id);
    });
    $("#seePassword2").on("click", function(){
        viewPassword("newPass2", this.id);
    });
});

// Function to hide/show password
function viewPassword(id, imgId){
    var img = document.getElementById(imgId);
    var pass = document.getElementById(id);
    if (pass.type === "password"){
        pass.type = "text";
        img.src = '/guessgame/resources/pictures/other/eyeOpen.svg';
    } else {
        pass.type = "password";
        img.src = '/guessgame/resources/pictures/other/eyeClose.svg';
    }
}
