$()
{
    var selectedProject = -1;

    $(".projectname").click(function () {

        $(".selected").removeClass("selected");
        showProject($(this).data("project-id"));
        $(this).addClass("selected");
    });

    $(".user-checkbox").change(function () {

        var selectedUser = $(this).data("userId");

        if ($(this).is(':checked')) {
            $.ajax({
                url: "../api/projects/employees/index.php",
                type: 'PUT',
                data: `{"projectId":"${selectedProject}", "userIds":[${selectedUser}]}`
            });
        }
        else {
            $.ajax({
                url: "../api/projects/employees/index.php",
                type: 'DELETE',
                data: `{"projectId":"${selectedProject}", "userIds":[${selectedUser}]}`
            });
        }
    });

    showSuccessNotifications();
}

/**
 * It deletes a project from the database
 * @param projectId - The id of the project to be deleted.
 * @returns nothing.
 */
function deleteProject(projectId) {
    $("#message-container").text("");
    if (projectId === undefined) {
        $("#message-container").text("Bitte wählen Sie zuerst ein Projekt aus.");
        return;
    }

    if (confirm("Soll das Projekt wirklich gelöscht werden?")) {
        $.ajax({
            url: "../api/projects/index.php",
            type: 'DELETE',
            data: `{"projectId":"${projectId}"}`
        }).done(function () {
            $(".selected").parent().detach();
            $("input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            })
            $("#message-container").text("Projekt wurde erfolgreich gelöscht.");
        }).fail(function (data) {
            $("#message-container").text(data.responseText);
        });
    } else {
        return;
    }
}

$("#btn-delete-project").click(function () {
    let projectId = $(".selected").data("project-id");
    deleteProject(projectId);
});

/**
 * It gets all the employees assigned to a project and checks the checkboxes of the employees in the
 * modal
 * @param projectId - The id of the project to show
 */
function showProject(projectId) {

    selectedProject = projectId;

    $(".user-checkbox").each(function () {
        $(this).prop("checked", false);
    });

    $.get("../api/get_project_employees.php", { project: projectId }).done(function (data) {

        var projectEmployees = jQuery.parseJSON(data);

        for (let index = 0; index < projectEmployees.length; index++) {

            const element = projectEmployees[index];

            $(".user-checkbox").each(function () {
                if ($(this).data("userId") == element.userId) {
                    $(this).prop("checked", true);
                }
            });
        }
    });
}

/**
 * It takes a message, shows it in the notification div, and then hides it after 5 seconds
 * @param message - The message to display in the notification.
 */
function setNotification(message) {
    const $notificationDiv = $("#notification-div");

    $notificationDiv.removeClass("hidden");
    $notificationDiv.text(message);
    $notificationDiv.delay(5000).queue(function () {
        $(this).hide();
    });
}

/**
 * If the URL contains a parameter called "created_project", then show a notification with the value of
 * that parameter
 */
function showSuccessNotifications() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    const project = urlParams.get('created_project');

    if (project) {
        setNotification(`Projekt ${project} erfolgreich angelegt.`);

        urlParams.delete("created_project");
    }

    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
}