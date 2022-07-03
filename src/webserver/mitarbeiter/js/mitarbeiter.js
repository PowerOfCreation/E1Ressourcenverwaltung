$("#btn-delete-user").click(function () {
    if (confirm("Möchten Sie diesen Mitarbeiter wirklich löschen?")) {
        deleteEmployee();
    }
});

/**
 * It gets the user's name from the URL, then sends a GET request to the server to delete the employee
 * with that name
 */
function deleteEmployee() {
    const urlParams = new URLSearchParams(window.location.search);
    const user = urlParams.get('name');

    $.get("/api/delete_employee.php?user=" + user).done(function () {
        window.location.href = "/";
    })
}