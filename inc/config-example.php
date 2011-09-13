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

	// List of fields to repeat, anything not hear will be stripped
	// Only urls loaded here will be allowed
	$allowed_fields = array(
		// Tour Search (channel specific)
		"/c/tours/search.xml" => array(
			"tour_id",
			"channel_id",
			"tour_name",
			"has_sale",
			"has_f",
			"has_d",
			"has_h",
			"has_sale_jan",
			"has_sale_feb",
			"has_sale_mar",
			"has_sale_apr",
			"has_sale_may",
			"has_sale_jun",
			"has_sale_jul",
			"has_sale_aug",
			"has_sale_sep",
			"has_sale_oct",
			"has_sale_nov",
			"has_sale_dec",
			"geocode_start",
			"geocode_end",
			"distance",
			"tour_code",
			"from_price",
			"from_price_display",
			"from_price_jan",
			"from_price_feb",
			"from_price_mar",
			"from_price_apr",
			"from_price_may",
			"from_price_jun",
			"from_price_jul",
			"from_price_aug",
			"from_price_sep",
			"from_price_oct",
			"from_price_nov",
			"from_price_dec",
			"sale_currency",
			"thumbnail_image",
			"country",
			"duration_desc",
			"duration",
			"location",
			"summary",
			"shortdesc",
			"available",
			"tour_url",
			"tour_url_tracked",
			"book_url",
			"tourleader_type",
			"grade",
			"accomrating",
			"product_type",
			"channel->channel_name",
			"channel->logo_url",
			"channel->lang",
			"channel->home_url",
			"channel->home_url_tracked"
		),
		
		// Tour Search (all channels)
		"/p/tours/search.xml" => array(
			"tour_id",
			"channel_id",
			"tour_name",
			"has_sale",
			"has_f",
			"has_d",
			"has_h",
			"has_sale_jan",
			"has_sale_feb",
			"has_sale_mar",
			"has_sale_apr",
			"has_sale_may",
			"has_sale_jun",
			"has_sale_jul",
			"has_sale_aug",
			"has_sale_sep",
			"has_sale_oct",
			"has_sale_nov",
			"has_sale_dec",
			"geocode_start",
			"geocode_end",
			"distance",
			"tour_code",
			"from_price",
			"from_price_display",
			"from_price_jan",
			"from_price_feb",
			"from_price_mar",
			"from_price_apr",
			"from_price_may",
			"from_price_jun",
			"from_price_jul",
			"from_price_aug",
			"from_price_sep",
			"from_price_oct",
			"from_price_nov",
			"from_price_dec",
			"sale_currency",
			"thumbnail_image",
			"country",
			"duration_desc",
			"duration",
			"location",
			"summary",
			"shortdesc",
			"available",
			"tour_url",
			"tour_url_tracked",
			"book_url",
			"tourleader_type",
			"grade",
			"accomrating",
			"product_type",
			"channel->channel_name",
			"channel->logo_url",
			"channel->lang",
			"channel->home_url",
			"channel->home_url_tracked"
		),
				
		// Tour Show
		"/c/tour/show.xml" => array(
			"tour_id",
			"channel_id",
			"tour_name",
			"has_sale",
			"has_f",
			"has_d",
			"has_h",
			"has_sale_jan",
			"has_sale_feb",
			"has_sale_mar",
			"has_sale_apr",
			"has_sale_may",
			"has_sale_jun",
			"has_sale_jul",
			"has_sale_aug",
			"has_sale_sep",
			"has_sale_oct",
			"has_sale_nov",
			"has_sale_dec",
			"quantity_rule",
			"geocode_start",
			"geocode_end",
			"tour_code",
			"from_price",
			"from_price_display",
			"from_price_jan",
			"from_price_feb",
			"from_price_mar",
			"from_price_apr",
			"from_price_may",
			"from_price_jun",
			"from_price_jul",
			"from_price_aug",
			"from_price_sep",
			"from_price_oct",
			"from_price_nov",
			"from_price_dec",
			"sale_currency",
			"thumbnail_image",
			"country",
			"duration_desc",
			"duration",
			"location",
			"summary",
			"shortdesc",
			"longdesc",
			"itinerary",
			"exp",
			"pick",
			"extras",
			"rest",
			"available",
			"dep_code_style",
			"tour_url",
			"tour_url_tracked",
			"book_url",
			"tourleader_type",
			"grade",
			"accomrating",
			"product_type",
			"images"
		)
	);

?>