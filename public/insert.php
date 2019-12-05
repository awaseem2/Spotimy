<?php

$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$fav_artist_sql = "INSERT INTO Artist (Artist_Name) VALUES ('".$_POST["fav_artist1"]."')";

if (count($_POST["fav_artist1"]) > 0) {
    $url = "<a href = \"index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
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

if (mysqli_query($mysqli, $fav_artist_sql) === TRUE) {
    print("<div>");
    print("<h3 class = \"msg\" align=\"center\">Successfully inserted Artist!</h3>");
    print("<img align=\"center\" class = \"img\" src = \"assets/images/fans.svg\" alt=\"fan icon\">");
    print("</div>");
    
} else {
    print("<h3 class = \"msg\" align=\"center\">The artist could not be inserted at this time. Please try again.</h3>");
    console.log(strval($conn->error));
}


$mysqli->close();

?>
