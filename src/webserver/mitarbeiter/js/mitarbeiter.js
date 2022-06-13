function deleteEmployee() {
    const urlParams = new URLSearchParams(window.location.search);
    const user = urlParams.get('name');

    if (user) {
        $.get("/api/delete_employee.php?user=" + user).done(function () {
            window.location.href = "/";
        });
    }
}