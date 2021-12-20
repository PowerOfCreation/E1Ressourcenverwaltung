<?php
/*if(*/$connection->query("
CREATE TABLE IF NOT EXISTS User(
UserId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
Username varchar(255) NOT NULL UNIQUE,
Forename varchar(255),
Surname varchar(255) NOT NULL,
DepartmentId int NOT NULL,
Email varchar(255) NOT NULL,
Password varchar(255) NOT NULL);"); /* === TRUE)
{
    echo "Successfully executed create table User";
}
else
{
    echo $connection->error;
}*/
?>