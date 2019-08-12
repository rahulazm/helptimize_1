<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'httpcurl.php';
  
$target = "http://www.astervox.com";
 
$up = new Scraper;
$test = new HttpCurl($up);
 
$test->get($target);


echo "test";

print_r($test);
 
?>