<?php

require_once("/app/config/credentials.php");

/**
 * It executes a query on a database and returns a boolean value indicating whether the query was
 * successful or not
 * 
 * @param mysqli connection a mysqli connection object
 * @param string queryString The SQL query to execute.
 */
function execute_sql_query(mysqli $connection, string $queryString): void
{
    if($connection->query($queryString) === TRUE)
    {
        echo "successfully executed query";
    }
    else
    {
        echo $connection->error;
    }
}

/**
 * If the function is called, it will exit the script with a 500 HTTP response code and the message
 * passed to the function.
 * 
 * @param string message The message to display to the user.
 */
function exit_failure(string $message = ""): void
{
    http_response_code(500);
    exit($message);
}

/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS Department(
DepartmentId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
DepartmentName varchar(255) NOT NULL UNIQUE,
DepartmentColor varchar(255));"); /*=== TURE)
    {
        echo "Successfully executed create table Status";
    }
    else
    {
        echo "$connection->error";
    }
    */
/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS User(
UserId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
Username varchar(255) NOT NULL UNIQUE,
Forename varchar(255),
Surname varchar(255) NOT NULL,
DepartmentId int NOT NULL,
Email varchar(255) NOT NULL,
Password varchar(255) NOT NULL,
FOREIGN KEY(DepartmentId) REFERENCES Department(DepartmentId));"); /* === TRUE)
{
    echo "Successfully executed create table User";
}
else
{
    echo $connection->error;
}*/

/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS Project(
ProjectId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
ProjectName varchar(255) NOT NULL UNIQUE,
ProjectOwner int NOT NULL,
Color varchar(6),
Topic varchar(255),
End date,
FOREIGN KEY(ProjectOwner) REFERENCES User(UserId))");/*  === TRUE)
{
    echo "Successfully executed create table Project";
}
else
{
    echo $connection->error;
}*/

/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS Status(
UserId int NOT NULL,
ProjectId int NOT NULL,
Day date NOT NULL,
PRIMARY KEY(UserId, ProjectId, Day),
FOREIGN KEY(UserId) REFERENCES User(UserId),
FOREIGN KEY(ProjectId) REFERENCES Project(ProjectId));");/*  === TRUE)
{
    echo "Successfully executed create table Status";
}
else
{
    echo "$connection->error";
}*/

/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS User_Project(
UserId int NOT NULL,
ProjectId int NOT NULL,
PRIMARY KEY (UserId, ProjectId),
FOREIGN KEY(UserId) REFERENCES User(UserId),
FOREIGN KEY(ProjectId) REFERENCES Project(ProjectId));");/*  === TRUE)
{
    echo "Successfully executed create table Member";
}
else
{
    echo "$connection->error";
}*/

$result = $connection->query("SELECT count(*) from Department;");

if($result->fetch_array()[0] == 0)
{
    $connection->query("Insert into Department(DepartmentName, DepartmentColor) Values('Marketing', 'gelb');");
    $connection->query("Insert into Department(DepartmentName, DepartmentColor) Values('Vertrieb',  'blau');");
    $connection->query("Insert into Department(DepartmentName, DepartmentColor) Values('Personal',  'rot');");
    $connection->query("Insert into Department(DepartmentName, DepartmentColor) Values('Entwicklung','gruen');");
    $connection->query("Insert into Department(DepartmentName, DepartmentColor) Values('Produktion', 'violett');");
}

$result = $connection->query("SELECT count(*) from User;");

if($result->fetch_array()[0] == 0)
{
    $password_hash = password_hash("12345678!", PASSWORD_DEFAULT);
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Testnutzer', 'Testnutzer', 'Bitte Löschen', 1, '', '{$password_hash}');");
}

?>
