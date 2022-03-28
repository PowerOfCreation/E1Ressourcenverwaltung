<a href=".."><button>Zurück</button></a>

<?php
$username = htmlspecialchars($_GET["name"]);

if (!empty($username)) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    require_once("/app/config/credentials.php");

    $get_user_info_statement = $connection->prepare("SELECT Forename, Surname FROM User WHERE Username = ?;");

    $get_user_info_statement->bind_param('s', $username);

    if ($get_user_info_statement->execute()) {
        $get_user_info_statement->bind_result($forename, $surname);

        if ($row = $get_user_info_statement->fetch()) {
            echo $forename . " " . $surname;
        } else {
            echo "Es existiert kein Nutzer mit dem Nutzernamen " + $username;
        }
    }
} else {
    echo "Entschuldigung, dies hätte nicht passieren sollen.";
}
?>