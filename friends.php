<?php
//$directors = array( "Alfred Hitchcock", "Stanley Kubrick", "Martin Scorsese", "Fritz Lang" );
  //  $count = count($directors);

//echo "\r\ncount :";
//echo $count;
    //$keys = array_keys($value);
//print_r("\r\nHelloi\r\n");
//print_r
  //  for($i = 0; $i < $count+2; $i++) {
    // print_r("\r\n");
   //  print_r($i);
   //  $a = $directors[$i];
  //  print_r(" \r\n ");
 //   print_r($a);
   // }

   // print_r("Done");
//Include Composer's autoloader
require 'vendor/autoload.php';//composer require "mongodb/mongodb=^1.0.0.0"
//Create a MongoDB client and open connection to Amazon DocumentDB
$client = new MongoDB\Client("mongodb://spotimyapp:chiefonion212@docdb-2019-12-01-spotimy.cluster-czuutoojzmtm.us-east-1.docdb.amazonaws.com:27017/");

?>
