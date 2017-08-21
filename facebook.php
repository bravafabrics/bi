<?php

require_once("keychain_api.php"); // ALL USERS & PASSWORDS
$loader = include ('vendor/autoload.php');
// normaly we should include 
// include("queries_database.php");
// About yesterday date //



if (is_null(CLIENT_FB_TOKEN) || is_null(APP_FB_ID) || is_null(APP_FB_SECRET)) {
  throw new \Exception(
    'You must set your access token, app id and app secret before executing'
  );
}

if (is_null(BRAVA_AD_ACCOUNT_CONVERSION) || is_null(BRAVA_AD_ACCOUNT_BRANDING) ) {
  throw new \Exception(
    'You must set your account id before executing');
}
use FacebookAds\Api;
use FacebookAds\Object\Values\InsightsPresets;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

Api::init(APP_FB_ID, APP_FB_SECRET, CLIENT_FB_TOKEN);

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;

function fulfill_market_with_facebook_api($date_yesterday) { 





try {
	
	
	
$account_conversion = (new AdAccount(BRAVA_AD_ACCOUNT_CONVERSION))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));

$account_branding = (new AdAccount(BRAVA_AD_ACCOUNT_BRANDING))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));



$fields= array(
'spend'
);

$params= array(
	'time_range'=>array('since'=>$date_yesterday,'until'=>$date_yesterday),
	'level'=>'account',
	'limit'=>'1000',
	'breakdowns' => array('country')
);


$values_conversion= $account_conversion->getInsights($fields,$params);
$values_branding= $account_branding->getInsights($fields,$params);


foreach($values_conversion as $value_conversion) { 
 
ajax_insert_marketing($date_yesterday, "Facebook Conversion", $value_conversion->country, $value_conversion->spend);
// *********** INSERTION DATAWARE HOUSE **// 
update_marketing_cost($date_yesterday, $value_conversion->country, "Facebook Conversion", $value_conversion->spend);
	
update_marketing_spend_cac($date_yesterday, $value_conversion->country, $value_conversion->spend); 

 
 }


	foreach($values_branding as $value_branding) { 
ajax_insert_marketing($date_yesterday, "Facebook Branding", $value_branding->country, $value_branding->spend);
update_marketing_cost($date_yesterday, $value_branding->country, "Facebook Branding", $value_branding->spend);
	
update_marketing_spend_cac($date_yesterday, $value_branding->country, $value_branding->spend);
 
 

 }
  echo "All Facebook has correctly been added";

}

catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}
catch (Exception $e) {
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}

} 

function compute_the_revelance_score_by_array($array) {  

// $array = array_values($array);
$sum_spend = 0;
$sum_temp = 0;
foreach ($array as $data) { 

$sum_spend += $data['spend'];
$sum_temp+= ($data['spend']*$data['score']);
 }

return $sum_temp/$sum_spend;
 
}

function get_the_relevance_score_by_adset($date_yesterday, $adset_id) {  

try { 
$account_conversion = (new AdAccount(BRAVA_AD_ACCOUNT_CONVERSION))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));
$fields= array(
'adset_id', 'ad_id', 'relevance_score', 'spend'
);

$params= array(
	'time_range'=>array('since'=>$date_yesterday,'until'=>$date_yesterday),
	'level'=>'ad',
	'limit'=>'1000'
);


$values_conversion= $account_conversion->getInsights($fields,$params);
$array = array();

$i = 0;
foreach($values_conversion as $value) {  

if($value->adset_id == $adset_id) { 
$array[$i]['adset_id'] = $value->adset_id;
$array[$i]['ad_id'] = $value->ad_id;
if($value->relevance_score['status'] == 'OK')
$array[$i]['score'] = $value->relevance_score['score'];
else $array[$i]['score'] = 0;
$array[$i]['spend'] = $value->spend;
$i++; 
}
}
	return compute_the_revelance_score_by_array($array);
}


catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}
catch (Exception $e) {
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}

}


