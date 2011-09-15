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
 	
 	
 	// Start building the output string
 	$string = '{
 		"tours" : [';
 	if ($error=="OK") {
 	    /* fetch associative array */
 	    foreach ($result->tour as $item) {
 	       	$string .= '
 			{
 			';
 			
 			foreach ($allowed_fields[$api_url] as $field) {
 			// Handle images separately
 				if($field=="images") {
	 				$string .= '
	 					"images" : [';
	 					
	 				
	 				foreach ($item->images->image as $image) {
	 					$string .= '
	 						"'.$image->url . '", ';
	 				}
	 				
	 				$string = substr($string, 0, strlen($string) - 2);
	 				
	 				$string .= '
	 					],';
	 		// Also handle special offers separately
	 			} else if($field=="soonest_special_offer" || $field=="recent_special_offer") {
	 				if(isset($item->$field)) {
		 				$string .= '
		 				"'.$field.'" : {';
		 					$offer_fields = array("start_date", "end_date", "date_code", "note", "min_booking_size", "spaces_remaining", "special_offer_type", "price_1", "price_1_display", "price_2", "price_2_display", "special_offer_datetime", "special_offer_note", "original_price_1", "original_price_1_display", "original_price_2", "original_price_2_display");
		 					
		 					foreach ($offer_fields as $offer_field) {
		 						$string .= '
		 						"'.$offer_field.'" : "'.$item->$field->$offer_field.'", ';
		 					}
		 					$string = substr($string, 0, strlen($string) - 2);
		 					
		 				$string .= '
		 				},';
		 			}
	 		// All other fields handled simply
 				} else {
 					$exploded = explode("->", $field);
 					count($exploded) == 1 ? $value = $item->$exploded[0] : $value = $item->$exploded[0]->$exploded[1];
 					
 					$string .= '
 						"'.$field.'" : '.json_encode((string)$value).',';
 				}	
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