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
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../lib/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../lib/device-mockups/device-mockups.min.css">

    <!-- Theme CSS -->
    <link href="../css/new-age.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="background-color:#FFFFFF;height:50px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="../cost.php"><img src="../img/bflogo.jpg" style="width:50%;" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<div class="loading" style="display:none;" id="load"></div>
 
	    <section class="features" style="padding-top:65px;"> 
        <div class="container" id="courier_extra_div"> 

		
	<h4 style="padding-left:30px;"><?php echo $_POST['service_edit']; ?></h4>
<div class="form-group">
    Percentage : <input type="text" class="form-control" id="perc" placeholder="Percentage" value="<?php echo $_POST['perc_edit']; ?>"/> </div>
<div class="form_group">
    Fix : <input type="text" class="form-control" id="fix" placeholder="Fix for transactions" value="<?php echo $_POST['fix_edit']; ?>" /> </div>
	<input type="hidden" id="service_edit" value="<?php echo $_POST['service_edit']; ?>" />
	<input type="hidden" id="date_edit" value="<?php echo $_POST['date_edit']; ?>" />
		<br />
		<div style="text-align:center;">
<button class="btn btn-primary" id="edit_extra">Send it</button>
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


$(document).on('click', '#edit_extra', function(){ 
var new_perc = $('#perc').val();
var new_fix = $('#fix').val();
var date = $('#date_edit').val();
var service = $('#service_edit').val();
	new_perc = new_perc.replace(/,/g, '.');
	new_fix = new_fix.replace(/,/g, '.');
     $('#load').css('display', '');
	 
$.ajax({
        type: 'POST',
        url: '../ajax/shipping_extra_update_query.php',
       data: {date : date, service: service, percentage: new_perc, fix : new_fix},
		cache: false,	   
        success: function(data)
                  {
					  $('#load').css('display', 'none');
					  $('#courier_extra_div').html('<br /><br /><div style=\"text-align:center\"><img src=\"../img/icon/check.png\" /> The extra for the service : '+service + ' has correctly been updated in the datawarehouse table</div><br /><br />');
					console.log(date);
					setTimeout("location.href = '../cost.php';", 1500);
				 }           
       });
});	   
	 
</script>

    <!-- Theme JavaScript -->
    <script src="../js/new-age.min.js"></script>

</body>

</html>
