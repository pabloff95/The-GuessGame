$(document).ready(function (){
    // ---- CHANGE PASSWORD ----
    // Matching passwords message
    $("#notMatchPasswords").hide();
    // Button to post form
    $("#changePass").prop("disabled",true);
    // Password events
    $("#newPass1, #newPass2").bind("input", function(){
        var pass1 = $("#newPass1").val();
        var pass2 = $("#newPass2").val();
        if (pass1== ""){
            $("#notMatchPasswords").hide();
            $("#changePass").prop("disabled",true);
        }
        else if (pass1 != pass2 && pass2 ==""){
            $("#notMatchPasswords").hide();
            $("#changePass").prop("disabled",true);
        }
        else if (pass1 != pass2){
            $("#notMatchPasswords").show();
            $("#changePass").prop("disabled",true);
        } else if (pass1 == pass2 && pass1!=""){
            $("#notMatchPasswords").hide();
            $("#changePass").prop("disabled",false);
        }
    });
    // Show / hide password buttons
    $("#seeOldPass").on("click", function (){
        seePass("oldPass", this.id);
    });
    $("#seeNewPass1").on("click", function (){
        seePass("newPass1", this.id);
    });
    $("#seeNewPass2").on("click", function (){
        seePass("newPass2", this.id);
    });

    // ---- CHANGE EMAIL ----
    // Matching emails message
    $("#notMatchEmails").hide();
    // Button to post form
    $("#changeEmail").prop("disabled",true);
    // Email events
    $("#newEmail1, #newEmail2").bind("input", function(){
        var email1 = $("#newEmail1").val();
        var email2 = $("#newEmail2").val();
        if (email1== ""){
            $("#notMatchEmails").hide();
            $("#changeEmail").prop("disabled",true);
        }
        else if (email1 != email2 && email2 ==""){
            $("#notMatchEmails").hide();
            $("#changeEmail").prop("disabled",true);
        }
        else if (email1 != email2){
            $("#notMatchEmails").show();
            $("#changeEmail").prop("disabled",true);
        } else if (email1 == email2 && email1!=""){
            $("#notMatchEmails").hide();
            $("#changeEmail").prop("disabled",false);
        }
    });
    // Show / hide password button (change email + delete account)
    $("#seePassEmail").on("click", function (){
        seePass("passEmail", this.id);
    });
    $("#seePassAcc").on("click", function (){
        seePass("passDeleteAcc", this.id);
    });
    
});

// Function to hide/show password
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