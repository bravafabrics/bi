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
                <a class="navbar-brand page-scroll" href="cost.php"><img src="img/bflogo.jpg" style="width:50%;" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="index.php">Home</a>
                    </li>				
                    <li>
                        <a class="page-scroll" href="#gateways_anchor" id="gateways">Gateways</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#courier_fees_anchor" id="logistics">Courier Fees</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#courier_extra_fees_anchor" id="courier_extra">Courier Extra Fees</a>
                    </li>					
                    <li>
                        <a class="page-scroll" href="#courier_sum_anchor" id="courier_sum">Courier Sum</a>
                    </li>					
                    <li>
                        <a class="page-scroll" href="#zones_anchor" id="zones">Zones</a>
                    </li>	
                    <li>
                        <a class="page-scroll" href="#handling_anchor" id="handling">Handling Costs</a>
                    </li>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<div class="loading" style="display:none;" id="load"></div>
    <section id="gateways_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  

<table class="table table-striped table-inverse">
  <thead>
    <tr>
      <th>Date</th>
      <th>Payment Method</th>
      <th>Percentage</th>
      <th>Fix</th>
		<th>Edit</th>	  
    </tr>
  </thead>
  <tbody id="content_table_gateways">

  </tbody>
</table>

<div id="edit_payment_method"></div>

		
    <div class="form-group row">
	<div class="col-sm-2">
      <input type="text" class="form-control" id="name_payment" placeholder="Name of the method">
	 </div> 
      <div class="col-sm-10">
        <button class="btn btn-primary" id="more_field">+</button>
      </div>
    </div>
	
	<div id="form_to_add">
	</div>
	  
	  
<br />
    <div class="form-group" style="text-align:center;display:none;" id="send_button">
        <button class="btn btn-primary" id="send">Send it</button>
		</form>
    </div>
  </form>
  </div>	
    </section>

    <section id="logistics_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  
	<!-- HERE ARE THE LOGISTICS COST -->
	
    <div class="form-group row">

<select class="form-control" id="service_name_log">
<option value="0" selected="">Service Name</option>
<?php 
include_once("queries_database.php");
$services = get_all_service();
foreach ($services as $service) { 
?>

	<option value="<?php echo $service['service']; ?>"><?php echo $service['service']; ?></option>
<?php
}

?>
</select>


<div id="input_countrycode_after_select"></div>	  
    
	<div id="weight_and_prices"><br /></div>
	
	</div>
	<div id="button_add_for_courier"></div>
        </div>	
    </section>

    <section id="courier_sum_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  
    <div class="form-group row">

<select class="form-control" id="service_name_sum_courier">
<option value="0" selected="">Please, select a service</option>
<?php 

foreach ($services as $service) { 
?>

	<option value="<?php echo $service['service']; ?>"><?php echo $service['service']; ?></option>
<?php
}

?>
</select>


<br />


		<div id="table_courier_sum"></div>
</div>
        </div>	
    </section>		
	
	
    <section id="courier_extra_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  


<table class="table table-striped table-inverse">
  <thead>
    <tr>
      <th>Date</th>
      <th>Service</th>
      <th>Percentage</th>
      <th>Fix</th>
		<th>Edit</th>	  
    </tr>
  </thead>
  <tbody id="content_table_extra">

  </tbody>
</table>	


<div id="edit_service_extra"></div>

		
    <div class="form-group row">
	<div class="col-sm-2">
	<form action="extra_page/send_extra_ship.php" method="post">
	<select class="form-control" name="service_name_extra">
<option value="0" selected="">Service Name</option>
<?php 
foreach ($services as $service) { 
?>

	<option value="<?php echo $service['service']; ?>"><?php echo $service['service']; ?></option>
<?php
}

?>
</select>
	
	 </div> 
      <div class="col-sm-10">
        <button class="btn btn-primary" type="submit">+</button>
		</form>
      </div>
    </div>
	
	<div id="form_to_add_extra">
	</div>	

<br />
    <div class="form-group" style="text-align:center;display:none;" id="send_button_extra">
        <button class="btn btn-primary" id="send_extra">Send it</button>
		</form>
    </div>	
	
        </div>	
    </section>		
	
	    <section id="handling_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  
		
<table class="table table-striped table-inverse">
  <thead>
    <tr>
      <th>Date</th>
      <th>Packaging Cost</th>
      <th>Handling Cost</th>  
	  <th>Preparation Cost</th>  
	  <th>Shipping Materals Cost</th>  
	  <th>Edit</th>  	  
    </tr>
  </thead>
  <tbody id="content_table_handling">

  </tbody>