function getMoreInfosAboutAdset($adset_id, $choose) {  

try { 

 $adset = new AdSet($adset_id, BRAVA_AD_ACCOUNT_CONVERSION);
$adset->read(array(
  AdSetFields::NAME,
  AdSetFields::BID_AMOUNT,
  AdSetFields::DAILY_BUDGET,
  AdSetFields::OPTIMIZATION_GOAL,
  AdSetFields::IS_AUTOBID,
  AdSetFields::PROMOTED_OBJECT  

)); 
if($choose == 'bid') return $adset->bid_amount/100;
if($choose == 'dailybudget') return $adset->daily_budget/100;
if($choose == 'event_type') return $adset->promoted_object['custom_event_type'];
if($choose == 'autobid') {  if($adset->is_autobid) return "Automatic"; else return "Manual";  }
if($choose == 'optimization') return $adset->optimization_goal;

return 0;


}

catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}
catch (Exception $e) {
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}

}

function fulfill_adset_with_facebook_api($date_yesterday) { 


try {
	
	
	
$account_conversion = (new AdAccount(BRAVA_AD_ACCOUNT_CONVERSION))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));

$account_branding = (new AdAccount(BRAVA_AD_ACCOUNT_BRANDING))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));



$fields= array(
'adset_id', 'campaign_id', 'campaign_name', 'adset_name', 'relevance_score', 'spend', 'objective', 'action_values', 'actions'
);

$params= array(
	'time_range'=>array('since'=>$date_yesterday,'until'=>$date_yesterday),
	'level'=>'adset',
	'limit'=>'1000'	
);


$values_conversion= $account_conversion->getInsights($fields,$params);
$values_branding= $account_branding->getInsights($fields,$params);


	foreach($values_conversion as $data_conversion) { 


$composed_name = $data_conversion->campaign_name . "=>".$data_conversion->adset_name;
fulfill_adset_header_fb($data_conversion->adset_id, $date_yesterday, $data_conversion->campaign_id, $data_conversion->adset_name, $data_conversion->campaign_name,
$composed_name, getMoreInfosAboutAdset($data_conversion->adset_id, "bid"), get_the_relevance_score_by_adset($date_yesterday, $data_conversion->adset_id), 
getMoreInfosAboutAdset($data_conversion->adset_id, "dailybudget"), get_the_campaign_type($data_conversion->campaign_name), $data_conversion->objective,
getMoreInfosAboutAdset($data_conversion->adset_id, "event_type"), getMoreInfosAboutAdset($data_conversion->adset_id, "autobid"), getMoreInfosAboutAdset($data_conversion->adset_id, "optimization"));

 }

  

  
}

catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}
catch (Exception $e) {
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}

} 

