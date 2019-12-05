<?php

$servername = "localhost";
$username = "spotimyapp_user1";
$password = "chiefonion212";
$dbname = "spotimyapp_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$url = "<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";

// sql to delete an artist
$sql = "DELETE FROM Artist WHERE lower(Artist_Name) LIKE lower('".$_POST["bad_artist"]."')";
$sql1 = "DELETE FROM Artist WHERE lower(Artist_Name) LIKE lower('".$_POST["bad_artist1"]."')";
if (count($_POST["bad_artist1"]) > 0) {
    $url = "<a href = \"index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
     $sql = $sql1;
}

print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/tablestyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");
print("<body>");

print($url);
print("<br/>");

$conn->query($sql);
if (mysqli_affected_rows($conn) == 0) {
print("<h3 class = \"msg\" align=\"center\">The artist could not be deleted at this time. Please try again.</h3>");
    console.log(strval($conn->error));
} else {
    print("<div>");
    print("<h3 class = \"msg\" align=\"center\">Record deleted successfully!</h3>");
    print("<img align = \"center\" class = \"img\" src = \"assets/images/conflict.svg\" alt=\"fan icon\">");
    print("</div>");
}

$conn->close();
?>
