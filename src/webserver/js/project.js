$()
{
    $(".projectname").click(function () {
        $(".user-checkbox").each(function () {
            $(this).prop("checked", false);
            console.log($(this).data("user-id"));
        });
        $.get("../api/get_project_employees.php", { project: $(this).data("project-id") }).done(function (data) {
            let projectEmployees = jQuery.parseJSON(data);
            console.log(projectEmployees);

            for (let index = 0; index < projectEmployees.length; index++) {
                const element = projectEmployees[index];
                console.log(element.userId);
                $(".user-checkbox").each(function () {
                    if ($(this).data("userId") == element.userId) {
                        $(this).prop("checked", true);
                    }
                });
            }
        });
    });
}