var selectedProject = -1;
$()
{
    $(".projectname").click(function () {

        $(".selected").removeClass("selected"); 
        showProject($(this).data("project-id"));
        $(this).addClass("selected"); 
    })

    showProject($(".projectname").first().data("project-id"));
    $(".projectname").first().addClass("selected");
    
    $(".user-checkbox").change(function() {

        var selectedUser = $(this).data("userId");

        if($(this).is(':checked')) {
            $.ajax({
                url: "../api/projects/employees/index.php",
                type: 'PUT',
                data: `{"projectId":"${selectedProject}", "userIds":[${selectedUser}]}`,
                success: function (data) {
                    /* hier kann eine Meldung stehen */
                }
            });
        }
        else {
            $.ajax({
                url: "../api/projects/employees/index.php",
                type: 'DELETE',
                data: `{"projectId":"${selectedProject}", "userIds":[${selectedUser}]}`,
                success: function (data) {
                    /* hier kann eine Meldung stehen */
                }
            });    
        }
    })

    function showProject (projectId) 
    {

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
}