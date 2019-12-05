<?php
header('Content-Type: text/html; charset=ISO-8859-1');
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$attr = $_GET["attr"];
$attr1 = $_GET["attr1"];
$url = "<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
if (count($attr1) > 0) {
    $attr = $attr1;
    $url = "<a href = \"index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
}
if($attr == "Happy"){
    $sql = "SELECT s1.Song_Name, a1.Artist_Name, s1.Song_ID as Song_ID
    FROM Song s1 
    INNER JOIN Artist a1 ON s1.Artist_ID = a1.Artist_ID 
    WHERE (Song_valence > .5 AND Song_tempo > 100) OR (Song_danceability > .5 AND Song_energy > .5)
    ORDER BY rand()
    LIMIT 20";
} else if($attr == "Mad"){
    $sql = "SELECT s1.Song_Name, a1.Artist_Name, s1.Song_ID as Song_ID 
    FROM Song s1 
    INNER JOIN Artist a1 ON s1.Artist_ID = a1.Artist_ID
    WHERE (Song_valence < .5 AND Song_tempo > 110) OR Song_energy >= .75
    ORDER BY rand()
    LIMIT 20";
} else if($attr == "Sad"){
    $sql = "SELECT s1.Song_Name, a1.Artist_Name, s1.Song_ID as Song_ID 
    FROM Song s1 
    INNER JOIN Artist a1 ON s1.Artist_ID = a1.Artist_ID 
    WHERE (song_valence < .5 AND song_tempo < 100) OR (.3 < song_danceability < .5 AND song_energy < .5) OR song_acoustics > .4    
    ORDER BY rand()
    LIMIT 20";
} else if ($attr == "Excited") {
    $sql = "SELECT s1.Song_Name, a1.Artist_Name, s1.Song_ID as Song_ID 
    FROM Song s1 
    INNER JOIN Artist a1 ON s1.Artist_ID = a1.Artist_ID
    WHERE (song_valence > .5 AND song_tempo > 130) OR (song_danceability > .6 AND song_energy > .6)
    ORDER BY rand()
    LIMIT 20";
} else {
    $sql = "";
}
$search_result = $mysqli->query($sql);


print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/tablestyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");
print("<body>");
print("<div>");
print($url);
print("</div>");
print("<table align=\"center\" style=\"width: 95%;\">
        <thead> ");
        $num_rows = $search_result->num_rows;
        if ($num_rows > 0){
            if($attr == "Happy") {
                print("<br/><br/><h1 align=\"center\">Looks like you passed the vibe check. <br/> Here's some songs to keep those good vibes coming</h1>");
            } else if($attr == "Mad") {
                print("<br/><br/><h1 align=\"center\">Feels like the world is against you? <br/> Here's some songs to keep that fuel going</h1>");
            } else if($attr == "Sad") {
                print("<br/><br/><h1 align=\"center\">Keep that frown rightside down. <br/> Here's some sad boi hour songs</h1>");
            } else if ($attr == "Excited"){
                print("<br/><br/><h1 align=\"center\">Here's some songs to keep the party pumpin'</h1>");
            }
            print("<br/><br/><h2 align=\"right\">There are " . $num_rows . " results available</h2>");
            print("<tr>
                <th><h3>Song</h3></th>
				<th><h3>Artist</h3></th>
    			</tr>
    			</thead>
    			<tbody>
                ");
            while ($row = $search_result->fetch_assoc()){
                print("<tr>
                        <td><a href=\"spotify:track:{$row['Song_ID']}\"/ style=\"color:white;\">{$row['Song_Name']}</a></td>
                        <td> {$row['Artist_Name']} </td>
                        </tr>"
                        );
            }
            print("</tbody>");
        } else {
            print("Please recheck your searching criteria! <br\> <br> Thanks! <br/>");
        }
print("</table> <br/><br/>");
print("</body>");

$mysqli->close();

?>