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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="lib/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="lib/device-mockups/device-mockups.min.css">
	<link rel="icon" href="img/icon/cloud.png">
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
                    <li>
                        <a class="page-scroll" href="marketing.php">Marketing</a>
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
if(!isset($_GET['date']) && empty($_GET['date'])) { 
$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !

$yesterday_date->modify('-1 day');
} else { 

echo $_GET['date'];
$yesterday_date = new DateTime($_GET['date'], $set_local_time); // Today's date !
}


$today_date = $yesterday_date->format("Y-m-d");
// $today_date = "2017-05-05";
 // $month_begin = "2017-05-01";
$month_begin = $yesterday_date->format("Y-m-01"); // Beginning of the month
// $year_date_begin = "2016-05-01";
 $year_date_end_temp = date('Y-m-d',strtotime(date($yesterday_date->format("d-m-Y"), time()) . " - 365 day"));
$test_year = new DateTime($year_date_end_temp);
$test_year->modify('-1 day');
$test_year->modify('+1 day');
$year_date_end = $test_year->format("Y-m-d"); 
// $year_date_end = "2016-05-01";
 // Lets try the +1 et -1 thing 
 
 

$countries = get_countries_top_five($today_date);

?>

    <section id="all" class="features" style="padding-top:75px;">
		<form action="index.php" method="get">
			    <div class="form-group row" style="margin-left:5px;">
	<div class="col-sm-4">
<input type="text" class="form-control" placeholder="Pick a date" id="date_search" name="date" />	
	</div>
	<div class="col-sm-8">
	 <button class="btn btn-primary" type="submit">Search</button>
	</div>	
	</div>
	</form>
	
	
	<div id="all_div_countries">
        <div class="container">
                    <div class="section-heading" style="text-align:center;margin-bottom:20px;">
                        <h2>Report from 
						<?php 
	if(!isset($_GET['date']) && empty($_GET['date'])) { 
		echo "yesterday : <b>" . $today_date . "</b>";
	} else { 
		echo "the date : <b>" . $today_date . "</b>";
	}
