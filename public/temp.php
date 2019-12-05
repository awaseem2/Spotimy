<?php
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

header('Location: https://spotimyapp.web.illinois.edu/user_index.html');
$mysqli->close();
