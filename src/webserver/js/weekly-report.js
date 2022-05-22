$()

{
    $addProjectButton = $("<button onclick='addStatus();'>Status hinzufügen</button>");
    $addProjectSelect = $("<select id='add-project-select' onchange='handleProjectChange();'><option disabled selected value>Projekt auswählen</option></select>");

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
        if ($(this).find("#add-project-select").length == 0) {
            $(this).append($addProjectButton);
        }
    }

    function onWeekdayLeave() {
        $addProjectButton.detach();

        //$(this).find("#add-project-select").detach();
    }

    function addStatus() {
        let $weekdayElement = $addProjectButton.parent();
        let $employeeElement = $weekdayElement.parent();

        $weekdayElement.append($addProjectSelect);

        $addProjectSelect.find("option").not(":first").remove();
        $addProjectSelect.prop('selectedIndex', 0);

        $addProjectButton.detach();

        let employeeUsername = $employeeElement.find(".td-entry-employee").data("username");

        $.get("api/get_employee_projects.php", { name: employeeUsername }).done(function (data) {
            let employeeProjects = jQuery.parseJSON(data);

            for (let index = 0; index < employeeProjects.length; index++) {
                const element = employeeProjects[index];
                $addProjectSelect.append(`<option value='${element["projectId"]}'>${element["projectName"]}</option>`);
            }
        });
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

    $("#btn-add-employee").click(function () {
        window.location.href = "registration";
    });

    $("#btn-edit-projects").click(function () {
        window.location.href = "project";
    });

    function handleProjectChange() {
        //get employee name and date
        let $weekdayElement = $addProjectSelect.parent();
        let $employeeElement = $weekdayElement.parent();
        let employeeId = $employeeElement.attr("id");
        let date = $weekdayElement.attr("id");

        //get selected projectId
        let projectId = $addProjectSelect.val();

        //Aufruf: /api/add_status.php?user=1&project=2&date=2022-04-25
        $.get("api/add_status.php?user=" + employeeId + "&project=" + projectId + "&date=" + date).done(function (data) {
            document.location.reload(true);
        });
    }

    //calls api/get_calendar_week.php and fills the table with the data
    function getDates() {
        $.get("api/get_calendar_week.php?format=de").done(function (data) {
            const calendarWeek = jQuery.parseJSON(data);
            const elementNames = [
                "td-monday",
                "td-tuesday",
                "td-wednesday",
                "td-thursday",
                "td-friday",
            ];

            heading = document.getElementById("h1-heading");
            week = document.createTextNode(calendarWeek["calendarWeek"]);
            heading.appendChild(week);

            for (let index = 0; index < elementNames.length; index++) {
                const element = document.getElementById(elementNames[index]);
                const date = document.createTextNode(
                    calendarWeek["weekdays"][index]
                );
                element.appendChild(date);
            }
        });
    }

    function populateTable() {
        const elementNames = [
            ".td-entry-monday",
            ".td-entry-tuesday",
            ".td-entry-wednesday",
            ".td-entry-thursday",
            ".td-entry-friday",
        ];

        //get dates from get_calendar_week.php
        $.get("api/get_calendar_week.php").done(function (data) {
            const res = jQuery.parseJSON(data);
            //map dates as id
            res["weekdays"].map((element, index) => {
                $(elementNames[index]).attr("id", element);
            })

            var calendarWeek = res["calendarWeek"];
            var year = res["year"];

            //get statuses from get_all_weekly_status.php
            $.get("api/get_all_weekly_status.php?calendarWeek=" + calendarWeek + "&year=" + year).done(function (data) {
                const weeklyStatus = jQuery.parseJSON(data);

                //loop through all status entries
                weeklyStatus.map((status) => {
                    //populate table with statuses
                    $('Projekt: ' + status['ProjectName'] + '</p>').appendTo("#" + status['UserId'] + " > #" + status['Day']);
                });
            });
        });

    }

    getDates();
    populateTable();
}