</table>
<div id="edit_handling"></div>
	
    <div class="form-group row" id="form_handling">
	<div class="col-sm-2" id="handling_form_div">
	<input type="text" class="form-control" id="packaging_cost" placeholder="Packaging Cost">
	 </div> 
      <div class="col-sm-2">
       <input type="text" class="form-control" id="handling_cost" placeholder="Handling Cost">
      </div>
      <div class="col-sm-2">
       <input type="text" class="form-control" id="preparation_cost" placeholder="Preparation Cost">
      </div>	  
      <div class="col-sm-3">
       <input type="text" class="form-control" id="shipping_materals_cost" placeholder="Shipping Materals Cost">
      </div>	
	<div class="col-sm-2">
	<button class="btn btn-primary" id="add_handling">Add</button>
	 </div> 	  
    </div>	

	
        </div>	
		</div>
		</section>
		
		
		
    <section id="zones_div" class="features" style="padding-top:65px;display:none;"> 
        <div class="container">  
	<!-- HERE ARE THE ZONES LOGISTICS  -->
	
<table class="table table-striped table-inverse">
  <thead>
    <tr>
      <th>Countrycode</th>
      <th>Service</th>
      <th>Zone</th>  
      <th>Delete</th>  	  
    </tr>
  </thead>
  <tbody id="content_table_zones">

  </tbody>
</table>
	
    <div class="form-group row">
	<div class="col-sm-2" id="zones_form_div">
	
	 </div> 
      <div class="col-sm-6">
       <input type="text" class="form-control" id="service" placeholder="Name of the service">
      </div>
      <div class="col-sm-4">
       <input type="text" class="form-control" id="zone" placeholder="Zone">
      </div>	  
    </div>	
	<div style="text-align:center;">
	        <button class="btn btn-primary" id="add_zones">Add</button>
</div>
	
        </div>	
    </section>		
	
    <footer>
        <div class="container">
            <p id="item_info">&copy; 2017 BravaFabrics & Bootstrap Template All Rights Reserved.</p>
        </div>
    </footer>

    
	<!-- END ploting -->
    <!-- Bootstrap Core JavaScript -->
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

    if($('#gateways').attr('href') == 'gateways_anchor'){
        $("#gateways").click();
    }

// 

</script>
<script>
// Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
// Firefox 1.0+
isFirefox = typeof InstallTrigger !== 'undefined';
// Safari 3.0+
isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
// Internet Explorer 6-11
isIE = /*@cc_on!@*/false || !!document.documentMode;
// Edge 20+
isEdge = !isIE && !!window.StyleMedia;
// Chrome 1+
isChrome = !!window.chrome && !!window.chrome.webstore;
// Blink engine detection
isBlink = (isChrome || isOpera) && !!window.CSS;

if(!isFirefox) { 
$('#item_info').html('<div style=\"text-align:center;\"><b>Please use Firefox</b></div>');

}

</script>
<script>
$.ajax({
        type: 'GET',
		cache: false,
        url: 'ajax/handling_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },		
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
	$('#content_table_handling').append(' <tr> <th scope=\"row\">'+responseObj[iter].date+'</th> <td>'+responseObj[iter].packaging+'</td><td>'+responseObj[iter].handling+' </td><td>'+responseObj[iter].preparation+'</td><td>'+responseObj[iter].shipping_materals+'</td><td><button class="btn btn-primary" id="edit_date_handling_date_'+responseObj[iter].date+'">E</button></td></tr>');			
		edit_content_handling(responseObj[iter].date, responseObj[iter].packaging, responseObj[iter].handling, responseObj[iter].preparation, responseObj[iter].shipping_materals);
		
		}
				  
                  }           
       });

$('#add_handling').click(function(e) { 

$('#load').css('display', '');

	
	var packaging_cost = $('#packaging_cost').val();
	var handling_cost = $('#handling_cost').val();
	var preparation_cost = $('#preparation_cost').val();
	var shipping_materals_cost = $('#shipping_materals_cost').val();	
	var isEmpty = false;
if(!packaging_cost) { $('#packaging_cost').css('border', '1px solid red'); $('#load').css('display', 'none'); isEmpty = true; } 
if(!handling_cost) { $('#handling_cost').css('border', '1px solid red'); $('#load').css('display', 'none'); isEmpty = true; } 
if(!shipping_materals_cost) { $('#shipping_materals_cost').css('border', '1px solid red'); $('#load').css('display', 'none'); isEmpty = true; } 
if(!preparation_cost) { $('#preparation_cost').css('border', '1px solid red'); $('#load').css('display', 'none'); isEmpty = true; } 

if(!isEmpty) {
	packaging_cost = packaging_cost.replace(/,/g, '.');
	handling_cost = handling_cost.replace(/,/g, '.');
	shipping_materals_cost = shipping_materals_cost.replace(/,/g, '.');
	preparation_cost = preparation_cost.replace(/,/g, '.');	
	
$.ajax({
        type: 'POST',
        url: 'ajax/handling_insert_query.php',
       data: { packaging_cost : packaging_cost, handling_cost : handling_cost, shipping_materals_cost : shipping_materals_cost, preparation_cost : preparation_cost },	
        success: function(data)
                  {
						  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_handling').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, for today there is already the same handling</div><br /><br />");
					$('#add_handling').css('display', 'none');
					setTimeout("location.href = 'cost.php';", 2500);				  
					  
					  } else {				  
					  
					  $('#load').css('display', 'none');
                    $('#form_handling').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The handling cost has correctly been insered in the datawarehouse table</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 1500);
					  }
				  }           
       });

}



});


