<?php
include("inc/config.php");

// Get basic endpoint that's being called
isset($_GET['url']) ? $url = $_GET['url'] : $url = $_GET['url'];
// Generate the actual XML API uri
$api_url = str_replace("json", "xml", $url);

// Get querystring
$request_uri = $_SERVER['REQUEST_URI'];
$qs = "/".str_replace($base_url, '', $request_uri);
$qs = str_replace($url, '', $qs);

// Merge the pre-redirect querystring back in
$parsed_uri = parse_url($request_uri);
if(isset($parsed_uri["query"])) {
	parse_str($parsed_uri["query"], $qs_array);
	$_GET = array_merge($_GET, $qs_array);
}

// Channel ID
isset($_GET['channel']) ? $channel = intval($_GET['channel']): $channel = 0;

// Content type
isset($_GET['return']) ? $return = "text" : $return = "json";
if($return=="text")
	header("Content-type: text/plain; charset=UTF-8");
else
	header("Content-type: application/json; charset=UTF-8");

// Callback (for jsonp)
if(isset($_GET['callback'])) {
	$callback = addslashes($_GET['callback']);
	$jsonp = true;
} else
	$jsonp = false;

// Check the API url is allowed (in config.php)
if (array_key_exists($api_url, $allowed_fields)) {
    
    $tourcms = new TourCMS($marketplace_account_id, $api_private_key, "simplexml");

 	$result = $tourcms->request($api_url.$qs, $channel);

 	$error = $result->error;
 	
 	$string = '{
 		"tours" : [';
 	if ($error=="OK") {
 	    /* fetch associative array */
 	    foreach ($result->tour as $item) {
 	        //printf ("%s (%s)\n", $row["name"], $row["id"]);
 	        //print "<pre>".json_encode($row)."</pre>";
 	       	$string .= '
 			{
 			';
 			
 			foreach ($allowed_fields[$api_url] as $field) {
 				$exploded = explode("->", $field);
 				count($exploded) == 1 ? $value = $item->$exploded[0] : $value = $item->$exploded[0]->$exploded[1];
 				
 				$string .= '
 					"'.$field.'" : '.json_encode((string)$value).',';
 			}	
 			$string = substr($string, 0, strlen($string) - 1); 
 			$string .= '
 			}, ';
 	        
 		}
 	   
 	   	$string = substr($string, 0, strlen($string) - 2); 		
 	   	/* free result set */
 	    $string .= "
 	] }";
 		if($jsonp)
 			print $callback." (
 		".$string."
 	);";
 		else
 	    	print "$string";
 	} else {
 		printf("Error: %s\n", $error);
 	}
 	
 	
}
?>