$("#btn-delete-user").click(function () {
    if (confirm("Möchten Sie diesen Mitarbeiter wirklich löschen?")) {
        deleteEmployee();
    }
});

function deleteEmployee() {
    const urlParams = new URLSearchParams(window.location.search);
    const user = urlParams.get('name');

    $.get("/api/delete_employee.php?user=" + user).done(function () {
        window.location.href = "/";
    })
}