function edit_content_handling(date, packaging, handling, preparation, shipping_materals) {

			$('#edit_date_handling_date_'+date).click(function(e) { 
		         $('html, body').animate({
              scrollTop: $("#edit_handling").offset().top
        }, 1000); 	
		$('#edit_handling').html('<h4 style=\"padding-left:30px;\">Cost of '+date+'</h4><div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+date+'_packaging_update\" placeholder=\"'+packaging+'\" value=\"'+packaging+'\"> </div><div class=\"form_group\"> <input type=\"text\" class=\"form-control\" id=\"'+date+'_handling_update\" placeholder=\"'+handling+'\" value=\"'+handling+'\"></div> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+date+'_preparation_update\" placeholder=\"'+preparation+'\" value=\"'+preparation+'\"> </div><div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+date+'_shipping_materals_update\" placeholder=\"'+shipping_materals+'\" value=\"'+shipping_materals+'\"> </div><button class="btn btn-primary" id="update_handling_date_'+date+'">Update</button></div><hr>');
		});
		
		
 
$(document).on('click', '#update_handling_date_'+date, function(){ 
	var upd_packaging_cost = $('#'+date+'_packaging_update').val();
	var upd_handling_cost = $('#'+date+'_handling_update').val();
	var upd_preparation_cost = $('#'+date+'_preparation_update').val();
	var upd_shipping_materals_cost = $('#'+date+'_shipping_materals_update').val();
	upd_packaging_cost = upd_packaging_cost.replace(/,/g, '.');
	upd_handling_cost = upd_handling_cost.replace(/,/g, '.');
	upd_shipping_materals_cost = upd_shipping_materals_cost.replace(/,/g, '.');
	upd_preparation_cost = upd_preparation_cost.replace(/,/g, '.');		
     $('#load').css('display', '');
	 
$.ajax({
        type: 'POST',
        url: 'ajax/handling_update_query.php',
       data: {date : date, packaging_cost: upd_packaging_cost, handling_cost: upd_handling_cost, preparation_cost : upd_preparation_cost, shipping_materals_cost : upd_shipping_materals_cost },	
        success: function(data)
                  {
					  $('#load').css('display', 'none');
					  $('#edit_handling').html('<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The handling for the date : '+date + ' has correctly been updated in the datawarehouse table</div><br /><br />');
					setTimeout("location.href = 'cost.php';", 1500);
				 }           
       });	 
	 
});  
 
}

</script>
<script>
$.ajax({
        type: 'GET',
		cache: false,
        url: 'ajax/shipping_extra_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },		
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
			var service_replace = responseObj[iter].service.replace(/ /g,"_").replace(/\(/g, "__").replace(/\)/g, "--");
	$('#content_table_extra').append(' <tr> <th scope=\"row\">'+responseObj[iter].date+'</th> <td>'+responseObj[iter].service+'</td><td>'+responseObj[iter].percentage+' %</td><td>'+responseObj[iter].fix+'</td><td><form action=\"extra_page/edit_extra_ship.php\" method=\"post\"><input type=\"hidden\" value=\"'+responseObj[iter].service+'\" name=\"service_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].date+'\" name=\"date_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].percentage+'\" name=\"perc_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].fix+'\" name=\"fix_edit\" /><button class="btn btn-primary" type="submit">E</button></form></td></tr>');	
		//edit_content_extra(responseObj[iter].date, service_replace, responseObj[iter].percentage, responseObj[iter].fix);
		
		}
				  
                  }           
       });
	   
