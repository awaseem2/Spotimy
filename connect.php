<?php
header('Content-Type: text/html; charset=utf8_general_ci');
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$q = $_GET["q"];
$q1 = $_GET["q1"];

$url = "<a href = \"user_index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
if ($q1 || count($q) === 0) {
    $q = $q1;
    $url = "<a href = \"index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>";
}

$attr = $_GET["attr"];
//$url = $_GET["attr"];
if($attr == "Song Name"){
    $sql = "SELECT s.Song_Name, a.Artist_Name, s.Song_ID as Song_ID
    FROM Song s
    INNER JOIN Artist a on s.Artist_ID = a.Artist_ID
    WHERE s.Song_Name LIKE '%$q%' ORDER BY s.Song_Name";
} else if($attr == "Artist Name"){
    $sql = "SELECT * FROM Song s1 inner join Artist a1 ON s1.Artist_ID = a1.Artist_ID WHERE a1.Artist_Name LIKE '%$q%'";
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
/*print("<table width=\"100%\" border=\"1\" cellpadding=\"10\">
    <tr>
        <td  align=\"center\">
        <h1>Songs</h1>
        </td>
    </tr> ");*/
print($url);
print("<table align=\"center\" style=\"width: 95%;\">
        <thead> ");
        $num_rows = $search_result->num_rows;
        if ($num_rows > 0){
            if ($num_rows === 1) {
            
                print("<br/><br/><h2 align=\"right\">There is " . $num_rows . " result available</h2>");
            } else {
                print("<br/><br/><h2 align=\"right\">There are " . $num_rows . " results available</h2>");
            }
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
            $result->free();
            print("</tbody>");
        } else {
            print("No songs found. <br/>");
        }
print("</table> <br/><br/>");
print("</body>");

$mysqli->close();

?>
