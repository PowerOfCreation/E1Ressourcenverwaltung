/*eslint no-unused-vars: ["error", { "varsIgnorePattern": "(addStatus|handleProjectChange|changeCalendarWeek|deleteStatus)" }]*/

$()
/* A function that is called when the page is loaded. */
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

/**
 * When the user enters a weekday, append the add project button to the weekday
 */
function onWeekdayEnter() {
    $(this).append($addProjectButton);
}

/**
 * When the user leaves a weekday, remove the button that was added to the weekday
 */
function onWeekdayLeave() {
    $(this).children().find("button").detach();
}

/**
 * It deletes a status from the database
 * @param element - the element that was clicked on
 */
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

/**
 * When the user clicks the "Add Status" button, the function removes the button and replaces it with a
 * dropdown menu of projects that the employee is assigned to
 */
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

/**
 * It gets the employee id and date from the DOM, gets the selected project id from the DOM, and then
 * calls the API to add the status
 */
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

/**
 * It changes the week of the calendar
 * @param change - "+" or "-"
 */
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

/**
 * It sends a GET request to the server, waits for the response, and returns the response
 * @returns The current calendar week.
 */
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

/**
 * It gets the dates of the current calendar week and displays them in the table
 * @param [calendarWeek] - The calendar week you want to get the dates for.
 */
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

/**
 * It gets all the dates of the current week from the database, then it gets all the status entries of
 * the current week from the database and then it populates the table with the status entries
 * @param [calendarWeek] - The week number of the calendar week you want to populate.
 */
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
 * If the URL contains a parameter called registered_user, then show a notification with the value of
 * that parameter
 */
function showSuccessNotifications() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    const username = urlParams.get('registered_user');

    if (username) {
        setNotification(`Nutzer ${username} erfolgreich angelegt.`);

        urlParams.delete("registered_user");
    }

    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
}