?>	
				</h2>
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
      <tr id="2_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_refunds($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>
      </tr> 		  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_all_net_sales" style="float:left;" />  <b>Net Sales</b></td>
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
	  
	  
      <tr id="18_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund Gateways</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_gateways($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_gateways_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_gateways_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_gateways_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds_gateways($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_refunds_gateways($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds_gateways($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_gateways_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>
      </tr> 
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_all_gateways" style="float:left;" />  <b>Gateways</b></td>
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
      <tr id="5_all_country" style="display:none;">
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
      <tr id="6_all_country" style="display:none;">
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
	  
      <tr id="7_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund Logistics Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refund_log($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refund_log_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refund_log($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_refund_log($year_date_end, '') . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_all_logs" style="float:left;" />  <b>Total Logistics</b></td>
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
      <tr id="8_all_country" style="display:none;">
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
	  
      <tr id="9_all_country" style="display:none;">
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

	  
      <tr id="10_all_country" style="display:none;">
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

      <tr id="11_all_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Cogs Refunds</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_cogs($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_cogs_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_cogs_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_cogs_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds_cogs($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_refunds_cogs($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds_cogs($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_cogs_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	

      </tr>			  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_all_cogs"  style="float:left;"/>  <b>Total Cogs</b></td>
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
 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_all_marketings"  style="float:left;"/>  <b>Marketing Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_cost($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_marketing_cost_from_total($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_cost_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_marketing_cost_between_two_dates_from_total($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_marketing_cost($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_marketing_cost($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_marketing_cost($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_marketing_cost_from_total($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 	
      <tr style="background-color:#3b5998;display:none;color:#FFFFFF;" id="12_all_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><img src="img/icon/more_white.png" id="more_all_fbmarketings"  style="float:right;"/>  <b>Facebook</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_facebook($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_facebook_from_marketing_cost($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_facebook_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_facebook_between_two_dates_from_marketing_cost($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_facebook($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_total_facebook($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_facebook($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_total_facebook_from_marketing_cost($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 
      <tr style="background-color:#8b9dc3;display:none;color:#FFFFFF;" id="16_all_country">
        <td style="border-right:1px solid #000000;color:white"><b>Facebook Conversion</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_conversion($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_conversion_from_total_facebook($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_conversion_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_conversion_between_two_dates_from_total_facebook($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_facebook_conversion($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_facebook_conversion($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_facebook_conversion($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_facebook_conversion_from_total_facebook($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr>     
      <tr style="background-color:#8b9dc3;display:none;color:#FFFFFF;" id="17_all_country">
        <td style="border-right:1px solid #000000;color:white"><b>Facebook Branding</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_branding($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_branding_from_total_facebook($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_branding_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_branding_between_two_dates_from_total_facebook($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_facebook_branding($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_facebook_branding($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_facebook_branding($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_facebook_branding_from_total_facebook($year_date_end, '') . " %";  } ?>		
		</b></td>		
      </tr>   
      <tr style="background-color:#d34836;display:none;color:#FFFFFF;" id="13_all_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Google Adwords</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_google_adwords($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_google_adwords_from_marketing_cost($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_google_adwords_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_google_adwords_between_two_dates_from_marketing_cost($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_google_adwords($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_google_adwords($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_google_adwords($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_google_adwords_from_marketing_cost($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 
      <tr style="background-color:#0FF006;display:none;color:#FFFFFF;" id="14_all_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Affiliate</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_affiliates_market($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_affiliates_market_from_marketing_cost($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_affiliates_market_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_affiliates_market_between_two_dates_from_marketing_cost($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_affiliates_market($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_affiliates_market($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_affiliates_market($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_affiliates_market_from_marketing_cost($year_date_end, '') . " %";  } ?>		
		</b></td>	
      </tr> 	

      <tr style="background-color:#FE2EF7;display:none;color:#FFFFFF;" id="15_all_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Influencers</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_influencers_market($today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_influencers_market_from_marketing_cost($today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_influencers_market_between_two_dates($month_begin, $today_date, ''); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_influencers_market_between_two_dates_from_marketing_cost($month_begin, $today_date, ''); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_influencers_market($year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_influencers_market($year_date_end, '') . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_influencers_market($year_date_end, ''))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_influencers_market_from_marketing_cost($year_date_end, '') . " %";  } ?>		
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
  </div>
  </section>

    <section id="details" class="features">
		<div id="piece_div_countries">
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
        <td style="border-right:1px solid #000000;"><b>Fullpricing</b></td>
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
      <tr id="2_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_refunds($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>
      </tr> 		  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_<?php echo $country['countrycode']; ?>_net_sales" style="float:left;" />  <b>Net Sales</b></td>
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
	  
	  
      <tr id="18_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund Gateways</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_gateways($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_gateways_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_gateways_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_gateways_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds_gateways($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_refunds_gateways($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds_gateways($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_gateways_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>
      </tr> 
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_<?php echo $country['countrycode']; ?>_gateways" style="float:left;" />  <b>Gateways</b></td>
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
      <tr id="5_<?php echo $country['countrycode']; ?>_country" style="display:none;">
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
      <tr id="6_<?php echo $country['countrycode']; ?>_country" style="display:none;">
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
	  
      <tr id="7_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Refund Logistics Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refund_log($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refund_log_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b>-</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refund_log($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_refund_log($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>-	
		</b></td>

      </tr>	

      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_<?php echo $country['countrycode']; ?>_logs" style="float:left;" />  <b>Total Logistics</b></td>
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
      <tr id="8_<?php echo $country['countrycode']; ?>_country" style="display:none;">
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
	  
      <tr id="9_<?php echo $country['countrycode']; ?>_country" style="display:none;">
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

	  
      <tr id="10_<?php echo $country['countrycode']; ?>_country" style="display:none;">
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

      <tr id="11_<?php echo $country['countrycode']; ?>_country" style="display:none;">
        <td style="border-right:1px solid #000000;"><b>Cogs Refunds</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_cogs($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_cogs_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_refunds_cogs_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_refunds_cogs_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_refunds_cogs($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_refunds_cogs($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_refunds_cogs($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_refunds_cogs_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	

      </tr>			  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_<?php echo $country['countrycode']; ?>_cogs"  style="float:left;"/>  <b>Total Cogs</b></td>
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
 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><img src="img/icon/more_black.png" id="more_<?php echo $country['countrycode']; ?>_marketings"  style="float:left;"/>  <b>Marketing Cost</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_cost($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_marketing_cost_from_total($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_cost_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_marketing_cost_between_two_dates_from_total($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_marketing_cost($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_marketing_cost($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_marketing_cost($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_marketing_cost_from_total($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 	
      <tr style="background-color:#3b5998;display:none;color:#FFFFFF;" id="12_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><img src="img/icon/more_white.png" id="more_<?php echo $country['countrycode']; ?>_fbmarketings"  style="float:right;"/>  <b>Facebook</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_facebook($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_facebook_from_marketing_cost($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_total_facebook_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_total_facebook_between_two_dates_from_marketing_cost($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_total_facebook($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_total_facebook($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_total_facebook($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_total_facebook_from_marketing_cost($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 
      <tr style="background-color:#8b9dc3;display:none;color:#FFFFFF;" id="16_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;color:white"><b>Facebook Conversion</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_conversion($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_conversion_from_total_facebook($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_conversion_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_conversion_between_two_dates_from_total_facebook($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_facebook_conversion($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_facebook_conversion($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_facebook_conversion($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_facebook_conversion_from_total_facebook($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr>     
      <tr style="background-color:#8b9dc3;display:none;color:#FFFFFF;" id="17_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;color:white"><b>Facebook Branding</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_branding($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_branding_from_total_facebook($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_facebook_branding_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_facebook_branding_between_two_dates_from_total_facebook($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_facebook_branding($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_facebook_branding($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_facebook_branding($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_facebook_branding_from_total_facebook($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>		
      </tr>   
      <tr style="background-color:#d34836;display:none;color:#FFFFFF;" id="13_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Google Adwords</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_google_adwords($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_google_adwords_from_marketing_cost($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_google_adwords_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_google_adwords_between_two_dates_from_marketing_cost($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_google_adwords($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_google_adwords($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_google_adwords($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_google_adwords_from_marketing_cost($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 
      <tr style="background-color:#0FF006;display:none;color:#FFFFFF;" id="14_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Affiliate</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_affiliates_market($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_affiliates_market_from_marketing_cost($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_affiliates_market_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_affiliates_market_between_two_dates_from_marketing_cost($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_affiliates_market($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_affiliates_market($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_affiliates_market($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_affiliates_market_from_marketing_cost($year_date_end, $country['countrycode']) . " %";  } ?>		
		</b></td>	
      </tr> 	

      <tr style="background-color:#FE2EF7;display:none;color:#FFFFFF;" id="15_<?php echo $country['countrycode']; ?>_country">
        <td style="border-right:1px solid #000000;text-align:left;color:white"><b>Influencers</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_influencers_market($today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_influencers_market_from_marketing_cost($today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_influencers_market_between_two_dates($month_begin, $today_date, $country['countrycode']); ?> €</b></td>
		<td style="border-right:3px solid #000000;"><b><?php echo get_percentage_influencers_market_between_two_dates_from_marketing_cost($month_begin, $today_date, $country['countrycode']); ?> %</b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_influencers_market($year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_influencers_market($year_date_end, $country['countrycode']) . " €";  } ?></b></td>
		<td><b>
<?php if(empty(get_influencers_market($year_date_end, $country['countrycode']))) { echo "<i>-</i>"; }
		else {
		echo get_percentage_influencers_market_from_marketing_cost($year_date_end, $country['countrycode']) . " %";  } ?>		
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
<div id="chart_country_<?php echo $country['countrycode']; ?>" style="width: 100%;min-height: 450px;"></div>
<?php
}
?>
					
						
						
			
			</div>

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
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
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
		$marketing_cost = get_marketing($date_to_implement, '');			
		echo "['".date('D',strtotime($date_to_implement)). "', ".$sales.", ".$profit.", ".$marketing_cost."],";
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
		$marketing_cost = get_marketing($date_to_implement, $country['countrycode']);		
		echo "['".date('D',strtotime($date_to_implement)). "', ".$sales.", ".$profit.", ".$marketing_cost."],";
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
	moreAboutFields("net_sales", "all", 0, 2, "black");
	moreAboutFields("gateways", "all", 18, 18, "black");
	moreAboutFields("logs", "all", 3, 7, "black");
	moreAboutFields("cogs", "all", 8, 11, "black");
	moreAboutFields("marketings", "all", 12, 15, "black");
	moreAboutFields("fbmarketings", "all", 16, 17, "white");
	<?php 
	$countries = get_countries_top_five($today_date);
foreach($countries as $country) {
?>
	moreAboutFields("net_sales", "<?php echo $country['countrycode']; ?>", 0, 2, "black");
	moreAboutFields("gateways", "<?php echo $country['countrycode']; ?>", 18, 18, "black");	
	moreAboutFields("logs", "<?php echo $country['countrycode']; ?>", 3, 7, "black");
	moreAboutFields("cogs", "<?php echo $country['countrycode']; ?>", 8, 11, "black");
	moreAboutFields("marketings", "<?php echo $country['countrycode']; ?>", 12, 15, "black");
	moreAboutFields("fbmarketings", "<?php echo $country['countrycode']; ?>", 16, 17, "white");	
<?php } ?>
	
	function moreAboutFields(name, country, id_begin, id_end, color) { 
		$('#more_'+country+'_'+name+'').click(function(e) { 
		$('#more_'+country+'_'+name+'').attr('src', 'img/icon/less_'+color+'.png');
		$('#more_'+country+'_'+name+'').attr('id', 'less_'+country+'_'+name+'');
			for (var i = id_begin; i <= id_end; i++) {  
			$('#'+i+'_'+country+'_country').css('display', '');
			}
			lessAboutFields(name, country, id_begin, id_end, color);
		});
	
	}
	function lessAboutFields(name, country, id_begin, id_end, color) { 
		$('#less_'+country+'_'+name+'').click(function(e) { 
		$('#less_'+country+'_'+name+'').attr('src', 'img/icon/more_'+color+'.png');
		$('#less_'+country+'_'+name+'').attr('id', 'more_'+country+'_'+name+'');
			for (var i = id_begin; i <= id_end; i++) {
			$('#'+i+'_'+country+'_country').css('display', 'none');
			}		
			moreAboutFields(name, country, id_begin, id_end, color);
		});

	}
	

	</script>
	<script>
   $( function() {
        $( "#date_search" ).datepicker({
            changeYear: true, // afficher un selecteur d'année
            changeMonth: true,
			dateFormat : "yy-mm-dd"
        });
    $( "#locale" ).on( "change", function() {
      $( "#date_search" ).datepicker( "option",
        $.datepicker.regional[ $( this ).val() ] );
    });
  } ); 	
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
