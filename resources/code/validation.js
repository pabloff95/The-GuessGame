// Form inputs text validation

$(document).ready(function() {
    $(".error").hide();   

    // ----------- CHANGE PASS FORMS (changepass.php) ------------
        // Form 1
    $("#changepassForm").on("submit", function(event){
        // Hide messages if they were present
        $(".error").hide();
        // Validate email input
        var validateMail = validateEmail($("#emailInput").val());
        if (!validateMail){ // When email does not match with the pattern, form is not submited and message prompts
            event.preventDefault();
        }
        // Check forbidden characters ("<", ">")
        var inputs = document.forms["changepassForm"].getElementsByTagName("input");
        for (const input of inputs){
            var checkCharacter = forbiddenChar(input.value);
            if (!checkCharacter){
                $("#characterError").show();
                event.preventDefault();
            }    
        }
    });
        // Form 2
    $("#changepassForm2").on("submit", function(event){
        // Hide messages if they were present
        $(".error").hide();
        // Check forbidden characters ("<", ">")
        var inputs = document.forms["changepassForm2"].getElementsByTagName("input");
        for (const input of inputs){
            var checkCharacter = forbiddenChar(input.value);
            if (!checkCharacter){
                $("#characterError").show();
                event.preventDefault();
            }    
        }
    });    
        // Form 3
    $("#changepassForm3").on("submit", function(event){
        // Hide messages if they were present
        $(".error").hide();
        // Check forbidden characters ("<", ">")
        var inputs = document.forms["changepassForm3"].getElementsByTagName("input");
        for (const input of inputs){
            var checkCharacter = forbiddenChar(input.value);
            if (!checkCharacter){
                $("#characterError").show();
                event.preventDefault();
            }    
        }
    });    
    // ----------- LOGIN FORMS (login.php) ------------
    $("#loginForm").on("submit", function(event){
    // Hide messages if they were present
        $(".error").hide();
        // Check forbidden characters ("<", ">")
        var inputs = document.forms["loginForm"].getElementsByTagName("input");
        for (const input of inputs){
            var checkCharacter = forbiddenChar(input.value);
            if (!checkCharacter){
                $("#characterError").show();
                event.preventDefault();
            }    
        }
        // Validate email input
        if ($("#emailInput").length){ // If element exists
            var validateMail = validateEmail($("#emailInput").val());
            if (!validateMail){ // When email does not match with the pattern, form is not submited and message prompts
                event.preventDefault();
        }
        }
    });
    // ----------- RANKING FORMS (ranks.php) ------------
    $("#rankingForm").on("submit", function(event){
        $(".error").hide();
        // Check forbidden characters ("<", ">")
        var inputs = document.forms["rankingForm"].getElementsByTagName("input");
        for (const input of inputs){
            var checkCharacter = forbiddenChar(input.value);
            if (!checkCharacter){
                $("#characterError").show();
                event.preventDefault();
            }    
        }
    });   
    // ----------- ACCOUNT FORMS (account.php) ------------
    $("#accountForm1").on("submit", function(event){
        // Hide messages if they were present
            $(".error").hide();
            // Check forbidden characters ("<", ">")
            var inputs = document.forms["accountForm1"].getElementsByTagName("input");
            for (const input of inputs){
                var checkCharacter = forbiddenChar(input.value);
                if (!checkCharacter){
                    $("#characterError").show();
                    event.preventDefault();
                }    
            }
    }); 
    $("#accountForm2").on("submit", function(event){
        // Hide messages if they were present
            $(".error").hide();
            // Check forbidden characters ("<", ">")
            var inputs = document.forms["accountForm2"].getElementsByTagName("input");
            for (const input of inputs){
                var checkCharacter = forbiddenChar(input.value);
                if (!checkCharacter){
                    $("#characterError").show();
                    event.preventDefault();
                }    
            }
            // Validate email input
            var validateMail = validateEmail($("#newEmail1").val());
            if (!validateMail){ // When email does not match with the pattern, form is not submited and message prompts
                event.preventDefault();
            }
            validateMail = validateEmail($("#newEmail2").val());
            if (!validateMail){ // When email does not match with the pattern, form is not submited and message prompts
                event.preventDefault();
            }
    });
    $("#accountForm3").on("submit", function(event){
        // Hide messages if they were present
            $(".error").hide();
            // Check forbidden characters ("<", ">")
            var inputs = document.forms["accountForm3"].getElementsByTagName("input");
            for (const input of inputs){
                var checkCharacter = forbiddenChar(input.value);
                if (!checkCharacter){
                    $("#characterError").show();
                    event.preventDefault();
                }    
            }
    }); 
});
// Validate email format
function validateEmail(mail){
    if((/\S+@\S+\.\S+/).test(mail)){
        $("#emailError").hide();
        return true;
    } else {
        $("#emailError").show();
        return false;
    }
}
// Validate forbidden characters: user not allowed to introduce ">" and "<" in forms
function forbiddenChar(input){
    if (input.includes("<") || input.includes(">")){
        return false;
    } else {
        return true;
    }
}
