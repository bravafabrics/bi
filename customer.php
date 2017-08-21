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
                        <a class="page-scroll" href="index.php">Sales Home</a>
                    </li>	
                    <li>
                        <a class="page-scroll" href="customer.php">Home</a>
                    </li>					
                    <li>
                        <a class="page-scroll" href="recurrency.php">Recurrency</a>
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
 $year_date_begin_temp = date('Y-m-d',strtotime(date($yesterday_date->format("Y-m-01"), time()) . " - 365 day"));
 $year_date_end_temp = date('Y-m-d',strtotime(date($yesterday_date->format("d-m-Y"), time()) . " - 365 day"));
$test_year = new DateTime($year_date_end_temp);
$test_year->modify('-1 day');
$test_year->modify('+1 day');
$test_year_begin = new DateTime($year_date_begin_temp);
$test_year_begin->modify('-1 day');
$test_year_begin->modify('+1 day');
$year_date_begin = $test_year_begin->format("Y-m-d"); 
$year_date_end = $test_year->format("Y-m-d");
// $year_date_end = "2016-05-01";
 // Lets try the +1 et -1 thing 
 
 

$countries = get_countries_top_five_for_cac($today_date);

?>

    <section id="all" class="features" style="padding-top:75px;">
		<form action="customer.php" method="get">
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
        <th style="text-align:right;border-right:1px solid #000000;">This month</th>
		<th style="text-align:right;border-right:1px solid #000000;">Last year</th>
      </tr>
    </thead>
    <tbody style="text-align:right;">
	  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><b># New Customers</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  
	  

	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>Average Order Value</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_average_order_value_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_average_order_value_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  


      <tr class="active">
        <td style="border-right:1px solid #000000;"> <b>Marketing Spend</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  	  


		  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CAC</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cac_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_cac_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  	  
 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CLTV</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cltv_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_cltv_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  	


	  
      <tr>
        <td style="border-right:1px solid #000000;"><b>Ratio</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio($today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio_between_two_dates($month_begin, $today_date, ''); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_ratio_between_two_dates($year_date_begin, $year_date_end, ''))) { echo "<i>0</i>"; }
		else {
		echo get_ratio_between_two_dates($year_date_begin, $year_date_end, '') . "";  } ?></b></td>
      </tr> 
	  


	  
    </tbody>
  </table>
  </div>
     <div id="chart_all_countries" style="width: 100%;min-height: 450px;"></div>

  </div>
  </div>
  </section>
  
  
    <section id="no_es" class="features">
		<div id="piece_div_countries">
        <div class="container">  
<div id="country-noes">
<p style="font-size:25px;text-align:center;"><img src="img/flags/noes.png" /> <u>All Countries except ES</u></p>
<div class="text-table">
		 <table class="table table-hover" style="text-align:center;">
    <thead>
      <tr class="active">
        <th style="text-align:right;border-right:1px solid #000000;"></th>
        <th style="text-align:right;border-right:1px solid #000000;">Yesterday</th>
        <th style="text-align:right;border-right:1px solid #000000;">This month</th>
		<th style="text-align:right;border-right:1px solid #000000;">Last year</th>
      </tr>
    </thead>
    <tbody style="text-align:right;">
	  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><b># New Customers</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  
	  

	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>Average Order Value</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_average_order_value_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_average_order_value_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  


      <tr class="active">
        <td style="border-right:1px solid #000000;"> <b>Marketing Spend</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  	  


		  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CAC</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cac_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_cac_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  	  
 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CLTV</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cltv_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_cltv_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  	


	  
      <tr>
        <td style="border-right:1px solid #000000;"><b>Ratio</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio($today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio_between_two_dates($month_begin, $today_date, 'noes'); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_ratio_between_two_dates($year_date_begin, $year_date_end, 'noes'))) { echo "<i>0</i>"; }
		else {
		echo get_ratio_between_two_dates($year_date_begin, $year_date_end, 'noes') . "";  } ?></b></td>
      </tr> 
	  


	  
    </tbody> 
  </table>
