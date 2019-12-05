<?php
header('Content-Type: text/html; charset=utf8_general_ci');
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$top_genre = "SELECT genre_name, genre_count
FROM (SELECT s.Song_Genre genre_name, COUNT(s.Song_Genre) genre_count 
FROM Song s 
INNER JOIN User u
ON u.Song_ID = s.Song_ID 
WHERE u.User_ID = '".$_POST["user"]."'
GROUP BY genre_name 
ORDER BY genre_count ) as song_genre 
GROUP BY genre_name 
HAVING MAX(genre_count) 
ORDER BY MAX(genre_count) DESC";

$top_artist = "SELECT a.Artist_Name as Artist_Name, a.Artist_Genre as Artist_Genre, a.Artist_Popularity as Artist_Popularity, COUNT(a.Artist_ID) as artist_count
FROM Artist a
INNER JOIN Song s ON a.Artist_ID = s.Artist_ID
INNER JOIN User u ON s.Song_ID = u.Song_ID
WHERE u.User_ID = '".$_POST["user"]."'
GROUP BY a.Artist_Name 
ORDER BY artist_count DESC
LIMIT 10";

$top_album = "SELECT a.Album_Name as Album_Name, COUNT(a.Album_ID) as album_count
FROM Album a
INNER JOIN Song s ON a.Album_ID = s.Album_ID
INNER JOIN User u ON s.Song_ID = u.Song_ID
WHERE u.User_ID = '".$_POST["user"]."' 
GROUP BY a.Album_ID 
ORDER BY album_count DESC
LIMIT 5";

$search_result = $mysqli->query($top_genre);
$sec = $mysqli->query($top_artist);
$third = $mysqli->query($top_album);

print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/tablestyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");
print("<body>");

print("<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>");

print("<table align=\"center\" style=\"width: 95%;\">
        <thead> ");
    $num_rows = $search_result->num_rows;
    if ($num_rows > 0){
        print("<br/><br/><h1 align=\"center\">Top Genres</h1>");
        if ($num_rows === 1) {
            print("<h2 align=\"right\">There is " . $num_rows . " result available</h2>");
        } else {
            print("<h2 align=\"right\">There are " . $num_rows . " results available</h2>");
        }
        
        print("<tr>
                <th><h3>Genre</h3></th>
    			</tr>
    			</thead>
    			<tbody>
                ");
        
        while ($row = $search_result->fetch_assoc()){
            print("<tr>
                        <td>{$row['genre_name']}</td>
                        </tr>"
                        );
        }
        print("</tbody>");
     } else {
        print("Please recheck your searching criteria!<br\><br> Thanks! <br/>");
    }
print("</table> <br/><br/>");

print("<table align=\"center\" style=\"width: 95%;\">
        <thead> 
                    </form>");
    $num_rows = $search_result->num_rows;
    if ($num_rows > 0){
        print("<br/><br/><h1 align=\"center\"><a href = \"chart.php\">Top 10 Artists</a></h1>");
        
        print("<tr>
                <th><h3>Artist Name</h3></th>
                <th><h3>Main Genre</h3></th>
                <th><h3>Popularity /100</h3></th>
    			</tr>
    			</thead>
    			<tbody>
                ");
                
        $first = true;
        while ($row = $sec->fetch_assoc()){
            if ($first) {
                $top_artist = $row['Artist_Name'];
                $first = false;
            }
            print("<tr>
                        <td>{$row['Artist_Name']}</td>
                        <td>{$row['Artist_Genre']}</td>
                        <td>{$row['Artist_Popularity']}</td>
                        </tr>"
                        );
        }
        print("</tbody><form method=\"post\" action=\"chart.php\">
    <input type=\"hidden\" name=\"top_artist\" value=$top_artist>
</form>");
     } else {
        print("Please recheck your searching criteria!<br\><br> Thanks! <br/>");
    }
print("</table> <br/><br/>");
print("<form method=\"post\" action=\"chart.php\">
    <input type=\"hidden\" name=\"top_artist\" value=$top_artist>
    <input align = \"center\" class = \"submit\" type=\"submit\" name = \"submit\" value=\"Click here to find out your top artist's global popularity\" /><br/><br/>
</form>");

print("<table align=\"center\" style=\"width: 95%;\">
        <thead> ");
    $num_rows = $search_result->num_rows;
    if ($num_rows > 0){
        print("<br/><br/><h1 align=\"center\">Top 5 Albums</h1>");
        
        print("<tr>
                <th><h3>Album Name</h3></th>
    			</tr>
    			</thead>
    			<tbody>
                ");
        
        while ($row = $third->fetch_assoc()){
            print("<tr>
                        <td>{$row['Album_Name']}</td>
                        </tr>"
                        );
        }
        print("</tbody>");
     } else {
        print("Please recheck your searching criteria!<br\><br> Thanks! <br/>");
    }
print("</table> <br/><br/>");

print("</body>");
$mysqli->close();
?>
