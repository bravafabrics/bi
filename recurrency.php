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
                <a class="navbar-brand page-scroll" href="cost.php"><img src="img/bflogo.jpg" style="width:50%;" /></a>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<div class="loading" style="display:none;" id="load"></div>
    <section id="gateways_div" class="features" style="padding-top:65px;"> 
        <div class="container">  

<table class="table table-striped table-inverse">
  <thead>
    <tr>
      <th>Date</th>
      <th>Recurrency</th>
		<th>Edit</th>	  
    </tr>
  </thead>
  <tbody id="content_table_gateways">

  </tbody>
</table>

<div id="edit_payment_method"></div>

		
    <div class="form-group row" id="form_to_add">
	<div class="col-sm-2">
      <input type="text" class="form-control" id="datepicker" placeholder="Date">
	 </div> 	
	<div class="col-sm-2">
      <input type="text" class="form-control" id="recurrency" placeholder="Recurrency">
	 </div> 
      <div class="col-sm-8">
        <button class="btn btn-primary" id="add">A</button>
      </div>
    </div>
	
	<div id="mistake"></div>
	
	  
	  
<br />
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

// About gateways select
$.ajax({
        type: 'GET',
        url: 'ajax/recurrency_get_query.php',
		headers : { "content-type": "application/x-www-form-urlencoded" },	
		cache: false,
        success: function(response)
                  {
			var responseObj = jQuery.parseJSON(response);
		for (var iter = 0; iter < responseObj.length; iter++) {
	$('#content_table_gateways').append(' <tr> <th scope=\"row\">'+responseObj[iter].date+'</th> <td>'+responseObj[iter].recurrency+'</td><td><button class="btn btn-primary" id="edit_date_'+responseObj[iter].date+'">E</button></td></tr>');			
		edit_content(responseObj[iter].date, responseObj[iter].recurrency);
		
		}
				  
                  }           
       });
	   
	   

function edit_content(date, recurrency) {
			$('#edit_date_'+date+'').click(function(e) { 
		         $('html, body').animate({
              scrollTop: $("#edit_payment_method").offset().top
        }, 1000); 	
		$('#edit_payment_method').html('<h4 style=\"padding-left:30px;\">'+date+'</h4> <div class=\"form-group\"> <input type=\"text\" class=\"form-control\" id=\"'+date+'_recurrency_update\" placeholder=\"'+recurrency+'\" value=\"'+recurrency+'\"><br /><div class=\"form_group\" style=\"text-align:center;\"><button class="btn btn-primary" id="update_date_'+date+'">Update</button></div><hr>');
		});

$(document).on('click', '#update_date_'+date, function(){ 
var new_recurrency = $('#'+date+'_recurrency_update').val();
	new_recurrency = new_recurrency.replace(/,/g, '.');
     $('#load').css('display', '');
	 if(!new_recurrency) {  $('#load').css('display', 'none'); $('#'+date+'_recurrency_update').css('border', '1px solid red'); }
	 else { 
	 
$.ajax({
        type: 'POST',
        url: 'ajax/recurrency_update_query.php',
       data: {date : date, recurrency : new_recurrency},	
        success: function(data)
                  {
					  $('#load').css('display', 'none');
					  $('#edit_payment_method').html('<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The recurrency for the date : '+date+' has correctly been updated in the datawarehouse table</div><br /><br />');
					setTimeout("location.href = 'recurrency.php';", 1500);
				 }           
       });	 
	 }
	 
}); 
}





$('#add').click(function(e) { 

$('#load').css('display', '');
	var date = $('#datepicker').val();
	var recurrency = $('#recurrency').val();
	recurrency = recurrency.replace(/,/g, '.');
	var okToContinue = true;
	if(!date) { $('#load').css('display', 'none'); $('#datepicker').css('border', '1px solid red'); okToContinue = false; }
	if(!recurrency) {  $('#load').css('display', 'none'); $('#recurrency').css('border', '1px solid red'); okToContinue = false; }
	if(okToContinue) { 
$.ajax({
        type: 'POST',
        url: 'ajax/recurrency_insert_query.php',
       data: {date : date, recurrency : recurrency},	
        success: function(data)
                  {
					  
								  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/error.png\" /> Warning, for today there is already the same recurrency</div><br /><br />");
					setTimeout("location.href = 'recurrency.php';", 2500);	
					  
					  } else { 			  
					  $('#load').css('display', 'none');
                    $('#mistake').html("<br /><br /><div style=\"text-align:center\"><img src=\"img/icon/check.png\" /> The recurrency has correctly been insered in the datawarehouse table</div><br /><br />");
					 setTimeout("location.href = 'recurrency.php';", 1500); 
					}
			}
					

	}) }
});

</script>

	<script>
   $( function() {
        $( "#datepicker" ).datepicker({
            changeYear: true, // afficher un selecteur d'année
            changeMonth: true,
			dateFormat : "yy-mm-dd"
        });
    $( "#locale" ).on( "change", function() {
      $( "#datepicker" ).datepicker( "option",
        $.datepicker.regional[ $( this ).val() ] );
    });
  } ); 	
	</script>
    <!-- Theme JavaScript -->
	   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/new-age.min.js"></script>

</body>

</html>
