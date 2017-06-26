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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
                <a class="navbar-brand page-scroll" href="marketing.php"><img src="../img/bflogo.jpg" style="width:50%;" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="../index.php">Home</a>
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
	
		<br /><br />
<div id="form_to_add">	
		<div style="text-align:center;">
	Wanna edit a marketing cost ?</div> 		
	<br />

		
		    <div class="form-group row">
	<div class="col-sm-6">
<select class="form-control" id="name_marketings" disabled>
<option value="<?php echo $_POST['name_edit']; ?>" selected=""><?php echo $_POST['name_edit']; ?></option>
</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" id="datepicker" value="<?php echo $_POST['date_edit']; ?>" disabled>
      </div>
    </div>
	
		    <div class="form-group row">
	<div class="col-sm-6">
<select class="form-control" id="countries_marketings" disabled >
<option value="<?php echo $_POST['country_edit']; ?>" selected=""><?php echo $_POST['country_edit']; ?></option>

</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" value="<?php echo $_POST['value_edit']; ?>" id="value_market">
      </div>
    </div>	
		<div style="text-align:center;">
		
<button class="btn btn-primary" id="edit_market">Edit</button>		
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
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>

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
  $('#edit_market').click(function(e) { 
  
 /*
id="name_marketings" disabled>
<option value="<?php echo $_POST['name_edit']; ?>" selected=""><?php echo $_POST['name_edit']; ?></option>
</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" id="datepicker" value="<?php echo $_POST['date_edit']; ?>" disabled>
      </div>
    </div>
	
		    <div class="form-group row">
	<div class="col-sm-6">
<select class="form-control" id="countries_marketings" disabled >
<option value="<?php echo $_POST['country_edit']; ?>" selected=""><?php echo $_POST['country_edit']; ?></option>

</select>
	 </div> 
      <div class="col-sm-6">
	  <input type="text" class="form-control" value="<?php echo $_POST['value_edit']; ?>" id="value_market" 
*/ 
	$('#load').css('display', '');
	var okToContinue = true;
	var date = $('#datepicker').val();
	var name_marketings = $('#name_marketings').val(); 
	var countries_marketings = $('#countries_marketings').val();
	var value = $('#value_market').val();
	if(!value) { $('#value_market').css('border', '1px solid red'); $('#load').css('display', 'none'); okToContinue = false; }

	
		if(okToContinue) { 
	
		value = value.replace(/,/g, '.');
$.ajax({
        type: 'POST',
        url: '../ajax/marketing_update_query.php',
       data: {date: date, name: name_marketings, country : countries_marketings, value : value},	
        success: function(data)
                  {
					  
								  if(data.includes('error')) { 
						  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"../img/icon/error.png\" /> Warning, for the date : "+date+" there is already the same marketing cost</div><br /><br />");
					 setTimeout("location.href = '../marketing.php';", 2500);	
					  
					  } else { 			  
					  $('#load').css('display', 'none');
                    $('#form_to_add').html("<br /><br /><div style=\"text-align:center\"><img src=\"../img/icon/check.png\" /> The marketing cost has correctly been edited in the datawarehouse table</div><br /><br />");
					  setTimeout("location.href = '../marketing.php';", 1500); 
					  }
				  }           
       });		
		
		
		}
	
	
  
  });

  </script>

    <!-- Theme JavaScript -->
    <script src="../js/new-age.min.js"></script>


</body>

</html>
