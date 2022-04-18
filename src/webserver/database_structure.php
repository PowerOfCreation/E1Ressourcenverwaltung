<?php

require_once("/app/config/credentials.php");

function execute_sql_query($connection, $queryString)
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
FOREIGN KEY(Projectowner) REFERENCES User(UserId))");/*  === TRUE)
{
    echo "Successfully executed create table Project";
}
else
{
    echo $connection->error;
}*/

/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS Status(
StatusId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
UserId int NOT NULL,
ProjectId int NOT NULL,
Day date NOT NULL,
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
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Ehrenpflaume', 'Kai', 'Pflaume', 1, 'k.pflaume@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('derBohle', 'Dieter', 'Bohlen', 1, 'd.bohlen@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Heidi', 'Heidi', 'Klum', 2, 'h.klum@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Raabinator', 'Stefan', 'Raab', 2, 's.raab@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Campino', 'Andreas', 'Frege', 3, 'a.frege@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('derKaptn', 'Florian', 'Silbereisen', 4, 'f.silbereisen@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Schweini', 'Bastian', 'Schweinsteiger', 3, 'b.schweinsteiger@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Poldi', 'Lukas', 'Poldoski', 2, 'l.podolski@mail.de', '123456');") ;
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Mutti', 'Angela', 'Merkel', 1, 'a.merkel@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('verdienterWeltmeister', 'Matze', 'Ginter', 1, 'm.ginter@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('IronMan', 'Toni', 'Stark', 3, 't.stark@mail.de', '123456');");
    $connection->query("Insert into User(Username, Forename, Surname, DepartmentId, Email, Password) Values('Spiderman', 'Peter', 'Parker', 2, 't.stark@mail.de', '123456');");
}

$result = $connection->query("SELECT count(*) from Project;");

if($result->fetch_array()[0] == 0)
{
    $connection->query("Insert into Project(ProjectName, ProjectOwner, Color, Topic, End) Values('Webentwicklung 3000', 1, 'ffffff', 'Entwicklung eines neuen Front-Ends.', '2023-01-01');");
}


$result = $connection->query("SELECT count(*) from User_Project;");

if($result->fetch_array()[0] == 0)
{
    $connection->query("Insert into User_Project(UserId, ProjectId) Values(1, 1);");
    $connection->query("Insert into User_Project(UserId, ProjectId) Values(5, 1);");
}

?>