$('#more_field_extra').click(function(e) {

var name_of_the_field = $('#service_name_extra').val();
name_of_the_field=name_of_the_field.replace(/ /g,"_").replace(/\(/g, "__").replace(/\)/g, "--");
	if(name_of_the_field != 0) {
all_the_name_fields.push(name_of_the_field);
var name_without_troubles = $('#service_name_extra').val();
$('#service_name_extra').val("0");
$('#send_button_extra').css('display', '');
$('#form_to_add_extra').append('<h4 style=\"padding-left:30px;\">'+name_without_troubles+'</h4> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+name_of_the_field+'_perc\" placeholder=\"Percentage\" /> </div><div class=\"form_group\"> <input type=\"text\" class=\"form-control\" id=\"'+name_of_the_field+'_fix\" placeholder=\"Fix for transactions\" /> </div>');
	} else {
		$('#service_name_extra').css('border', 'solid 1px red'); 
	}
});	   


$('#send_extra').click(function(e) { 

$('#load').css('display', '');
var numberOfField = all_the_name_fields.length;
for (var i = 0; i<numberOfField; i++) {
	var perc = $('#'+all_the_name_fields[i]+'_perc').val();
	var fix = $('#'+all_the_name_fields[i]+'_fix').val();
if(!perc) { $('#'+all_the_name_fields[i]+'_perc').css('border', '1px solid red'); $('#load').css('display', 'none'); } 
if(!fix) { $('#'+all_the_name_fields[i]+'_fix').css('border', '1px solid red'); $('#load').css('display', 'none'); } 

if(fix && perc) {
	perc = perc.replace(/,/g, '.');
	fix = fix.replace(/,/g, '.');
$.ajax({
        type: 'POST',
        url: 'ajax/shipping_extra_insert_query.php',
       data: {service: all_the_name_fields[i], percentage: perc, fix : fix},	
        success: function(data)
                  {
						  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_to_add_extra').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, for today there is already the same service</div><br /><br />");
					$('#send_button_extra').css('display', 'none');
					setTimeout("location.href = 'cost.php';", 2500);				  
					  
					  } else {				  
					  
					  $('#load').css('display', 'none');
                    $('#courier_extra_div').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The shipping extra has correctly been insered in the datawarehouse table</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 1500);
					  }
				  }           
       });

}	   
}


});

function edit_content_extra(date, service, perc, fix) {
			$('#edit_date_'+date+'_service_'+service+'').click(function(e) { 
		         $('html, body').animate({
              scrollTop: $("#edit_service_extra").offset().top
        }, 1000); 	
		var serviceWithTheRightSyntax = service.replace(/_/g," ").replace(/0/g, "__").replace(/1/g, "--");
		$('#edit_service_extra').html('<h4 style=\"padding-left:30px;\">'+serviceWithTheRightSyntax+'</h4> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+service+'_perc_update\" placeholder=\"'+perc+'%\" value=\"'+perc+'\"> </div><div class=\"form_group\"> <input type=\"text\" class=\"form-control\" id=\"'+service+'_fix_update\" placeholder=\"'+fix+'\" value=\"'+fix+'\"> </div><br /><div class=\"form_group\" style=\"text-align:center;\"><button class="btn btn-primary" id="update_'+service+'_date_'+date+'">Update</button></div><hr>');
		});

$(document).on('click', '#update_'+service+'_date_'+date, function(){ 
var new_perc = $('#'+service+'_perc_update').val();
var new_fix = $('#'+service+'_fix_update').val();
	new_perc = new_perc.replace(/,/g, '.');
	new_fix = new_fix.replace(/,/g, '.');
     $('#load').css('display', '');
	 
$.ajax({
        type: 'POST',
        url: 'ajax/shipping_extra_update_query.php',
       data: {date : date, service: service, percentage: new_perc, fix : new_fix},	
        success: function(data)
                  {
					  $('#load').css('display', 'none');
					  $('#edit_service_extra').html('<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The extra for the service : '+service + ' has correctly been updated in the datawarehouse table</div><br /><br />');
					console.log(date);
					//setTimeout("location.href = 'cost.php';", 1500);
				 }           
       });	 
	 
}); 
}



</script>
<script>

// About gateways select
$.ajax({
        type: 'GET',
        url: 'ajax/gateway_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },	
		cache: false,
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
			var payment_method_replace = responseObj[iter].payment_method.replace(/ /g,"_").replace(/\(/g, "0").replace(/\)/g, "1");
	$('#content_table_gateways').append(' <tr> <th scope=\"row\">'+responseObj[iter].date+'</th> <td>'+responseObj[iter].payment_method+'</td><td>'+responseObj[iter].percentage+' %</td><td>'+responseObj[iter].fix+'</td><td><button class="btn btn-primary" id="edit_date_'+responseObj[iter].date+'_payment_'+payment_method_replace+'">E</button></td></tr>');			
		edit_content(responseObj[iter].date, payment_method_replace, responseObj[iter].percentage, responseObj[iter].fix);
		
		}
				  
                  }           
       });
	   
	   

