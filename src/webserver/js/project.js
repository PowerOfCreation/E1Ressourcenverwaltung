$()
{
    $(".projectname").click(function () {
        $(".user-checkbox").each(function () {
            $(this).prop("checked", false);
        });
        $.get("../api/get_project_employees.php", { project: $(this).data("project-id") }).done(function (data) {
            let projectEmployees = jQuery.parseJSON(data);

            for (let index = 0; index < projectEmployees.length; index++) {
                const element = projectEmployees[index];
                $(".user-checkbox").each(function () {
                    if ($(this).data("userId") == element.userId) {
                        $(this).prop("checked", true);
                    }
                });
            }
        });
    });
}