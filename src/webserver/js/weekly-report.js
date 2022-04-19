$()
{
  $addProjectButton = $(
    "<button onclick='addStatus();'>Status hinzufügen</button>"
  )
  $addProjectSelect = $(
    "<select id='add-project-select'><option disabled selected value>Projekt auswählen</option></select>"
  )

  $employeeEntries = $("#tbody-employee-entries")

  $employeeEntries.find(".td-entry-weekday").mouseenter(onWeekdayEnter)
  $employeeEntries.find(".td-entry-weekday").mouseleave(onWeekdayLeave)

  function addEmployee(employeeId, employeeName) {
    $employeeElement = $(` 
            <tr> \
                <td class="td-entry-employee">${employeeName}</td> \
                <td class="td-entry-weekday td-entry-monday"></td> \
                <td class="td-entry-weekday td-entry-tuesday"></td> \
                <td class="td-entry-weekday td-entry-wednesday"></td> \
                <td class="td-entry-weekday td-entry-thursday"></td> \
                <td class="td-entry-weekday td-entry-friday"></td> \
            </tr>`)

    $employeeElement.data("employeeId", employeeId)

    $employeeElement.find(".td-entry-weekday").mouseenter(onWeekdayEnter)
    $employeeElement.find(".td-entry-weekday").mouseleave(onWeekdayLeave)

    $employeeEntries.append($employeeElement)
  }

  function onWeekdayEnter() {
    if ($(this).find("#add-project-select").length == 0) {
      $(this).append($addProjectButton)
    }
  }

  function onWeekdayLeave() {
    $addProjectButton.detach()

    //$(this).find("#add-project-select").detach();
  }

  function addStatus() {
    let $weekdayElement = $addProjectButton.parent()
    let $employeeElement = $weekdayElement.parent()

    $weekdayElement.append($addProjectSelect)

    $addProjectSelect.find("option").not(":first").remove()
    $addProjectSelect.prop("selectedIndex", 0)

    $addProjectButton.detach()

    let employeeUsername = $employeeElement
      .find(".td-entry-employee")
      .data("username")

    $.get("api/get_employee_projects.php", { name: employeeUsername }).done(
      function (data) {
        let employeeProjects = jQuery.parseJSON(data)

        for (let index = 0; index < employeeProjects.length; index++) {
          const element = employeeProjects[index]

          $addProjectSelect.append(
            `<option value='${element["projectId"]}'>${element["projectName"]}</option>`
          )
        }
      }
    )
  }

  function onWeekdayClick() {
    $newProjectInput = $('<input type="text"></input>')

    $(this).append($newProjectInput)

    $newProjectInput.on("blur", addNewProject)
    $newProjectInput.on("keypress", function (e) {
      if (e.which === 13) $(this).trigger("blur")
    })

    $newProjectInput.select()
  }

  $("#btn-add-employee").click(function () {
    window.location.href = "registration"
  })

  $("#btn-edit-projects").click(function () {
    window.location.href = "project"
  })

  $("#btn-new-projects").click(function () {
    window.location.href = "project/newproject"
  })

  //calls api/get_calendar_week.php and fills the table with the data
  function getDates() {
    $.get("api/get_calendar_week.php").done(function (data) {
      const calendarWeek = jQuery.parseJSON(data)
      const elementNames = [
        "td-monday",
        "td-tuesday",
        "td-wednesday",
        "td-thursday",
        "td-friday",
        "td-saturday",
        "td-sunday",
      ]

      for (let index = 0; index <= elementNames.length; index++) {
        const element = document.getElementById(elementNames[index])
        const date = document.createTextNode(calendarWeek["weekdays"][index])
        element.appendChild(date)
      }
    })
  }

  document.addEventListener("DOMContentLoaded", function () {
    getDates()
  })
}
