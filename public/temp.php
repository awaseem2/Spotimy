<?php
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$user_update = $mysqli->query("UPDATE `User` SET `Song_ID`= '".$_POST["userid"]."'
WHERE User_ID = 'admin'");
header('Location: https://spotimyapp.web.illinois.edu/user_index.html');
$mysqli->close();