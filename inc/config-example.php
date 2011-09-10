<?php
	// Include TourCMS API PHP wrapper
	include('tourcms.php');
	
	// URL for this directory
	$base_url = "/scratch/api/json/";
	
	// Marketplace account ID
	// Leave this as zero if you are a supplier (i.e. not a Marketplace partner)
	$marketplace_account_id = 0;
	
	// API Private Key (log in to TourCMS to get yours)
	$api_private_key = "";

	// List of fields to block, longer term this should
	// instead be a list of fields to allow

	// Only urls loaded here will be allowed
	$blocked_fields = array(
		"/c/tours/search.xml" => array(),
		"/p/tours/search.xml" => array()
	);

?>