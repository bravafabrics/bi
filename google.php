<?php

require __DIR__ . '/google/googleads-php-lib/vendor/autoload.php';

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201705\cm\LocationCriterionService;
use Google\AdsApi\AdWords\v201705\cm\Predicate;
use Google\AdsApi\AdWords\v201705\cm\PredicateOperator;
use Google\AdsApi\AdWords\v201705\cm\Selector;
use Google\AdsApi\AdWords\Reporting\v201705\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201705\ReportDefinition;
use Google\AdsApi\AdWords\Reporting\v201705\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\Reporting\v201705\ReportDownloader;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\AdWords\v201705\cm\ReportDefinitionReportType;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\AdsApi\AdWords\v201705\cm\DateRange;
	
function getCountryCode($country) { 
$countries = array
(
	'AF' => 'Afghanistan',
	'AX' => 'Aland Islands',
	'AL' => 'Albania',
	'DZ' => 'Algeria',
	'AS' => 'American Samoa',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AQ' => 'Antarctica',
	'AG' => 'Antigua And Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas',
	'BH' => 'Bahrain',
	'BD' => 'Bangladesh',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia And Herzegovina',
	'BW' => 'Botswana',
	'BV' => 'Bouvet Island',
	'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory',
	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'CN' => 'China',
	'CX' => 'Christmas Island',
	'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',
	'KM' => 'Comoros',
	'CG' => 'Congo',
	'CD' => 'Congo, Democratic Republic',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote D\'Ivoire',
	'HR' => 'Croatia',
	'CU' => 'Cuba',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FK' => 'Falkland Islands (Malvinas)',
	'FO' => 'Faroe Islands',
	'FJ' => 'Fiji',
	'FI' => 'Finland',
	'FR' => 'France',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'TF' => 'French Southern Territories',
	'GA' => 'Gabon',
	'GM' => 'Gambia',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GH' => 'Ghana',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GU' => 'Guam',
	'GT' => 'Guatemala',
	'GG' => 'Guernsey',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HT' => 'Haiti',
	'HM' => 'Heard Island & Mcdonald Islands',
	'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IR' => 'Iran, Islamic Republic Of',
	'IQ' => 'Iraq',
	'IE' => 'Ireland',
	'IM' => 'Isle Of Man',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JE' => 'Jersey',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KR' => 'Korea',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',
	'LA' => 'Lao People\'s Democratic Republic',
	'LV' => 'Latvia',
	'LB' => 'Lebanon',
	'LS' => 'Lesotho',
	'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MO' => 'Macao',
	'MK' => 'Macedonia',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia, Federated States Of',
	'MD' => 'Moldova',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'ME' => 'Montenegro',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'MM' => 'Myanmar',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PK' => 'Pakistan',
	'PW' => 'Palau',
	'PS' => 'Palestinian Territory, Occupied',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn',
	'PL' => 'Poland',
	'PT' => 'Portugal',
	'PR' => 'Puerto Rico',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russian Federation',
	'RW' => 'Rwanda',
	'BL' => 'Saint Barthelemy',
	'SH' => 'Saint Helena',
	'KN' => 'Saint Kitts And Nevis',
	'LC' => 'Saint Lucia',
	'MF' => 'Saint Martin',
	'PM' => 'Saint Pierre And Miquelon',
	'VC' => 'Saint Vincent And Grenadines',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome And Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'RS' => 'Serbia',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia',
	'ZA' => 'South Africa',
	'GS' => 'South Georgia And Sandwich Isl.',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SD' => 'Sudan',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard And Jan Mayen',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland',
	'SY' => 'Syrian Arab Republic',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania',
	'TH' => 'Thailand',
	'TL' => 'Timor-Leste',
	'TG' => 'Togo',
	'TK' => 'Tokelau',
	'TO' => 'Tonga',
	'TT' => 'Trinidad And Tobago',
	'TN' => 'Tunisia',
	'TR' => 'Turkey',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks And Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'US' => 'United States',
	'UM' => 'United States Outlying Islands',
	'UY' => 'Uruguay',
	'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',
	'VE' => 'Venezuela',
	'VN' => 'Viet Nam',
	'VG' => 'Virgin Islands, British',
	'VI' => 'Virgin Islands, U.S.',
	'WF' => 'Wallis And Futuna',
	'EH' => 'Western Sahara',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe',
);
if(!array_search($country, $countries)) return 'XX';
return array_search($country, $countries);

}	

  function downloadTheFile(AdWordsSession $session, $filePath, $date) {
	  $date_selector_format = str_replace("-", "", $date);
    // Create selector.
	
    $selector = new Selector();
    $selector->setFields(['CountryCriteriaId', 'Cost']);

    // Use a predicate to filter out paused criteria (this is optional).
	/*
    $selector->setPredicates([
        new Predicate('CampaignStatus', PredicateOperator::NOT_IN, ['PAUSED'])]);
*/
	$selector->setDateRange(new DateRange($date_selector_format, $date_selector_format));	
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'google_csv');
    $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::CUSTOM_DATE);
    $reportDefinition->setReportType(
        ReportDefinitionReportType::GEO_PERFORMANCE_REPORT);
    $reportDefinition->setDownloadFormat(DownloadFormat::CSV);

    // Download report.
    $reportDownloader = new ReportDownloader($session);
    // Optional: If you need to adjust report settings just for this one
    // request, you can create and supply the settings override here. Otherwise,
    // default values from the configuration file (adsapi_php.ini) are used.
    $reportSettingsOverride = (new ReportSettingsBuilder())
        ->includeZeroImpressions(false)
        ->build();
    $reportDownloadResult = $reportDownloader->downloadReport(
        $reportDefinition, $reportSettingsOverride);
    $reportDownloadResult->saveToFile($filePath);
			
  }
	
  function getTheCountry(AdWordsServices $adWordsServices,
      AdWordsSession $session, $countryId) {
		  
    $locationCriterionService =
        $adWordsServices->get($session, LocationCriterionService::class);



$selector = new Selector();
$selector->setFields(['Id', 'LocationName', 'CanonicalName', 'DisplayType', 'ParentLocations']);
$selector->setPredicates([new Predicate('Id', PredicateOperator::EQUALS, [$countryId])]);

    // Retrieve location criteria from the server.
    $locationCriteria = $locationCriterionService->get($selector);

    // Print out some information for each location criterion.
    if ($locationCriteria !== null) {
      foreach ($locationCriteria as $locationCriterion) {
        return getCountryCode($locationCriterion->getLocation()->getLocationName());
        }

      }
  }
  
  function fulfill_market_with_googleadwords_api($date) { 
    $oAuth2Credential = (new OAuth2TokenBuilder())
        ->fromFile()
        ->build();

    // Construct an API session configured from a properties file and the OAuth2
    // credentials above.
    $session = (new AdWordsSessionBuilder())
        ->fromFile()
        ->withOAuth2Credential($oAuth2Credential)
        ->build();
		
$filePath = sys_get_temp_dir().'/google_csv.csv';


downloadTheFile($session, $filePath, $date);

sleep(0.001);

if (($handle = fopen($filePath, "r")) !== FALSE) {
	$i = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

		if($data[0] == 'Total') break;
		if($i >= 2) { 
		ajax_insert_marketing($date, "Google Adwords", getTheCountry(new AdWordsServices(), $session, $data[0]), $data[1]/1000000);
		}
		$i++;
		
    }
    fclose($handle);
}


