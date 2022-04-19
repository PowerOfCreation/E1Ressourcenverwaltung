<head>
    <link rel="stylesheet" href="mystyle.css">
</head>

<body>
    <?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    //These are the defined authentication environment in the db service

    // The MySQL service named in the docker-compose.yml.
    include("/app/config/credentials.php");

    include("database_structure.php");

    ?>

    <div>
        <header>
            <h1>Einsatzplan - Übersicht</h1>
            <div id="div-search-weekly-report-wrapper">
                <input class="input-search" id="input-search-weekly-report" type="text" placeholder="Suchen..">
            </div>
        </header>
        <div>
            <div id="div-buttons-weekly-report-header">
                <button id="btn-edit-projects">Projekte verwalten</button>
                <button id="btn-add-employee">Mitarbeiter hinzufügen</button>
                <button id="btn-edit-holidays">Feiertage verwalten</button>
            </div>
            <div>
                <table id="table-weekly-report">
                    <thead>
                        <tr>
                            <td id="td-employee">Mitarbeiter</td>
                            <td id="td-monday">Montag</td>
                            <td id="td-tuesday">Dienstag</td>
                            <td id="td-wednesday">Mittwoch</td>
                            <td id="td-thursday">Donnerstag</td>
                            <td id="td-friday">Freitag</td>
                        </tr>
                    </thead>
                    <tbody id="tbody-employee-entries">
                        <?php
                        $result = $connection->query("SELECT * FROM User ORDER BY Username;");

                        while ($row = $result->fetch_object()) {
                            echo "<tr>";
                            echo "<td class='td-entry-employee' data-username='" . $row->Username . "'><a href='./mitarbeiter/?name=" . $row->Username . "'>" . $row->Forename . " " . $row->Surname . "</a></td>";
                            echo "<td class='td-entry-weekday td-entry-monday'></td>";
                            echo "<td class='td-entry-weekday td-entry-tuesday'></td>";
                            echo "<td class='td-entry-weekday td-entry-wednesday'></td>";
                            echo "<td class='td-entry-weekday td-entry-thursday'></td>";
                            echo "<td class='td-entry-weekday td-entry-friday'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="jquery-3.6.0.js"></script>
    <script src="js/weekly-report.js"></script>
</body>