<?php
header('Content-Type: text/html; charset=utf8_general_ci');
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$correct_username = $mysqli->query("SELECT COUNT(*) FROM User WHERE '".$_POST["user"]."' = (SELECT Song_ID FROM User WHERE User_ID = 'admin')");
$row0 = mysqli_fetch_row($correct_username);
$can_change = $row0[0];

if($can_change == 0){
 echo'
   <script>
   window.onload = function() {
      alert("Please enter your username.");
      location.href = "user_index.html";  
   }
   </script>
';
} else {

$proc = 
"DROP TABLE IF EXISTS last_playlist;
CREATE PROCEDURE recom AS
SELECT DISTINCT S1.Song_Name, A.Artist_Name INTO last_playlist
FROM Song S1 
INNER JOIN User U ON U.SONG_ID <> S1.Song_ID AND U.User_ID = '".$_POST["user"]."' 
INNER JOIN Artist A ON S1.Artist_ID = A.Artist_ID 
WHERE S1.Song_Genre = (SELECT genre_name
FROM (SELECT s.Song_Genre genre_name, COUNT(s.Song_Genre) genre_count 
FROM Song s 
UNION 
SELECT a.Artist_Genre genre_name, COUNT(a.Artist_Genre) genre_count 
FROM Artist a 
UNION 
SELECT b.Album_Genre genre_name, COUNT(b.Album_Genre) genre_count 
FROM Album b
GROUP BY genre_name 
ORDER BY genre_count ) as song_genre 
GROUP BY genre_name 
HAVING MAX(genre_count) 
ORDER BY MAX(genre_count) DESC LIMIT 1)
AND Song_Tempo BETWEEN (SELECT AVG(U.Song_Tempo) - 25 FROM Song) AND (SELECT AVG(Song_Tempo) + 25 FROM Song)
OR Song_Danceability BETWEEN (SELECT AVG(U.Song_Danceability) -.2 FROM Song) AND (SELECT AVG(Song_Danceability) +.2 FROM Song)
OR Song_Acoustics BETWEEN (SELECT AVG(U.Song_Acoustics) -.2 FROM Song) AND (SELECT AVG(Song_Acoustics) +.2 FROM Song)
OR Song_Energy BETWEEN (SELECT AVG(U.Song_Energy) -.2 FROM Song) AND (SELECT AVG(Song_Energy) +.2 FROM Song)
ORDER BY rand()
LIMIT 20
GO;
CREATE TRIGGER new_playlist ON last_playlist
AFTER INSERT
AS
IF (0 = SELECT COUNT(*) FROM new_playlist
    UNION 
    SELECT * FROM last_playlist
    EXCEPT 
    SELECT * FROM new_playlist
    INTERSECT
    SELECT * FROM last_playlist;) 
BEGIN
    EXEC recom
END;";

$rec = "SELECT DISTINCT S1.Song_Name, A.Artist_Name, S1.Song_ID as Song_ID 
FROM Song S1 
INNER JOIN User U ON U.SONG_ID <> S1.Song_ID AND U.User_ID = '".$_POST["user"]."'
INNER JOIN Artist A ON S1.Artist_ID = A.Artist_ID 
WHERE
S1.Song_Genre = (SELECT genre_name
FROM (SELECT s.Song_Genre genre_name, COUNT(s.Song_Genre) genre_count 
FROM Song s 
UNION 
SELECT a.Artist_Genre genre_name, COUNT(a.Artist_Genre) genre_count 
FROM Artist a 
UNION 
SELECT b.Album_Genre genre_name, COUNT(b.Album_Genre) genre_count 
FROM Album b
GROUP BY genre_name 
ORDER BY genre_count ) as song_genre 
GROUP BY genre_name 
HAVING MAX(genre_count) 
ORDER BY MAX(genre_count) DESC
LIMIT 1)
AND Song_Tempo BETWEEN (SELECT AVG(Song_Tempo) - 25 FROM Song) AND (SELECT AVG(Song_Tempo) + 25 FROM Song)
OR Song_Danceability BETWEEN (SELECT AVG(Song_Danceability) -.2 FROM Song) AND (SELECT AVG(Song_Danceability) +.2 FROM Song)
OR Song_Acoustics BETWEEN (SELECT AVG(Song_Acoustics) -.2 FROM Song) AND (SELECT AVG(Song_Acoustics) +.2 FROM Song)
OR Song_Energy BETWEEN (SELECT AVG(Song_Energy) -.2 FROM Song) AND (SELECT AVG(Song_Energy) +.2 FROM Song)
ORDER BY rand()
LIMIT 20";

$search_result = $mysqli->query($rec);

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
            print("<br/> <br/> <h1 align=\"center\">Here's some songs you may like!</h1>");
            print("<h2>There are " . $num_rows . " result(s) available</h2>");
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

}
$mysqli->close();

?>
