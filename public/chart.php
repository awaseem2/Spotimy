<?php

$m = new MongoClient(); // connect

//mongo query:
$db = $m->selectDB("let list = db.Spotimy.find({position: {$gte:1}}, {position: {$lte: 200}]})
let alist = [];
while (list.hasNext()) {
    let arr = list.next().country;
    for (i = 0; i < arr.length; i++) {
        let temp = alist.push(arr[i]);

    }
}
db.Actors.find({track_name:{$in:alist}},{track_rank:1,country:1,_id:0})");


 require_once('MongoDB/Charts.php');
 use \MongoDB\Charts;

 $embeddingKey = 'd200702a84da4634';
 $baseUrl = 'https://charts.mongodb.com/charts-project-0-dkxvh'; // Replace with the base URL to your Charts instance, e.g. https://charts.mongodb.com/charts-foo-abcde (no trailing slash)
 $tenantId = '7826f34a-3b7c-4ae5-8480-64e3669d072b'; // Replace with your Charts Tenant ID from the Embed Chart snippet
 $chartId = '2c2c5942-94e1-4743-98e0-be83803d5df0'; //Chart Id to Embed
 //$filter = '{"track_name": "'.$encode.'"}';
 $name = $_POST["track_name"];
 if (empty($_POST["top_artist"])) {
    $filter = '{"track_name" : {$regex:"^'.$_POST["track_name"].'", $options: "i"}}';
 } else {
      $filter = '{"artist" : {$regex:"^'.$_POST["top_artist"].'", $options: "i"}}';
      $name = $_POST["top_artist"];
    //$filter = '{"artist" : "'.$_POST["top_artist"].'"}';
 }
 //print(str/empty($encode));
 
 $autoRefreshSeconds = NULL; // Set to a number >=10 if you want the chart to autorefresh
 
 $charts = new Charts($baseUrl, $tenantId, $embeddingKey, $filter, $autoRefreshSeconds);
 

?>
<!DOCTYPE html>
<html>
<head>
    <title>Spotimy</title>
    <link rel="stylesheet" type="text/css" href="css/tablestyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="assets/images/logo1.png">
</head>
<body>
    <a href = "index.html"><button style="float: right;" class="btn"><i class="fa fa-home"></i> Home</button></a>
    <h1>MongoDB Charts for <?php echo $name ?></h1>
    <iframe style="border: none;border-radius: 2px;box-shadow: 0 2px 10px 0 rgba(70, 76, 79, .2);" width="1024" height="768" src="<?php echo $charts->getChartUri($chartId); ?>"></iframe>

    <p>If you're getting an error code instead of a chart, <a href="https://docs.mongodb.com/charts/saas/embedding-charts/#embedded-charts-error-codes" target="_blank">click here</a> 
        to find out what the code means.</p>   
</body>
</html>

