/*eslint no-unused-vars: ["error", { "varsIgnorePattern": "showPassword" }]*/

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
