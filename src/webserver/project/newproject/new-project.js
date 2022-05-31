$()
{
    const registerForm = $("#register-form");
    const projectNameInput = $("#project-name-input");
    const projectOwnerSelect = $("#project-owner-select");
    const projectTopicTextarea = $("#project-topic-textarea");

    function checkInputValues()
    {
        if (projectNameInput.val() === "")
        {
            alert("Bitte gib einen Projektnamen ein.");
            return false;
        }

        if (projectOwnerSelect.val() === null)
        {
            alert("Bitte gib einen Projektverantwortlichen an.");
            return false;
        }

        if (projectTopicTextarea.val() === "")
        {
            alert("Bitte gib ein Projektthema ein.");
            return false;
        }

        return true;
    }

    registerForm.submit(function (event)
    {
        if (!checkInputValues())
        {
            event.preventDefault();
        }
    })
}