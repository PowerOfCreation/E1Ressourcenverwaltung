$()
{
    $addProjectButton = $("<button onclick='addStatus();'>Status hinzufügen</button>");
    $addProjectSelect = $("<select id='add-project-select'><option>Marketing</option></select>");

    $employeeEntries = $("#tbody-employee-entries");

    $employeeEntries.find(".td-entry-weekday").mouseenter(onWeekdayEnter);
    $employeeEntries.find(".td-entry-weekday").mouseleave(onWeekdayLeave);

    function addEmployee(employeeId, employeeName) {
        $employeeElement = $(` 
            <tr> \
                <td class="td-entry-employee">${employeeName}</td> \
                <td class="td-entry-weekday td-entry-monday"></td> \
                <td class="td-entry-weekday td-entry-tuesday"></td> \
                <td class="td-entry-weekday td-entry-wednesday"></td> \
                <td class="td-entry-weekday td-entry-thursday"></td> \
                <td class="td-entry-weekday td-entry-friday"></td> \
            </tr>`);

        $employeeElement.data("employeeId", employeeId);

        $employeeElement.find(".td-entry-weekday").mouseenter(onWeekdayEnter);
        $employeeElement.find(".td-entry-weekday").mouseleave(onWeekdayLeave);

        $employeeEntries.append($employeeElement);
    }

    function onWeekdayEnter() {
        if($(this).find("#add-project-select").length == 0)
        {
            $(this).append($addProjectButton);
        }
    }

    function onWeekdayLeave() {
        $addProjectButton.detach();

        //$(this).find("#add-project-select").detach();
    }

    function addStatus()
    {
        let $weekdayElement = $addProjectButton.parent();
        let $employeeElement = $weekdayElement.parent();

        $weekdayElement.append($addProjectSelect);

        $addProjectButton.detach();

        let employeeUsername = $employeeElement.find(".td-entry-employee").data("username");

        // todo ajax to get all projects this employee is currently in
    }

    function onWeekdayClick() {
        $newProjectInput = $('<input type="text"></input>');
        
        $(this).append($newProjectInput);

        $newProjectInput.on('blur', addNewProject);
        $newProjectInput.on('keypress', function (e) {
            if (e.which === 13) $(this).trigger('blur');
        });

        $newProjectInput.select();
    }
    function addNewProject() {
        $(this).parent().append($(`<span class="span-project">${$(this).val()}</span>`));
        $(this).remove();
    }
   
    $("#btn-add-employee").click(function () {
        window.location.href = "registration";
    });

    $("#btn-edit-projects").click(function () {
        window.location.href = "project";
    });
}