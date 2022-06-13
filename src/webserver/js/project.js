$()
{
    var selectedProject = -1;

    $(".projectname").click(function () {

        $(".selected").removeClass("selected");
        showProject($(this).data("project-id"));
        $(this).addClass("selected");
    })

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
    })
}

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
            $("#message-container").text("Projekt wurde erfolgreich gelöscht.");
        }).fail(function () {
            $("#message-container").text("Projekt konnte nicht gelöscht werden.");
        });
    } else {
        return;
    }
}

$("#btn-delete-project").click(function () {
    let projectId = $(".selected").data("project-id");
    deleteProject(projectId);
});

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