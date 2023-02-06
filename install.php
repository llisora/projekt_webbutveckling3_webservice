<?php
include_once("config.php");

//Connect to database
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die("Fel vid anslutning: " . $db->connect_error);
}

$sql = "DROP TABLE IF EXISTS food;";
$sql .= "
CREATE TABLE food(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    description TEXT NOT NULL,
    price INT(11) NOT NULL,
    type VARCHAR (128),
    categoryname INT(11) NOT NULL
);
";

$sql = "DROP TABLE IF EXISTS booking;";
$sql .= "
CREATE TABLE booking (
    id int(11) NOT NULL,
    name varchar(128) NOT NULL,
    time varchar(156) NOT NULL,
    date varchar(128) NOT NULL,
    quantity int(11) NOT NULL
);
";

$sql = "DROP TABLE IF EXISTS users;";
$sql .= "
CREATE TABLE users (
    id int(11) NOT NULL,
    username varchar(128) NOT NULL,
    password varchar(156) NOT NULL
);
";
 "<pre>$sql</pre>";

//Send SQL query to server
if ($db->multi_query($sql)) {
    echo "Tabell installerad!";
} else {
    echo "Fel vid installation av tabell...";
}
