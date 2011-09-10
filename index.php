<?php
include("config.php");

// Get basic endpoint that's being called
isset($_GET['url']) ? $url = $_GET['url'] : $url = $_GET['url'];
// Generate the actual XML API uri
$api_url = str_replace("json", "xml", $url);

// Get querystring
$request_uri = $_SERVER['REQUEST_URI'];
$qs = "/".str_replace($base_url, '', $request_uri);
$qs = str_replace($url, '', $qs);

// Channel ID
isset($_GET['channel']) ? $channel = intval($_GET['channel']): $channel = 0;

if (array_key_exists($api_url, $blocked_fields)) {
    
    $tourcms = new TourCMS($marketplace_account_id, $api_private_key, "simplexml");
 
 	$result = $tourcms->request($api_url, $channel);
 	
 	print_r($result);
}
?>