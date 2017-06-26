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
	<style>
	.modal_div {
  position: fixed;
  top: 50%;
  left: 50%;
  width: 50%;
  max-width: 630px;
  min-width: 250px;
  padding-left: 10px;
  padding-right : 10px;
  text-align:center;
  padding-top:30px;
  padding-bottom:10px;
  height: auto;
  z-index: 2000;
  background: #FFFFFF;
  -webkit-backface-visibility: hidden;
  -moz-backface-visibility: hidden;
  backface-visibility: hidden;
  -webkit-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -ms-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);

border: 2px solid grey;
border-radius: 10px;
box-shadow: 0px 0px 1px 4px rgba(119, 119, 119, 0.75);
-moz-box-shadow: 0px 0px 1px 4px rgba(119, 119, 119, 0.75);
-webkit-box-shadow: 0px 0px 10px 1px rgba(119, 119, 119, 0.75);	
	}
	</style>
</head>

<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="background-color:#FFFFFF;height:50px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="marketing.php"><img src="img/bflogo.jpg" style="width:50%;" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="index.php">Home</a>
                    </li>								
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<div class="loading" style="display:none;" id="load"></div>


    <section  class="features" style="padding-top:65px;"> 
        <div class="container">  
		
		<div style="text-align:center;">
	Wanna search a marketing cost added ?</div> 
	<br />
			    <div class="form-group row">
	<div class="col-sm-12">
<input type="text" class="form-control" placeholder="Date" id="datepicker_search">	
	</div>
	</div>
	
<div id="results_search">


</div>	
		<br /><br />
<div id="form_to_add">	
		<div style="text-align:center;">
	Or wanna add a new one ?</div> 		
	<br />

		
		    <div class="form-group row">
	<div class="col-sm-6">
<select class="form-control" id="name_marketings">
<option value="0" selected="">Marketing Name</option>
<option value="Facebook Conversion">Facebook Conversion</option>
<option value="Facebook Branding">Facebook Branding</option>
<option value="Google Adwords">Google Adwords</option>
<option value="Affiliates">Affiliates</option>
<option value="Influencers">Influencers</option>
</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" placeholder="Date" id="datepicker">
      </div>
    </div>
	
		    <div class="form-group row">
	<div class="col-sm-6">
<select class="form-control" id="country_marketings">
<option value="0" selected="">Country</option>
<?php
include_once("prestashop.php");
$countries = ajax_get_countrycode();
foreach ($countries as $country) { 
?>
<option value="<?php echo $country['iso_code']; ?>"><?php echo $country['iso_code']; ?></option>
<?php
}
?>
</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" placeholder="Value" id="value_market">
      </div>
    </div>	
		<div style="text-align:center;">
		
<button class="btn btn-primary" id="add_market">Add</button>		
		</div>
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
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
  $( function() {
        $( "#datepicker" ).datepicker({
            changeYear: true, // afficher un selecteur d'année
            changeMonth: true
        });
    $( "#locale" ).on( "change", function() {
      $( "#datepicker" ).datepicker( "option",
        $.datepicker.regional[ $( this ).val() ] );
    });
  } );
   $( function() {
        $( "#datepicker_search" ).datepicker({
            changeYear: true, // afficher un selecteur d'année
            changeMonth: true
        });
    $( "#locale" ).on( "change", function() {
      $( "#datepicker_search" ).datepicker( "option",
        $.datepicker.regional[ $( this ).val() ] );
    });
  } ); 
  </script>
  <script>
  $("#datepicker_search").bind("change paste keyup", function() {
   var date_split = $('#datepicker_search').val().split('/');
   var date = date_split[2] + '-'+date_split[0]+'-'+date_split[1];
   console.log(date);
   
$.ajax({
        type: 'GET',
		cache: false,		
        url: 'ajax/marketing_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },	
       data: {date: date},	
        success: function(response)
                  {  
	var table_head = '<table class="table table-striped table-inverse"> <thead> <tr> <th>Date</th> <th>Countrycode</th> <th>Name</th> <th>Value</th><th>Edit</th> </tr></thead> <tbody>';

			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
	 table_head += '<tr><td>'+responseObj[iter].date+'</td><td>'+responseObj[iter].country+'</td><td>'+responseObj[iter].name+'</td><td>'+responseObj[iter].value+'</td><td><form action=\"extra_page/edit_marketing_cost.php\" method=\"post\"><input type=\"hidden\" value=\"'+responseObj[iter].date+'\" name=\"date_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].country+'\" name=\"country_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].name+'\" name=\"name_edit\" /><input type=\"hidden\" value=\"'+responseObj[iter].value+'\" name=\"value_edit\" /><button class="btn btn-primary" type="submit" >E</button></form></td></tr>';				
		}
	table_head+= '</tbody></table>';
	
	if(responseObj.length > 0) $('#results_search').html(table_head);
		else $('#results_search').html('No results');
	
                  }           
       });	
   
   
   
});
  </script>
  
  <script>
  
  $('#add_market').click(function(e) { 
  
	$('#load').css('display', '');
	var okToContinue = true;
	var date_split = $('#datepicker').val().split('/');
	if(!$('#datepicker').val()) { $('#datepicker').css('border', '1px solid red'); $('#load').css('display', 'none'); okToContinue = false; }
	var value = $('#value_market').val();
	var name_marketings = $('#name_marketings').val();
	var country_marketings = $('#country_marketings').val();
	if(!value) { $('#value_market').css('border', '1px solid red'); $('#load').css('display', 'none'); okToContinue = false; }
	if(name_marketings == 0) { $('#name_marketings').css('border', '1px solid red'); $('#load').css('display', 'none'); okToContinue = false; }
	if(country_marketings == 0) { $('#country_marketings').css('border', '1px solid red'); $('#load').css('display', 'none'); okToContinue = false; }

	
		if(okToContinue) { 
	
		var date = date_split[2] + '-'+date_split[0]+'-'+date_split[1];
		value = value.replace(/,/g, '.');
$.ajax({
        type: 'POST',
		cache: false,		
        url: 'ajax/marketing_insert_query.php',
       data: {date: date, name: name_marketings, country : country_marketings, value : value},	
        success: function(data)
                  {
					  
								  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, for the date : "+date+" there is already the same marketing cost</div><br /><br />");
					 setTimeout("location.href = 'marketing.php';", 2500);	
					  
					  } else { 			  
					  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The marketing cost has correctly been insered in the datawarehouse table</div><br /><br />");
					  setTimeout("location.href = 'marketing.php';", 1500); 
					  }
				  }           
       });		
		
		
		}
	
	
  
  });
  </script>

    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>


</body>

</html>