function edit_content(date, payment_method, perc, fix) {
			$('#edit_date_'+date+'_payment_'+payment_method+'').click(function(e) { 
		         $('html, body').animate({
              scrollTop: $("#edit_payment_method").offset().top
        }, 1000); 	
		var payment_methodWithTheRightSyntax = payment_method.replace(/_/g," ").replace(/0/g, "(").replace(/1/g, ")");
		$('#edit_payment_method').html('<h4 style=\"padding-left:30px;\">'+payment_methodWithTheRightSyntax+'</h4> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+payment_method+'_perc_update\" placeholder=\"'+perc+'%\" value=\"'+perc+'\"> </div><div class=\"form_group\"> <input type=\"text\" class=\"form-control\" id=\"'+payment_method+'_fix_update\" placeholder=\"'+fix+'\" value=\"'+fix+'\"> </div><br /><div class=\"form_group\" style=\"text-align:center;\"><button class="btn btn-primary" id="update_'+payment_method+'_date_'+date+'">Update</button></div><hr>');
		});

$(document).on('click', '#update_'+payment_method+'_date_'+date, function(){ 
var new_perc = $('#'+payment_method+'_perc_update').val();
var new_fix = $('#'+payment_method+'_fix_update').val();
	new_perc = new_perc.replace(/,/g, '.');
	new_fix = new_fix.replace(/,/g, '.');
     $('#load').css('display', '');
	 
$.ajax({
        type: 'POST',
        url: 'ajax/gateway_update_query.php',
       data: {date : date, payment_method: payment_method, percentage: new_perc, fix : new_fix},	
        success: function(data)
                  {
					  $('#load').css('display', 'none');
					  $('#edit_payment_method').html('<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The payment methods : '+payment_method + ' has correctly been updated in the datawarehouse table</div><br /><br />');
					setTimeout("location.href = 'cost.php';", 1500);
				 }           
       });	 
	 
}); 
}



var all_the_name_fields = [
];

$('#handling').click(function(e) { 
$('#logistics_div').css('display', 'none');
$('#gateways_div').css('display', 'none');
$('#zones_div').css('display', 'none');
$('#courier_sum_div').css('display', 'none');
$('#courier_extra_div').css('display', 'none');
$('#handling_div').css('display', '');
});

$('#courier_extra').click(function(e) { 
$('#logistics_div').css('display', 'none');
$('#gateways_div').css('display', 'none');
$('#zones_div').css('display', 'none');
$('#courier_sum_div').css('display', 'none');
$('#courier_extra_div').css('display', '');
$('#handling_div').css('display', 'none');
});

$('#courier_sum').click(function(e) {
$('#logistics_div').css('display', 'none');
$('#gateways_div').css('display', 'none');
$('#zones_div').css('display', 'none');
$('#courier_sum_div').css('display', '');
$('#courier_extra_div').css('display', 'none');
$('#handling_div').css('display', 'none');

});

$('#zones').click(function(e) {
$('#logistics_div').css('display', 'none');
$('#gateways_div').css('display', 'none');
$('#zones_div').css('display', '');
$('#courier_sum_div').css('display', 'none');
$('#courier_extra_div').css('display', 'none');

$('#handling_div').css('display', 'none');

});

$('#gateways').click(function(e) {


$('#logistics_div').css('display', 'none');
$('#gateways_div').css('display', '');
$('#zones_div').css('display', 'none');
$('#courier_sum_div').css('display', 'none');
$('#courier_extra_div').css('display', 'none');

$('#handling_div').css('display', 'none');



});

$('#logistics').click(function(e) {


$('#gateways_div').css('display', 'none');
$('#logistics_div').css('display', '');
$('#zones_div').css('display', 'none');
$('#courier_sum_div').css('display', 'none');
$('#courier_extra_div').css('display', 'none');

$('#handling_div').css('display', 'none');


});

$('#more_field').click(function(e) {

var name_of_the_field = $('#name_payment').val();
name_of_the_field=name_of_the_field.replace(/ /g,"_").replace(/\(/g, "0").replace(/\)/g, "1");
	if(name_of_the_field) {
all_the_name_fields.push(name_of_the_field);
var name_without_troubles = $('#name_payment').val();
$('#name_payment').val("");
$('#send_button').css('display', '');
$('#form_to_add').append('<h4 style=\"padding-left:30px;\">'+name_without_troubles+'</h4> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+name_of_the_field+'_perc\" placeholder=\"Percentage\" /> </div><div class=\"form_group\"> <input type=\"text\" class=\"form-control\" id=\"'+name_of_the_field+'_fix\" placeholder=\"Fix for transactions\" /> </div>');
	} else {
		$('#name_payment').css('border', 'solid 1px red'); 
	}
});

$('#send').click(function(e) { 

$('#load').css('display', '');
var numberOfField = all_the_name_fields.length;
for (var i = 0; i<numberOfField; i++) {
	var perc = $('#'+all_the_name_fields[i]+'_perc').val();
	var fix = $('#'+all_the_name_fields[i]+'_fix').val();
if(!perc) { $('#'+all_the_name_fields[i]+'_perc').css('border', '1px solid red'); $('#load').css('display', 'none'); } 
if(!fix) { $('#'+all_the_name_fields[i]+'_fix').css('border', '1px solid red'); $('#load').css('display', 'none'); } 

if(fix && perc) {
	perc = perc.replace(/,/g, '.');
	fix = fix.replace(/,/g, '.');
$.ajax({
        type: 'POST',
        url: 'ajax/gateway_insert_query.php',
       data: {payment_method: all_the_name_fields[i], percentage: perc, fix : fix},	
        success: function(data)
                  {
					  
								  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, for today there is already the same payment method</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 2500);	
			$('#send_button').css('display', 'none');					
					  
					  } else { 			  
					  $('#load').css('display', 'none');
                    $('#gateways_div').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The payment methods are correctly been insered in the datawarehouse table</div><br /><br />");
					  setTimeout("location.href = 'cost.php';", 1500); }
				  }           
       });

}	   
}


});

