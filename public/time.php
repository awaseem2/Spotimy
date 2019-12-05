<?php

$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
    
$morning = $mysqli->query("SELECT COUNT(User_ID) FROM User WHERE Time > 500 AND Time < 1059 AND User_ID = '".$_POST["user2"]."'");
$row = mysqli_fetch_row($morning);
$morning_count = $row[0];

$afternoon = $mysqli->query("SELECT count(User_ID) FROM User WHERE Time > 1100 AND Time < 1459 AND User_ID = '".$_POST["user2"]."'");
$row1 = mysqli_fetch_row($afternoon);
$afternoon_count = $row1[0];

$midday = $mysqli->query("SELECT count(User_ID) FROM User WHERE Time > 1500 AND Time < 1859 AND User_ID = '".$_POST["user2"]."'");
$row2 = mysqli_fetch_row($midday);
$midday_count = $row2[0];

$night = $mysqli->query("SELECT count(User_ID) FROM User WHERE Time > 1900 AND Time < 2359 AND User_ID = '".$_POST["user2"]."'");
$row3 = mysqli_fetch_row($night);
$night_count = $row3[0];

$late_night = $mysqli->query("SELECT count(User_ID) FROM User WHERE Time < 500 AND User_ID = '".$_POST["user2"]."'");
$row4 = mysqli_fetch_row($late_night);
$late_night_count = $row4[0];

print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/tablestyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");
print("<body>");
print("<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>");
print("<br/>");

    $max_val = max($morning_count, $afternoon_count, $midday_count, $night_count, $late_night_count);
    if ($max_val === $morning_count){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">You mostly listen to music in the morning.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/sunrise.svg\" alt=\"sunrise icon\">");
        print("</div>");
        
    } else if ($max_val === $afternoon_count){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">You mostly listen to music in the afternoon.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/tea.svg\" alt=\"tea icon\">");
        print("</div>");
        
    } else if ($max_val === $midday_count){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">You mostly listen to music in the midday.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/sun.svg\" alt=\"sun icon\">");
        print("</div>");
        
    } else if ($max_val === $night_count){
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">You mostly listen to music in the night.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/cloudy-night.svg\" alt=\"night icon\">");
        print("</div>");
        
    } else if ($max_val === $late_night_count) {
        print("<div>");
        print("<h3 class = \"msg\" align=\"center\">You mostly listen to music late at night.</h3>");
        print("<img align = \"center\" class = \"img\" src = \"assets/images/midnight.svg\" alt=\"midnight icon\">");
        print("</div>");
        
    }
$mysqli->close();

?>
