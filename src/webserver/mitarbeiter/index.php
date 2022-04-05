<a href=".."><button>Zurück</button></a>

<?php

require_once("/app/config/credentials.php");

$username = htmlspecialchars($_GET["name"]);

if (!empty($username)) {
    $get_user_info_statement = $connection->prepare("SELECT Forename, Surname FROM User WHERE Username = ?;");

    $get_user_info_statement->bind_param('s', $username);

    if ($get_user_info_statement->execute()) {
        $get_user_info_statement->bind_result($forename, $surname);

        if ($row = $get_user_info_statement->fetch()) {
            echo $forename . " " . $surname . "<br>";
        } else {
            echo "Es existiert kein Nutzer mit dem Nutzernamen " + $username;
        }

        $get_user_info_statement->reset();
    }

    if(!($get_user_department_statement = $connection->prepare("SELECT DepartmentName FROM Department WHERE DepartmentId = (SELECT DepartmentId FROM User WHERE Username = ?);"))) {
        echo "Prepare failed " . $connection->error;
    }

    $get_user_department_statement->bind_param('s', $username);

    if ($get_user_department_statement->execute()) {

        $get_user_department_statement->bind_result($departmentName);

        if ($row = $get_user_department_statement->fetch()) {
            echo "Abteilung " . $departmentName;
        }

        $get_user_department_statement->reset();
    }

} else {
    echo "Entschuldigung, dies hätte nicht passieren sollen.";
}
?>