</div>

</div>
<div id="chart_country_noes" style="width: 100%;min-height: 450px;"></div>
					
						
						
			
			</div>

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
        <th style="text-align:right;border-right:1px solid #000000;">This month</th>
		<th style="text-align:right;border-right:1px solid #000000;">Last year</th>
      </tr>
    </thead>
    <tbody style="text-align:right;">
	  

      <tr class="active">
        <td style="border-right:1px solid #000000;"><b># New Customers</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_number_new_customers_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_number_new_customers_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
      </tr> 
	  
	  

	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>Average Order Value</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_average_order_value_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_average_order_value_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_average_order_value_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
      </tr> 
	  


      <tr class="active">
        <td style="border-right:1px solid #000000;"> <b>Marketing Spend</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_marketing_spend_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_marketing_spend_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
      </tr> 
	  	  


		  
	  
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CAC</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cac_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cac_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_cac_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
      </tr> 
	  	  
 
      <tr class="active">
        <td style="border-right:1px solid #000000;"><b>CLTV</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_cltv_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_cltv_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_cltv_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
      </tr> 
	  	


	  
      <tr>
        <td style="border-right:1px solid #000000;"><b>Ratio</b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio($today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php echo get_ratio_between_two_dates($month_begin, $today_date, $country['countrycode']); ?></b></td>
		<td style="border-right:1px solid #000000;"><b><?php if(empty(get_ratio_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']))) { echo "<i>0</i>"; }
		else {
		echo get_ratio_between_two_dates($year_date_begin, $year_date_end, $country['countrycode']) . "";  } ?></b></td>
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
            <p>&copy; 2017 BravaFabrics & Bootstrap Template All Rights Reserved. (# means : number)</p>
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
$date_begin_correct_format = new DateTime($month_begin, $set_local_time);
$date_end_correct_format = date('d-m-Y',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " - 12 months"));
$date_begin_to_show = $date_begin_correct_format->format("d-m-Y");
$date_begin_correct_format = new DateTime($date_end_correct_format, $set_local_time); 
?>
            var data_all_countries = google.visualization.arrayToDataTable([
          ['Month', 'CAC', 'CLTV', 'CLTV-CAC'],
		  <?php

for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
	// END OF THE MONTH : 
	$end_of_month = $day_to_add + 1;
	$date_to_implement_end = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$end_of_month . " months - 1 days"));
		$cac = get_cac_between_two_dates($date_to_implement, $date_to_implement_end, '');
		$cltv = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, '');
		$diff = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, '') - get_cac_between_two_dates($date_to_implement, $date_to_implement_end, ''); 		
		echo "[{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'}, ".$cac.", ".$cltv.", ".$diff."],";
}

		  ?>
        ]);
        var options_all_countries = {
          title: 'All Countries Report from <?php echo $date_begin_correct_format->format("d-m-Y") . " to " .$date_begin_to_show; ?>',
          curveType: 'function',
          vAxes: {0: {
                      gridlines: {color: 'transparent'},
                      },
                  1: {gridlines: {color: 'transparent'}},
                  },
          series: {0: {targetAxisIndex:0},
                   1:{targetAxisIndex:1}
		},	
    trendlines: { 
	0: {color : '#8080ff', visibleInLegend: true, labelInLegend: 'Trend For CAC'}, 
	1 : {color : '#ff8080', visibleInLegend: true, labelInLegend: 'Trend For CLTV'} },
hAxis: { 
ticks: [

<?php 

			for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
echo "{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'},";
			} ?>
] 
},		
		  legend: { position: 'top', alignment: 'start' }}
      var chart = new google.visualization.LineChart(document.getElementById('chart_all_countries'));
      chart.draw(data_all_countries, options_all_countries);

	  
            var data_noes_country = google.visualization.arrayToDataTable([
          ['Month', 'CAC', 'CLTV', 'CLTV-CAC'],
		  <?php

for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
	// END OF THE MONTH : 
	$end_of_month = $day_to_add + 1;
	$date_to_implement_end = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$end_of_month . " months - 1 days"));
		$cac = get_cac_between_two_dates($date_to_implement, $date_to_implement_end, 'noes');
		$cltv = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, 'noes');
		$diff = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, 'noes') - get_cac_between_two_dates($date_to_implement, $date_to_implement_end, 'noes');			
		echo "[{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'}, ".$cac.", ".$cltv.", ".$diff."],";
}

		  ?>
        ]);
        var options_noes_country = {
          title: 'Report for All Countries Except ES from <?php echo $date_begin_correct_format->format("d-m-Y") . " to " .$date_begin_to_show; ?>',
          curveType: 'function',
          vAxes: {0: {
                      gridlines: {color: 'transparent'},
                      },
                  1: {gridlines: {color: 'transparent'}},
                  },
          series: {0: {targetAxisIndex:0},
                   1:{targetAxisIndex:1}
		},	
    trendlines: { 
	0: {color : '#8080ff', visibleInLegend: true, labelInLegend: 'Trend For CAC'}, 
	1 : {color : '#ff8080', visibleInLegend: true, labelInLegend: 'Trend For CLTV'} },
hAxis: { 
ticks: [

<?php 

			for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
echo "{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'},";
			} ?>
] 
},			
		  legend: { position: 'top', alignment: 'start' }}
      var chart = new google.visualization.LineChart(document.getElementById('chart_country_noes'));
      chart.draw(data_noes_country, options_noes_country);	  
	  
	  
