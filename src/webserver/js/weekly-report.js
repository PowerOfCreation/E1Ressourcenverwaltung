$()
{
    const $employeeEntries = $("#tbody-employee-entries");

    $employeeEntries.find(".td-entry-weekday").mouseenter(onWeekdayEnter);
    $employeeEntries.find(".td-entry-weekday").mouseleave(onWeekdayLeave);

    var globalCalendarWeek = getCalendarWeek();

    getDates();
    populateTable();
    showSuccessNotifications();
}

const $addProjectButton = $("<button onclick='addStatus();'>Status hinzufügen</button>");
const $addProjectSelect = $("<select id='add-project-select' onchange='handleProjectChange();'><option disabled selected value>Projekt auswählen</option></select>");

function onWeekdayEnter()
{
    if ($(this).find("#add-project-select").length == 0)
    {
        $(this).append($addProjectButton);
    }
}

function onWeekdayLeave()
{
    $addProjectButton.detach();
}

function addStatus()
{
    let $weekdayElement = $addProjectButton.parent();
    let $employeeElement = $weekdayElement.parent();

    $weekdayElement.append($addProjectSelect);

    $addProjectSelect.find("option").not(":first").remove();
    $addProjectSelect.prop('selectedIndex', 0);

    $addProjectButton.detach();

    let employeeUsername = $employeeElement.find(".td-entry-employee").data("username");

    $.get("api/get_employee_projects.php", { name: employeeUsername }).done(function (data)
    {
        let employeeProjects = jQuery.parseJSON(data);

        for (let index = 0; index < employeeProjects.length; index++)
        {
            const element = employeeProjects[index];
            $addProjectSelect.append(`<option value='${element["projectId"]}'>${element["projectName"]}</option>`);
        }
    });
}

function handleProjectChange()
{
    //get employee name and date
    let $weekdayElement = $addProjectSelect.parent();
    let $employeeElement = $weekdayElement.parent();
    let employeeId = $employeeElement.attr("id");
    let date = $weekdayElement.attr("id");

    //get selected projectId
    let projectId = $addProjectSelect.val();

    //Aufruf: /api/add_status.php?user=1&project=2&date=2022-04-25
    $.get("api/add_status.php?user=" + employeeId + "&project=" + projectId + "&date=" + date).done(function (data)
    {
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
        $addProjectSelect.detach();
    });
}

function changeCalendarWeek(change)
{
    if (change == "+")
    {
        globalCalendarWeek++;
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
    } else if (change == "-")
    {
        globalCalendarWeek--;
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
    }
}

function getCalendarWeek()
{
    var res = null;
    $.ajax({
        url: "api/get_calendar_week.php",
        type: "GET",
        async: false,
        success: function (data)
        {
            res = jQuery.parseJSON(data);
        }
    });
    return res["calendarWeek"];
}

//calls api/get_calendar_week.php and fills the table with the data
function getDates(calendarWeek = globalCalendarWeek)
{
    $.get("api/get_calendar_week.php?format=de&calendarWeek=" + calendarWeek).done(function (data)
    {
        const calendarWeek = jQuery.parseJSON(data);
        const elementNames = [
            "td-monday",
            "td-tuesday",
            "td-wednesday",
            "td-thursday",
            "td-friday",
        ];

        heading = $("#h1-heading");
        //clear text of heading
        heading.text("");
        week = "Einsatzplan - Übersicht KW " + calendarWeek["calendarWeek"];
        heading.text(week);

        for (let index = 0; index < elementNames.length; index++)
        {
            const element = $("#" + elementNames[index] + " p:first");
            const date = calendarWeek["weekdays"][index];
            element.text(date);
        }
    });
}

function populateTable(calendarWeek = globalCalendarWeek)
{
    const elementNames = [
        ".td-entry-monday",
        ".td-entry-tuesday",
        ".td-entry-wednesday",
        ".td-entry-thursday",
        ".td-entry-friday",
    ];

    //get dates from get_calendar_week.php
    $.get("api/get_calendar_week.php?format=en&calendarWeek=" + calendarWeek).done(function (data)
    {
        const res = jQuery.parseJSON(data);

        //map dates as id
        res["weekdays"].map((element, index) =>
        {
            $(elementNames[index]).empty()
            $(elementNames[index]).attr("id", element);
        });

        var year = res["year"];

        //get statuses from get_all_weekly_status.php
        $.get("api/get_all_weekly_status.php?&calendarWeek=" + calendarWeek + "&year=" + year).done(function (data)
        {
            const res = jQuery.parseJSON(data);

            //loop through all status entries
            res.map((status) =>
            {
                //populate table with statuses
                $('<p>Projekt: ' + status['ProjectName'] + '</p>').appendTo("#" + status['UserId'] + " > #" + status['Day']);
            });
        });
    });
}

function setNotification(message)
{
    const $notificationDiv = $("#notification-div");

    $notificationDiv.removeClass("hidden");
    $notificationDiv.text(message);
    $notificationDiv.delay(5000).queue(function ()
    {
        $(this).hide();
    });
}

function showSuccessNotifications()
{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    const username = urlParams.get('registered_user');
    const project = urlParams.get('created_project');

    if (username)
    {
        setNotification(`Nutzer ${username} erfolgreich angelegt.`);

        urlParams.delete("registered_user");
    }
    else if (project)
    {
        setNotification(`Projekt ${project} erfolgreich angelegt.`);

        urlParams.delete("created_project");
    }

    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
}