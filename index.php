<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brava Fabrics</title>

    <!-- Bootstrap Core CSS -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="lib/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="lib/device-mockups/device-mockups.min.css">

    <!-- Theme CSS -->
    <link href="css/new-age.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="background-color:#FFFFFF;height:50px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"><img src="img/bflogo.jpg" style="width:50%;" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#all">All</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#details">Details</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="cost.php">Gateways/Logistics</a>
                    </li>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<?php 
date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$now = new DateTime(date("Y-m-d"), $set_local_time);
$now_minus_one_year = date('Y-m-d',strtotime(date($now->format("d-m-Y"), time()) . " - 365 day"));
$now_begin_month_one_year = date('Y-m-d',strtotime(date($now->format("01-m-Y"), time()) . " - 365 day"));
$begin_of_the_current_month = $now->format("Y-m-01");

// ******** TO HAVE THE REVIEW OF TODAY'S DATE, JUST UNCOMMENT THE FILES ***** //

// List of each countries by date
include("queries_database.php");
$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');

// $today_date = $yesterday_date->format("Y-m-d");
$today_date = "2017-05-05";
$month_begin = "2017-05-01";
// $month_begin = $yesterday_date->format("Y-m-01"); // Beginning of the month
$year_date_begin = "2016-05-01";
 $year_date_end_temp = date('Y-m-d',strtotime(date($yesterday_date->format("d-m-Y"), time()) . " - 365 day"));
$test_year = new DateTime($year_date_end_temp);
$test_year->modify('-1 day');
$test_year->modify('+1 day');
// $year_date_end = $test_year->format("Y-m-d"); 
$year_date_end = "2016-05-01";
 // Lets try the +1 et -1 thing 
 
 

$countries = get_countries_top_five($today_date);

?>
    <section id="all" class="features" style="padding-top:75px;">
        <div class="container">
                    <div class="section-heading" style="text-align:center;margin-bottom:20px;">
                        <h2>Report from yesterday : <b><?php echo $yesterday_date->format("d-m-Y"); ?></b></h2>
						</div>