</script>

<script>

// All about the zones thing 




function getAllCountries() {
	// Its a very bad thing to go an asynchronous, we will lose some perfs !
	var theFullOption;
	$.ajax({
        type: 'GET',
		async : false,
		cache: false,
        url: 'ajax/zone_get_countrycode.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },		
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
			for(var i = 0; i < responseObj.length; i++) {
				theFullOption += '<option value=\"'+responseObj[i].iso_code+'\">'+responseObj[i].iso_code+'</option>';
			}

				  
                  }           
       });
	
return theFullOption;
	}

var theFullSelectForTheCountry = '<select class=\"form-control\" id=\"country_code\"><option value=\"0\" selected=\"\">Country</option>';
theFullSelectForTheCountry += getAllCountries();
theFullSelectForTheCountry += '<option value=\"ZZ\">ZZ (Default)</option>';
theFullSelectForTheCountry += '</select>';
$('#zones_form_div').append(theFullSelectForTheCountry);


	$('#add_zones').click(function(e) {
		$('#load').css('display', '');
		// Checking mistakes
			var mistake = false;
		var country = $('#country_code').val();
		var service = $('#service').val();
		var zone = $('#zone').val();
			if(country == 0) {  $('#load').css('display', 'none'); $('#country_code').css('border', '1px solid red'); mistake = true; } 
			if(!service) {  $('#load').css('display', 'none'); $('#service').css('border', '1px solid red'); mistake = true; } 
			if(!zone) { $('#load').css('display', 'none'); $('#zone').css('border', '1px solid red'); mistake = true; } 
			if(!mistake) { 
	// Now we can make our stuff

	$.ajax({
        type: 'POST',
        url: 'ajax/zone_insert_countrycode.php',
       data: {country_code: country, service: service, zone : zone},	
        success: function(data)
                  {

					  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#zones_div').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, the match for this particular countrycode and service already exists !</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 2500);				  
					  
					  }
					  else { 
					  $('#load').css('display', 'none');
                    $('#zones_div').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> This zone has correctly been insered in the datawarehouse table</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 1500);
					  }
				  }           
       });
			
			}
	});
	
	
// Get all the zones 

$.ajax({
        type: 'GET',
		cache: false,
        url: 'ajax/zone_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },		
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
	$('#content_table_zones').append(' <tr> <th scope=\"row\">'+responseObj[iter].country+'</th> <td>'+responseObj[iter].service+'</td><td>'+responseObj[iter].zone+'</td><td><form action=\"extra_page/delete_zone.php\" method=\"post\"><input type=\"hidden\" value=\"'+responseObj[iter].service+'\" name=\"service_zone_delete\" /><input type=\"hidden\" value=\"'+responseObj[iter].country+'\" name=\"country_zone_delete\" /><button class="btn btn-primary" type="submit" style="background-color:red;">D</button></form></td></tr>');			
		
		}
				  
                  }           
       });	

