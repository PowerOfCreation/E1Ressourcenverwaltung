<head>
    <link rel="stylesheet" href="mystyle.css">
</head>

<body>
    <?php
    //These are the defined authentication environment in the db service

    // The MySQL service named in the docker-compose.yml.
    $host = 'database';

    // Database use name
    $user = 'MYSQL_USER';

    //database user password
    $pass = 'MYSQL_PASSWORD';

    // check the MySQL connection status
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //echo "Connected to MySQL server successfully!";
    }
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
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="jquery-3.6.0.js"></script>
    <script src="js/weekly-report.js"></script>
</body>