// Now lets plot for each the countries
<?php 
$countries = get_countries_top_five_for_cac($today_date);
foreach($countries as $country) {

?>
            var data_each_country = google.visualization.arrayToDataTable([
          ['Month', 'CAC', 'CLTV', 'CLTV-CAC'],
		  <?php

for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
	// END OF THE MONTH : 
	$end_of_month = $day_to_add + 1;
	$date_to_implement_end = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$end_of_month . " months - 1 days"));
		$cac = get_cac_between_two_dates($date_to_implement, $date_to_implement_end, $country['countrycode']);
		$cltv = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, $country['countrycode']);
		$diff = get_cltv_between_two_dates($date_to_implement, $date_to_implement_end, $country['countrycode']) - get_cac_between_two_dates($date_to_implement, $date_to_implement_end, $country['countrycode']);			
		echo "[{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'}, ".$cac.", ".$cltv.", ".$diff."],";
}

		  ?>
        ]);
        var options_each_country = {
          title: 'Report for the country <?php echo $country['countrycode']; ?> from <?php echo $date_begin_correct_format->format("d-m-Y") . " to " .$date_begin_to_show; ?>',
          curveType: 'function',
          vAxes: {0: {
                      gridlines: {color: 'transparent'},
                      },
                  1: {gridlines: {color: 'transparent'}},
                  },
          series: {0: {targetAxisIndex:0},
                   1:{targetAxisIndex:1}
		},	
    trendlines: { 
	0: {color : '#8080ff', visibleInLegend: true, labelInLegend: 'Trend For CAC'}, 
	1 : {color : '#ff8080', visibleInLegend: true, labelInLegend: 'Trend For CLTV'} },
hAxis: { 
ticks: [

<?php 

			for ($day_to_add = 0; $day_to_add < 12; $day_to_add++) {
	$date_to_implement = date('Y-m-d',strtotime(date($date_begin_correct_format->format("Y-m-d"), time()) . " + ".$day_to_add . " months")); // BEGIN OF THE Month
echo "{v:".$day_to_add.", f:'".date('M',strtotime($date_to_implement)). "'},";
			} ?>
] 
},			
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