$('#service_name_log').change(function(e) {
	if($('#service_name_log').val() != 0) {

$('#service_name_log').prop("disabled", true); // Element(s) are now enabled.
$('#weight_and_prices').append('<table class="table" style=\"background-color:#C4C4C4;border-radius:6px;\"> <thead> <tr> <th style="text-align:center;">'+$('#service_name_log').val()+'</th></tr></thead></table><div id=\"button_add_all\"></div>');

// Lets make the request to get back the zone and the countrycode
var theFullSelect = '<br /><select class=\"form-control\" id=\"zones_logs\">';
$.ajax({
        type: 'GET',
		cache: false,
        url: 'ajax/countries_and_zones_get_query.php',
		async: false,
		headers : { "content-type": "application/x-www-form-urlencoded" },
		data : { service : $('#service_name_log').val() },
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
			theFullSelect+='<option value=\"'+responseObj[iter].zone+'\">Zone ('+responseObj[iter].zone+')</option>';
		}
				  
                  }           
       });	
	   theFullSelect+='</select>';
	   theFullSelect+='<br /><div style=\"text-align:center;\"><button class=\"btn btn-primary\" id=\"more_logs_field\">+</button></div>';
	   var counter_on_click = 0;
			$(document).on('click', '#more_logs_field', function(){ 
			
			var allMyForm = '<h4>Zone : ('+$('#zones_logs').val()+')</h4><div class=\"form-group row\"><div class=\"col-sm-6\"> <input type=\"hidden\" value=\"'+$('#zones_logs').val()+'\" id=\"id_'+counter_on_click+'_hid_zone\" /><input type=\"text\" class=\"form-control\" id=\"id_'+counter_on_click+'_weight\" placeholder=\"Weight (kg)\"> </div><div class=\"col-sm-6\"> <input type=\"text\" class=\"form-control\" id=\"id_'+counter_on_click+'_price\" placeholder=\"Price\"> </div></div><div id=\"add_button_finale\"></div>';
			$('#weight_and_prices').append(allMyForm);
			counter_on_click++;
			$('#button_add_all').html('<br /><div style=\"text-align:center;\"><button class=\"btn btn-primary\" id=\"add_all_courier\">Add all</button></div>');
			
			});
			
	$(document).on('click', '#button_add_all', function(){
		 $('#load').css('display', 'none');
var finaleValuesToAdd = [];	
		var service_name = $('#service_name_log').val();
		console.log(counter_on_click);
		for (var iter=0; iter < counter_on_click; iter++) { 
			if(($('#id_'+iter+'_price').val()) && ($('#id_'+iter+'_weight').val())) {
				var weight_clean = $('#id_'+iter+'_weight').val().replace(/,/g, '.');	
				var price_clean = $('#id_'+iter+'_price').val().replace(/,/g, '.');
			finaleValuesToAdd.push({service : service_name, zone : $('#id_'+iter+'_hid_zone').val(), weight : weight_clean, price : price_clean})
			}
		}
		
		
		
// NOW LETS MAKE OUR STUFF IN THE DATABASE !!!

$.ajax({
        type: 'POST',
        url: 'ajax/shipping_insert_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },	
		data : { finaleArray : finaleValuesToAdd },
        success: function(response)
                  {  
				  if(finaleValuesToAdd.length <= 0) { 
						  $('#load').css('display', 'none');
                    $('#weight_and_prices').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, no fields have been filled !</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 1500);			  
				  }
				  else { 

					  $('#load').css('display', 'none');
                    $('#weight_and_prices').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The shipping cost have correctly been added !</div><br /><br />");
					setTimeout("location.href = 'cost.php';", 1500);
				  }

				  }
				            
       });	



/// END !!		



		
	});		
			
$('#input_countrycode_after_select').html(theFullSelect);
	} else { $('#service_name_log').css('border', '1px solid red'); } 



});



</script>

<script>
function createAMatrix(n) {
  var arr = [];

  for (var i=0;i<n;i++) {
     arr[i] = [];
  }

  return arr;
}

// About the cols, it's flexible, so lets take the correct number we need (about weight)


