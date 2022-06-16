<?php
    include("/app/config/credentials.php");

    if(!isset($_GET["user"])) {
        echo "Error: missing parameters";
        exit();
    }

    $user = htmlspecialchars($_GET["user"]);

?>