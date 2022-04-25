$()
{
    const registrationForm = document.getElementById("registration-form");
    const passwordMessageSpan = document.getElementById("password-message-span");
    const passwordInput = registrationForm.elements["Password"];
    const confirmPasswordInput = registrationForm.elements["repeatPassword"];

    function setPasswordMessage(color, message) {
        passwordMessageSpan.style.color = color;
        passwordMessageSpan.innerHTML = message;
    }

    function repeatPw() {
        if (passwordInput.value == confirmPasswordInput.value) {
            setPasswordMessage("green", "Das Passwort stimmt überein.");
        }
        else {
            setPasswordMessage("red", "Das Passwort stimmt nicht überein.");
        }
    }
    function showPassword() {
        var pwVisibility = document.getElementById("passwordInput");
        if (pwVisibility.type === "password") {
            pwVisibility.type = "text";
        } else {
            pwVisibility.type = "password";
        }
      }

    
    //Popupfenster, falls genutzt wird, bedarf Regexp-Überarbeitung
    //Das ganze funktioniert in Chrome, aber nicht in Safari

    // function validatePassword() {
    //     var pw = document.getElementById('passwordInput').value,
    //     errors = [];
    //         if (pw.length < 8) {
    //     errors.push("Your password must be at least 8 characters"); 
    //     }
    //         if (pw.search(/[a-z]/i) < 0) {
    //     errors.push("Your password must contain at least one letter.");
    //     }
    //          if (pw.search(/[0-9]/) < 0) {
    //     errors.push("Your password must contain at least one digit."); 
    //     }
    //          if (errors.length > 0) {
    //           alert(errors.join("\n"));
    //           return false;
    //         }
    // return true;
    // }
    // function popupPassword() {
    //    alert("Mindestens 8 Zeichen, 1 Ziffer, 1 Großbuchstabe und 1 Sonderzeichen erforderlich.");
    //   }

};
