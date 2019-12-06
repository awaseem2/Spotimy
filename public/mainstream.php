<?php
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$user_id = $mysqli->query("SELECT COUNT(s.Song_ID)
FROM Song s 
INNER JOIN Artist a ON s.Artist_ID = a.Artist_ID
INNER JOIN User u ON s.Song_ID = u.Song_ID
WHERE u.User_ID = '".$_POST["user"]."' AND a.Artist_Popularity > 80 AND 
s.Song_ID IN (SELECT u2.Song_ID FROM User u2 WHERE u2.User_ID <> u.Song_ID);");
$row1 = mysqli_fetch_row($user_id);
$basic_count = $row1[0];

$total = $mysqli->query("SELECT COUNT(s.Song_ID) FROM Song s JOIN User u ON u.Song_ID = s.Song_ID WHERE u.User_ID = '".$_POST["user"]."'");
$row2 = mysqli_fetch_row($total);
$total_count = $row2[0];

print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/tablestyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");
print("<body>");
print("<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>");
print("<br/>");

    $rank = $basic_count / $total_count;
    if ($rank >= .50){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">Your music taste is basic.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/yawning.svg\" alt=\"night icon\">");
        print("</div>");
    } else if($rank < .50){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">Your music taste is unique.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/rockandroll.svg\" alt=\"night icon\">");
        print("</div>");
    } else {
        print("<h3 class = \"msg\" align=\"center\">Please recheck your searching criteria!</h3>");
    }
$mysqli->close();
?>
