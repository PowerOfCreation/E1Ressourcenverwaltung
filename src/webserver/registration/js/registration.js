/*eslint no-unused-vars: ["error", { "varsIgnorePattern": "showPassword" }]*/

/**
 * If the password input's type is "password", change it to "text", otherwise change it to "password"
 */
function showPassword()
{
    const passwordInput = $("#passwordInput").get(0);

    if (passwordInput.type === "password")
    {
        passwordInput.type = "text";
    }
    else
    {
        passwordInput.type = "password";
    }
}