$('#service_name_sum_courier').change(function(e) { 

// AJAX FUNCTION TO GET ALL DATAS !!

$.ajax({
        type: 'GET',
		cache: false,
        url: 'ajax/shipping_get_query.php',
		data: { service : $('#service_name_sum_courier').val() },
		headers : { "content-type": "application/x-www-form-urlencoded" },		
        success: function(response) {
			
			var responseObj = jQuery.parseJSON(response);
			
			var allDifferentZone = [];
		for (var i = 0; i < responseObj.length; i++) { 
			var isPresent = false;
			for (var j = 0; j < allDifferentZone.length; j++) { 
				if(allDifferentZone[j] == responseObj[i].zone) { isPresent = true; }
			}
			if(!isPresent) { allDifferentZone.push(responseObj[i].zone); }
		}
			var allDifferentWeight = [];
		for (var i = 0; i < responseObj.length; i++) { 
			var isPresent = false;
			for (var j = 0; j < allDifferentWeight.length; j++) { 
				if(allDifferentWeight[j] == responseObj[i].weight) { isPresent = true; }
			}
			if(!isPresent) { allDifferentWeight.push(responseObj[i].weight); }
		}		
		allDifferentZone.sort();
		allDifferentWeight.sort();

// now in allDifferentZone we have all different zone and SORT
// now in allDifferentWeight we have all different weight and SORT			
			
$.ajax({ type: 'GET', cache: false, url: 'ajax/shipping_get_count_weight_query.php', data: { service : $('#service_name_sum_courier').val() }, headers : { "content-type": "application/x-www-form-urlencoded" },		
success: function(response_count) { 

	var responseObjCount = jQuery.parseJSON(response_count);
	console.log(responseObjCount + "the count is");
				  console.log(responseObj);
				  var n_size_matrix  = parseInt(responseObjCount)+1;
			var myMatrix = createAMatrix(n_size_matrix); // M in M(n+1, infini) where n is the number of different weight
		myMatrix[0][0] = 'Weight/Zone';
		
	// FULLFILING OF THE MATRIX

	
	// ABOUT THE WEIGHT
for (var i = 0; i < allDifferentWeight.length; i++) {
	myMatrix[i+1][0] = allDifferentWeight[i];
	
}

	// ABOUT THE ZONES
	
for (var j = 0; j < allDifferentZone.length; j++) {
	myMatrix[0][j+1] = allDifferentZone[j];
	
}

/// ************ HERE IS THE PROBLEM ********** //
	for (var j = 1; j < (allDifferentZone.length+1); j++) { 
	
		for (var i = 1; i < (allDifferentWeight.length+1); i++) {
				// Zone : myMatrix[0][j]
				// Weight : myMatrix[i][0]
			
			console.log("The couple is (w, z) : ("+myMatrix[i][0]+","+myMatrix[0][j]+")");	
			console.log("And so the price is : "+returnThePriceFromTheArray(responseObj,  myMatrix[0][j], myMatrix[i][0]));
			myMatrix[i][j] = returnThePriceFromTheArray(responseObj,  myMatrix[0][j], myMatrix[i][0]);
		}
	}

	
// *********************** END HERE ** //	
	
	console.log(myMatrix);
	
	// Lets fulfill the HTML THING//
	var theTableForTheCouriersum = '<table class="table" style="background-color:#C4C4C4;border-radius:6px;"> <thead> <tr> <th style="text-align:center;">'+$('#service_name_sum_courier').val()+'</th></tr></thead></table>';
	theTableForTheCouriersum += '<table class="table table-hover" style="text-align:center;">';
	
		for (var i = 0; i < (allDifferentWeight.length+1); i++) { 
			if(i == 0) { theTableForTheCouriersum+= '<thead><tr class="active">'; }
			else { theTableForTheCouriersum+= '<tbody style="text-align:left;"><tr>'; } 
			for (var j = 0; j < (allDifferentZone.length+1); j++) { 
				if(i == 0) { 
					if(j == 0) { theTableForTheCouriersum+='<th style="border-right:4px solid #000000;text-align:center;">'+myMatrix[i][j]+'</th>'; }
				else { theTableForTheCouriersum+='<th>'+myMatrix[i][j]+'</th>'; } } 
				else { if(j == 0) { theTableForTheCouriersum+='<td style="border-right:4px solid #000000;text-align:center;">'+myMatrix[i][j]+'</td>'; } else { theTableForTheCouriersum+='<td>'+myMatrix[i][j]+'</td>'; } }
				
			}
			if(i == 0) { theTableForTheCouriersum+= '</tr></thead>'; }
			else { theTableForTheCouriersum+= '</tr></tbody>'; }
		}
	
	theTableForTheCouriersum += '</table>';
	$('#table_courier_sum').html(theTableForTheCouriersum);
	if(responseObjCount > 0) { 
	$('#table_courier_sum').append('<br /><div style=\"text-align:center;\" id=\"delete_button_div\"><form action=\"extra_page/delete_shipping.php\" method=\"post\"><input type=\"hidden\" name=\"service_delete\" value=\"'+$('#service_name_sum_courier').val()+'\" /><button class=\"btn btn-primary\" type=\"submit\">Delete Recent</button></form></div>');
	} else { 
		$('#delete_button_div').css('display', 'none');
	}
	
// this is working !
	function returnThePriceFromTheArray(response, z, w) { 
		var thePrice = "-";
		for (var i = 0; i < response.length; i++) { 
			if(response[i].zone == z && response[i].weight == w) { thePrice = response[i].price; }
			
		}
		
		return thePrice;
	}


		

}  });			
			
			

				  
        }           
       });	

// END 



});




</script>

    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>

</body>

</html>
