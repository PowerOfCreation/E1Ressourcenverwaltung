/*eslint no-unused-vars: ["error", { "varsIgnorePattern": "(addStatus|handleProjectChange|changeCalendarWeek|deleteStatus)" }]*/

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

const $addProjectButton = $("<button onclick='addStatus()'>Status hinzufügen</button>");
const $addProjectSelect = $("<select onchange='handleProjectChange()' id='add-project-select'><option disabled selected value>Projekt auswählen</option></select>");
const $deleteProjectButton = $("<button onclick='deleteStatus($(this).parent())' id='delete-project-button'>X</button>");

function onWeekdayEnter() {
    $(this).append($addProjectButton);
}

function onWeekdayLeave() {
    $(this).children().find("button").detach();
}

function deleteStatus(element) {
    let $weekdayElement = $deleteProjectButton.parent().parent();
    let $employeeElement = $weekdayElement.parent();
    let employeeId = $employeeElement.attr("id");
    let date = $weekdayElement.attr("id");
    let projectId_userId = element.attr("class");
    let projectId = projectId_userId.split("_")[0];

    if (confirm("Möchtest du diesen Eintrag wirklich löschen?")) {
        $.get("api/delete_status.php?user=" + employeeId + "&project=" + projectId + "&date=" + date).done(function () {
            getDates(globalCalendarWeek);
            populateTable(globalCalendarWeek);
        });
    }
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

function handleProjectChange() {
    //get employee name and date
    let $weekdayElement = $addProjectSelect.parent();
    let $employeeElement = $weekdayElement.parent();
    let employeeId = $employeeElement.attr("id");
    let date = $weekdayElement.attr("id");

    //get selected projectId
    let projectId = $addProjectSelect.val();

    //Aufruf: /api/add_status.php?user=1&project=2&date=2022-04-25
    $.get("api/add_status.php?user=" + employeeId + "&project=" + projectId + "&date=" + date).done(function () {
        $addProjectSelect.detach();
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
    });
}

function changeCalendarWeek(change) {
    if (change == "+") {
        globalCalendarWeek++;
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
    } else if (change == "-") {
        globalCalendarWeek--;
        getDates(globalCalendarWeek);
        populateTable(globalCalendarWeek);
    }
}

function getCalendarWeek() {
    var res = null;
    $.ajax({
        url: "api/get_calendar_week.php",
        type: "GET",
        async: false,
        success: function (data) {
            res = jQuery.parseJSON(data);
        }
    });
    return res["calendarWeek"];
}

//calls api/get_calendar_week.php and fills the table with the data
function getDates(calendarWeek = globalCalendarWeek) {
    $.get("api/get_calendar_week.php?format=de&calendarWeek=" + calendarWeek).done(function (data) {
        const calendarWeek = jQuery.parseJSON(data);
        const elementNames = [
            "td-monday",
            "td-tuesday",
            "td-wednesday",
            "td-thursday",
            "td-friday",
        ];

        const heading = $("#h1-heading");
        heading.text("Einsatzplan - Übersicht KW " + calendarWeek["calendarWeek"]);

        for (let index = 0; index < elementNames.length; index++) {
            const element = $("#" + elementNames[index] + " p:first");
            const date = calendarWeek["weekdays"][index];
            element.text(date);
        }
    });
}

function populateTable(calendarWeek = globalCalendarWeek) {
    const elementNames = [
        ".td-entry-monday",
        ".td-entry-tuesday",
        ".td-entry-wednesday",
        ".td-entry-thursday",
        ".td-entry-friday",
    ];

    //get dates from get_calendar_week.php
    $.get("api/get_calendar_week.php?format=en&calendarWeek=" + calendarWeek).done(function (data) {
        const res = jQuery.parseJSON(data);

        //map dates as id
        res["weekdays"].map((element, index) => {
            $(elementNames[index]).empty()
            $(elementNames[index]).attr("id", element);
        });

        var year = res["year"];

        //get statuses from get_all_weekly_status.php
        $.get("api/get_all_weekly_status.php?&calendarWeek=" + calendarWeek + "&year=" + year).done(function (data) {
            const res = jQuery.parseJSON(data);

            //loop through all status entries
            res.map((status) => {
                //populate table with statuses
                let $newStatus = $("<div class='" + status['ProjectId'] + '_' + status['UserId'] + " status-wrapper-div' ><p id=" + status['ProjectId'] + '>Projekt: ' + status['ProjectName'] + '</p></div>').appendTo("#" + status['UserId'] + " > #" + status['Day']);
                $newStatus.mouseover(function() {
                    $(this).append($deleteProjectButton);
                });
            });
        });
    });
}

function setNotification(message) {
    const $notificationDiv = $("#notification-div");

    $notificationDiv.removeClass("hidden");
    $notificationDiv.text(message);
    $notificationDiv.delay(5000).queue(function () {
        $(this).hide();
    });
}

function showSuccessNotifications() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    const username = urlParams.get('registered_user');
    const project = urlParams.get('created_project');

    if (username) {
        setNotification(`Nutzer ${username} erfolgreich angelegt.`);

        urlParams.delete("registered_user");
    }
    else if (project) {
        setNotification(`Projekt ${project} erfolgreich angelegt.`);

        urlParams.delete("created_project");
    }

    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
}