// Let's update the cost ! Marketing Cost and Profit ! 

$query_update = "SELECT * FROM zzz_marketing WHERE date = '".$date."' AND name = 'Google Adwords'";
$results_about_update = makequery($query_update);
$old_variables = $results_about_update->fetchAll();
foreach ($old_variables as $old_variable) {
      insert_datas_or_update_to_datawarehouse($date, $old_variable['country'], 
null, null, null, null, null, null, null,
null, 
null, null, null, null, null, null, 
null, null,
null, null, null, $old_variable['value'], null,
null, null,
null,
null, null,
null,
null, null, null);
}
$results_about_update->closeCursor();



  }
  
function get_the_campaign_type_google($string) {
$campaign_type = "";
	
if (strpos($string, 'RETARG') !== false) $campaign_type = "RETARG";
if (strpos($string, 'RETARG_DYN') !== false) $campaign_type = "RETARG-DYN";
if (strpos($string, 'LAL') !== false) $campaign_type = "LAL";
 	
	
return $campaign_type;	
}
	
  function downloadTheFileForBudget(AdWordsSession $session, $filePath, $date, $campaign_id) {
	  $date_selector_format = str_replace("-", "", $date);
    // Create selector.
	
    $selector = new Selector();
	
	// The selector : One in attribute (to group by) and several from Metrics ! 
    $selector->setFields(['Amount']);
	$selector->setPredicates([new Predicate('AssociatedCampaignId', PredicateOperator::EQUALS, [$campaign_id])]);
	$selector->setDateRange(new DateRange($date_selector_format, $date_selector_format));	
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'google_report_budget');
    $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::CUSTOM_DATE);
    $reportDefinition->setReportType(
        ReportDefinitionReportType::BUDGET_PERFORMANCE_REPORT);
    $reportDefinition->setDownloadFormat(DownloadFormat::CSV);

    // Download report.
    $reportDownloader = new ReportDownloader($session);
    // Optional: If you need to adjust report settings just for this one
    // request, you can create and supply the settings override here. Otherwise,
    // default values from the configuration file (adsapi_php.ini) are used.
    $reportSettingsOverride = (new ReportSettingsBuilder())
        ->includeZeroImpressions(false)
        ->build();
    $reportDownloadResult = $reportDownloader->downloadReport(
        $reportDefinition, $reportSettingsOverride);
    $reportDownloadResult->saveToFile($filePath);