<p style="font-size:25px;text-align:center;"><img src="img/flags/europeanunion.png" /> <u>All Countries</u></p>
<div class="text-table">
		 <table class="table table-hover" style="text-align:center;">
    <thead>
      <tr class="active">
        <th style="text-align:right;border-right:1px solid #000000;"></th>
        <th style="text-align:right;border-right:1px solid #000000;">Yesterday</th>
		<th style="text-align:right;border-right:3px solid #000000;">%</th>
        <th style="text-align:right;border-right:1px solid #000000;">This month</th>
		<th style="text-align:right;border-right:3px solid #000000;">%</th>
		<th style="text-align:right;border-right:1px solid #000000;">Last year</th>
		<th style="text-align:right;">%</th>		
      </tr>
    </thead>
    <tbody style="text-align:right;">
      <tr id="0_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Fullpricing</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_fullpricing($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_fullpricing_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_fullpricing($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_fullpricing($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-</b></td>		
      </tr>  
      <tr id="1_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Discount</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_discount($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_discount_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_discount_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_discount_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_discount($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_discount($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_discount($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_discount_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>
      </tr> 	  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_all_net_sales" style="float:left;" />  <b>Net Sales</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_net_sales($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;">-</td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_net_sales_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_net_sales($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_net_sales($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
		-
		</b></td>
      </tr> 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>Gateways</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_gateways($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_gateways_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_gateways_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_gateways_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_gateways($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_gateways($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_gateways($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_gateways_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	

      </tr>	 
      <tr id="3_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Paid</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_paid($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_paid_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_paid($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_paid($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	
      <tr id="4_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Logistic</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_logistics($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_logistics_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_logistics($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_logistics($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>		
      <tr id="4_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Handling Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_handling_cost($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_handling_cost_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_handling_cost($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_handling_cost($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	
      <tr id="5_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Order Preparation</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_order_preparation($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_order_preparation_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_order_preparation($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_order_preparation($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_all_logs" style="float:left;" />  <b>Total Logistics</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_logs($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_logs_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_logs_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_logs_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_logs($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_total_logs($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_logs($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_logs_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 	  
      <tr id="6_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Cogs</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cogs($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_cogs_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cogs_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_cogs_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cogs($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_cogs($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_cogs($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_cogs_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	

      </tr>	
	  
      <tr id="7_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Packaging Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_packaging_cost($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_packaging_cost_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_packaging_cost($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_packaging_cost($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>

	  
      <tr id="8_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Materals</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_materals($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_materals_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_materals($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_materals($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>			  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_all_cogs"  style="float:left;"/>  <b>Total Cogs</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_cogs($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_cogs_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_cogs_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_cogs_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_cogs($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_total_cogs($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_cogs($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_total_cogs_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 	  
 

	  
      <tr>
        <td style="border-right:1px solid #000000;"><b>Profit</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_profit($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_profit_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_profit_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_profit_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_profit($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_profit($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_profit($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_profit_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>
      </tr> 	  
    </tbody>
  </table>
  </div>
     <div id="chart_all_countries" style="width: 100%;min-height: 450px;"></div>

  </div>
  </section>

    <section id="details" class="features">
        <div class="container">  
<?php
foreach($countries as $country) {
?>
<div id="country-<?php echo $country['countrycode']; ?>">
<p style="font-size:25px;text-align:center;"><img src="img/flags/<?php echo strtolower($country['countrycode']); ?>.png" /> <u><?php echo $country['countrycode']; ?></u></p>
<div class="text-table">
		 <table class="table table-hover" style="text-align:center;">
    <thead>
      <tr class="active">
        <th style="text-align:right;border-right:1px solid #000000;"></th>
        <th style="text-align:right;border-right:1px solid #000000;">Yesterday</th>
		<th style="text-align:right;border-right:3px solid #000000;">%</th>
        <th style="text-align:right;border-right:1px solid #000000;">This month</th>
		<th style="text-align:right;border-right:3px solid #000000;">%</th>
		<th style="text-align:right;border-right:1px solid #000000;">Last year</th>
		<th style="text-align:right;">%</th>		
      </tr>
    </thead>
    <tbody style="text-align:right;">
      <tr id="0_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Sales</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_fullpricing($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_fullpricing_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_fullpricing($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_fullpricing($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-</b></td>		
      </tr>  
      <tr id="1_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Discount</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_discount($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_discount_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_discount_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_discount_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_discount($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_discount($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_discount($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_discount_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>
      </tr> 	  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_<?php echo $country['countrycode']; ?>_net_sales" style="float:left;" />  <b>Net Sales</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_net_sales($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;">-</td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_net_sales_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_net_sales($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_net_sales($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
		-
		</b></td>
      </tr> 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>Gateways</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_gateways($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_gateways_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_gateways_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_gateways_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_gateways($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_gateways($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_gateways($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_gateways_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	

      </tr>	 	  
      <tr id="3_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Paid</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_paid($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_paid_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_paid($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_paid($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	
      <tr id="4_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Logistic</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_logistics($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_logistics_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_logistics($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_logistics($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>		
      <tr id="4_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Handling Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_handling_cost($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_handling_cost_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_handling_cost($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_handling_cost($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	
      <tr id="5_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Order Preparation</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_order_preparation($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_order_preparation_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_order_preparation($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_order_preparation($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_<?php echo $country['countrycode']; ?>_logs" style="float:left;" />  <b>Total Logistics</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_logs($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_logs_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_logs_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_logs_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_logs($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_total_logs($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_logs($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_logs_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 	  
      <tr id="6_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Cogs</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cogs($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_cogs_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cogs_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_cogs_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cogs($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_cogs($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_cogs($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_cogs_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	

      </tr>	
	  
      <tr id="7_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Packaging Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_packaging_cost($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_packaging_cost_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_packaging_cost($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_packaging_cost($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>

	  
      <tr id="8_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Shipping Materals</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_materals($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_shipping_materals_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_shipping_materals($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_shipping_materals($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>			  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more.png" id="more_<?php echo $country['countrycode']; ?>_cogs"  style="float:left;"/>  <b>Total Cogs</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_cogs($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_cogs_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_cogs_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_cogs_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_cogs($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_total_cogs($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_cogs($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_total_cogs_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 	  
 

	  
      <tr>
        <td style="border-right:1px solid #000000;"><b>Profit</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_profit($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_profit_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_profit_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_profit_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_profit($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_profit($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_profit($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_profit_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>
      </tr> 	  
    </tbody>
  </table>
</div>
</div>
<div id="chart_country_<?php echo $country['countrycode']; ?>"></div>
<?php
}
?>
					
						
						
			
			</div>

  
        </div>	
    </section>


    <footer>
        <div class="container">
            <p>&copy; 2017 BravaFabrics & Bootstrap Template All Rights Reserved.</p>
        </div>
    </footer>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
		<?php
date_default_timezone_set("Europe/Madrid");		
$date_begin_correct_format = new DateTime($today_date, $set_local_time);
$date_end_correct_format = date('d-m-Y',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " - 6 day"));
$date_begin_to_show = $date_begin_correct_format->format("d-m-Y");
$date_begin_correct_format = new DateTime($date_end_correct_format, $set_local_time); 
?>
            var data_all_countries = google.visualization.arrayToDataTable([
          ['Day', 'Sales', 'Profit', 'Marketing Cost'],
		  <?php

for ($day_to_add = 0; $day_to_add < 7; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " day"));
		$sales = get_fullpricing($date_to_implement, '');
		$profit = get_profit($date_to_implement, '');
		echo "['".date('D',strtotime($date_to_implement)). "', ".$sales.", ".$profit.", 0],";
}

		  ?>
        ]);
        var options_all_countries = {
          title: 'All Countries Report from <?php echo $date_begin_correct_format->format("d-m-Y") . " to " .$date_begin_to_show; ?>',
          curveType: 'function',
		  legend: { position: 'top', alignment: 'start' }}
      var chart = new google.visualization.LineChart(document.getElementById('chart_all_countries'));
      chart.draw(data_all_countries, options_all_countries);

// Now lets plot for each the countries
<?php 
$countries = get_countries_top_five($today_date);
foreach($countries as $country) {

?>
            var data_each_country = google.visualization.arrayToDataTable([
          ['Day', 'Sales', 'Profit', 'Marketing Cost'],
		  <?php

for ($day_to_add = 0; $day_to_add < 7; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " day"));
		$sales = get_fullpricing($date_to_implement, $country['countrycode']);
		$profit = get_profit($date_to_implement, $country['countrycode']);
		echo "['".date('D',strtotime($date_to_implement)). "', ".$sales.", ".$profit.", 0],";
}

		  ?>
        ]);
        var options_each_country = {
          title: 'Report for the country <?php echo $country['countrycode']; ?> from <?php echo $date_begin_correct_format->format("d-m-Y") . " to " .$date_begin_to_show; ?>',
          curveType: 'function',
		  legend: { position: 'top', alignment: 'start' }}
      var chart = new google.visualization.LineChart(document.getElementById('chart_country_<?php echo $country['countrycode']; ?>'));
      chart.draw(data_each_country, options_each_country);

<?php }
?>
// 	End of the ploting
	  
	  
    } 
$(window).resize(function(){
  drawChart();
});	

    </script>
	<script>
	moreAboutFields("net_sales", "all", 0, 1);
	moreAboutFields("logs", "all", 3, 5);
	moreAboutFields("cogs", "all", 6, 8);
	<?php 
	$countries = get_countries_top_five($today_date);
foreach($countries as $country) {
?>
	moreAboutFields("net_sales", "<?php echo $country['countrycode']; ?>", 0, 1);
	moreAboutFields("logs", "<?php echo $country['countrycode']; ?>", 3, 5);
	moreAboutFields("cogs", "<?php echo $country['countrycode']; ?>", 6, 8);
<?php } ?>
	
	function moreAboutFields(name, country, id_begin, id_end) { 
		$('#more_'+country+'_'+name+'').click(function(e) { 
		$('#more_'+country+'_'+name+'').attr('src', 'img/icon/less.png');
		$('#more_'+country+'_'+name+'').attr('id', 'less_'+country+'_'+name+'');
			for (var i = id_begin; i <= id_end; i++) {  
			$('#'+i+'_'+country+'_country').css('display', '');
			}
			lessAboutFields(name, country, id_begin, id_end);
		});
	
	}
	function lessAboutFields(name, country, id_begin, id_end) { 
		$('#less_'+country+'_'+name+'').click(function(e) { 
		$('#less_'+country+'_'+name+'').attr('src', 'img/icon/more.png');
		$('#less_'+country+'_'+name+'').attr('id', 'more_'+country+'_'+name+'');
			for (var i = id_begin; i <= id_end; i++) {
			$('#'+i+'_'+country+'_country').css('display', 'none');
			}		
			moreAboutFields(name, country, id_begin, id_end);
		});

	}
	

	</script>
	

	<!-- END ploting -->
    <!-- Bootstrap Core JavaScript -->
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>

</body>

</html>
