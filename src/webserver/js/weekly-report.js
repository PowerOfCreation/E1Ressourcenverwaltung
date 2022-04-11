$()
{
    $employeeEntries = $("#tbody-employee-entries");
    console.log("Test1");
    $employeeEntries.find(".td-entry-weekday").click(onWeekdayClick);
    
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

        $employeeElement.find(".td-entry-weekday").click(onWeekdayClick);

        $employeeEntries.append($employeeElement);
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