$budget = 0;
sleep(0.001);

if (($handle = fopen($filePath, "r")) !== FALSE) {
	$i = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

		if($data[0] == 'Total') break;
		if($i >= 2) { 
		 $budget =  $data[0]/1000000;
		}
		$i++;
		
    }
    fclose($handle);
}

return $budget;
  } 
  
  function downloadTheFileForAdGroup(AdWordsSession $session, $filePath, $date) {
	  $date_selector_format = str_replace("-", "", $date);
    // Create selector.
	
    $selector = new Selector();
	
	// The selector : One in attribute (to group by) and several from Metrics ! 
    $selector->setFields(['AdGroupId', 'AdGroupName', 'CampaignId', 'Impressions', 'Clicks', 'CampaignName', 'CpcBid', 'CpmBid', 'CpvBid',
	'Cost', 'BidType', 'Interactions', 'InteractionRate', 'AverageCpc', 'Conversions', 'ImpressionAssistedConversions']);

	$selector->setDateRange(new DateRange($date_selector_format, $date_selector_format));	
    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'google_report_adgroup');
    $reportDefinition->setDateRangeType(
        ReportDefinitionDateRangeType::CUSTOM_DATE);
    $reportDefinition->setReportType(
        ReportDefinitionReportType::ADGROUP_PERFORMANCE_REPORT);
    $reportDefinition->setDownloadFormat(DownloadFormat::CSV);

    // Download report.
    $reportDownloader = new ReportDownloader($session);
    // Optional: If you need to adjust report settings just for this one
    // request, you can create and supply the settings override here. Otherwise,
    // default values from the configuration file (adsapi_php.ini) are used.
    $reportSettingsOverride = (new ReportSettingsBuilder())
        ->includeZeroImpressions(false)
        ->build();
    $reportDownloadResult = $reportDownloader->downloadReport(
        $reportDefinition, $reportSettingsOverride);
    $reportDownloadResult->saveToFile($filePath);
$filePathBudget = sys_get_temp_dir().'/google_report_budget.csv';
sleep(0.001);
$bid_type = 0;

if (($handle = fopen($filePath, "r")) !== FALSE) {
	$i = 0;
	// 14 & 15
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if($i == 1) $bid_type = $data[10];
		if($data[0] == 'Total') break;
		if($i >= 2) { 
			$id_adgroup = $data[0];
			$id_campaign = $data[2];
			$adgroup_name = $data[1];
			$campaign_name = $data[5];
			$amount_spend = $data[9]/1000000; 
			$campaign_type = get_the_campaign_type_google($campaign_name);
			$string_bid = "0";
			if (is_numeric($data[6])) $string_bid = $data[6];
			if (is_numeric($data[7])) $string_bid = $data[7];
			if (is_numeric($data[8])) $string_bid = $data[8];
			$bid = floatval($string_bid)/1000000;
			$impressions = $data[3]; 
			$clicks = $data[4]; $purchases_post_click = $data[14]; 
		$purchases_post_view = $data[15]; $cpclick = $clicks/$amount_spend;
			$cpurchase_post_click = $purchases_post_click/$amount_spend; $cpurchase_post_view = $purchases_post_view/$amount_spend; 
			$composed_name = $campaign_name . "=>".$adgroup_name;
			
			$budget = downloadTheFileForBudget($session, $filePathBudget, $date, $id_campaign); $cpm = ($amount_spend/$impressions)*1000;
			$delivery = $amount_spend/$budget; $underdelivery = 1 - $delivery;
fulfill_google_adgroup_header($id_adgroup, $date, $id_campaign, $adgroup_name, $campaign_name,
$composed_name, $campaign_type, $bid, $bid_type, $impressions, $clicks, $purchases_post_click, $purchases_post_view, $cpclick,
$cpurchase_post_click, $cpurchase_post_view, $amount_spend, $delivery, $underdelivery, $budget, $cpm);			
		}
		$i++;
		
    }
    fclose($handle);	
}
	







	
  }
  
 function launch_fulfill_for_google_header($date) {
	
    $oAuth2Credential = (new OAuth2TokenBuilder())
        ->fromFile()
        ->build();

    // Construct an API session configured from a properties file and the OAuth2
    // credentials above.
    $session = (new AdWordsSessionBuilder())
        ->fromFile()
        ->withOAuth2Credential($oAuth2Credential)
        ->build();
		
$filePathAdGroup = sys_get_temp_dir().'/google_report_adgroup.csv';
$filePathBudget = sys_get_temp_dir().'/google_report_budget.csv';

downloadTheFileForAdGroup($session, $filePathAdGroup, $date);
 }  
  		
 ?>