function fulfill_adset_header_by_period($period, $date_yesterday, $date_begin) {  


try {
	
	
	
$account_conversion = (new AdAccount(BRAVA_AD_ACCOUNT_CONVERSION))->read(array(
  AdAccountFields::NAME,
  AdAccountFields::ID
));




$fields= array(
'adset_id', 'campaign_id', 'campaign_name', 'adset_name', 'spend', 'action_values', 'actions', 'impressions', 'cpp', 'cpc', 'cost_per_unique_click',
'cpm', 'reach', 'frequency'
);

if($period == 'lifetime' && $date_begin != '') {

$params= array(
	'time_range'=>array('since'=>$date_begin,'until'=>$date_yesterday),
	'level'=>'adset',
	'limit'=>'1000'
);

}
else { 
$params= array(
	'date_preset' => $period,
	'level'=>'adset',
	'limit'=>'1000'
);
}


$values_conversion= $account_conversion->getInsights($fields,$params);


	foreach($values_conversion as $data_conversion) { 
 $count_pixel_add_to_cart = 0;
 $count_pixel_purchase = 0;
 $count_pixel_checkout = 0;
 $count_pixel_product_view = 0;
 $link_clicks = 0;

 
 if(is_array($data_conversion->actions) || is_object($data_conversion->actions)) {
	foreach($data_conversion->actions as $aux) { 
		if($aux['action_type'] == 'offsite_conversion.fb_pixel_add_to_cart') $count_pixel_add_to_cart = $aux['value']; 
		if($aux['action_type'] == 'offsite_conversion.fb_pixel_purchase') $count_pixel_purchase = $aux['value']; 
		if($aux['action_type'] == 'offsite_conversion.fb_pixel_initiate_checkout') $count_pixel_checkout = $aux['value']; 
		if($aux['action_type'] == 'offsite_conversion.fb_pixel_view_content') $count_pixel_product_view = $aux['value']; 
		if($aux['action_type'] == 'link_click') $link_clicks = $aux['value']; 
		
	}

 }
	$sum_values_pixel_purchase = 0;
	if(is_array($data_conversion->action_values) || is_object($data_conversion->action_values)) {
			
		foreach($data_conversion->action_values as $aux)
			if($aux['action_type'] == 'offsite_conversion.fb_pixel_purchase') $sum_values_pixel_purchase+=$aux['value'];
	}
	
	
	// var_dump($sum_values_pixel_purchase);
	
	if($count_pixel_purchase == 0) $cost_per_purchase = 0;
	else $cost_per_purchase = ($data_conversion->spend / $count_pixel_purchase);
	if($count_pixel_add_to_cart == 0) $cost_per_add_to_cart = 0;
	else $cost_per_add_to_cart = ($data_conversion->spend / $count_pixel_add_to_cart);
	if($count_pixel_product_view == 0) $cost_per_product_view = 0;
	else $cost_per_product_view = ($data_conversion->spend / $count_pixel_product_view);
	
	
$cost_per_thousand = $data_conversion->cpp;	
$delivery = $data_conversion->spend/(getMoreInfosAboutAdset($data_conversion->adset_id, "dailybudget"));
$underdelivery = (1 - $delivery);




if($period == 'yesterday')  

fulfill_adset_data_yesterday($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $link_clicks, $data_conversion->impressions, 
$data_conversion->cpc, $data_conversion->cost_per_unique_click, $data_conversion->cpm, $data_conversion->reach, $cost_per_thousand, 
$count_pixel_add_to_cart, $count_pixel_purchase,
$sum_values_pixel_purchase, $count_pixel_checkout, $cost_per_purchase, $cost_per_add_to_cart, $cost_per_product_view, $delivery, $underdelivery, $data_conversion->frequency);	

if($period == 'lifetime')  

fulfill_adset_data_lifetime($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $link_clicks, $data_conversion->impressions, 
$data_conversion->cpc, $data_conversion->cost_per_unique_click, $data_conversion->cpm, $data_conversion->reach, $cost_per_thousand, 
$count_pixel_add_to_cart, $count_pixel_purchase,
$sum_values_pixel_purchase, $count_pixel_checkout, $cost_per_purchase, $cost_per_add_to_cart, $cost_per_product_view, $delivery, $underdelivery, $data_conversion->frequency);	


if($period == 'last_3d') 

fulfill_adset_data_last_three_days($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $link_clicks, $data_conversion->impressions, 
$data_conversion->cpc, $data_conversion->cost_per_unique_click, $data_conversion->cpm, $data_conversion->reach, $cost_per_thousand, 
$count_pixel_add_to_cart, $count_pixel_purchase,
$sum_values_pixel_purchase, $count_pixel_checkout, $cost_per_purchase, $cost_per_add_to_cart, $cost_per_product_view, $delivery, $underdelivery, $data_conversion->frequency);	


if($period == 'last_7d') 

fulfill_adset_data_last_seven_days($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $link_clicks, $data_conversion->impressions, 
$data_conversion->cpc, $data_conversion->cost_per_unique_click, $data_conversion->cpm, $data_conversion->reach, $cost_per_thousand, 
$count_pixel_add_to_cart, $count_pixel_purchase,
$sum_values_pixel_purchase, $count_pixel_checkout, $cost_per_purchase, $cost_per_add_to_cart, $cost_per_product_view, $delivery, $underdelivery, $data_conversion->frequency);	

if($period == 'last_28d') 

fulfill_adset_data_last_twenty_eight_days($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $link_clicks, $data_conversion->impressions, 
$data_conversion->cpc, $data_conversion->cost_per_unique_click, $data_conversion->cpm, $data_conversion->reach, $cost_per_thousand, 
$count_pixel_add_to_cart, $count_pixel_purchase,
$sum_values_pixel_purchase, $count_pixel_checkout, $cost_per_purchase, $cost_per_add_to_cart, $cost_per_product_view, $delivery, $underdelivery, $data_conversion->frequency);	



// var_dump($data_conversion->adset_id, $date_yesterday, $data_conversion->spend, $data_conversion->frequency);

 }

  

  
}

catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}
catch (Exception $e) {
  echo  'GetAdInsightsFromAnAdset: Graph returned an error: ' . $e->getMessage();
  exit;
}


}

function get_the_campaign_type($string) {
	
	$array = explode('_', $string);
	if(sizeOf($array) >= 4)  return $array[2] . "-".$array[3];
	return $array[2];
}






?>