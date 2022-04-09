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
};
