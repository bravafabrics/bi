<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brava Fab</title>

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
                <a class="navbar-brand page-scroll" href="#page-top"><img src="img/bflogo.jpg" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#download">Intro</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#features">Prestashop</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#datawarehouse">Datawarehouse</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


    <section id="intro" class="download bg-primary text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">Statistics about Database</h2>
                    <p>You can visit the website : <a href="https://bravafabrics.com" target="_blank">BravaFabrics</a> !</p>
                </div>
            </div>
        </div>
    </section>

    <section id="prestashop" class="features">
        <div class="container">
                    <div class="section-heading" style="text-align:center;margin-bottom:20px;">
                        <h2>Prestashop</h2>
						<i class="icon-lock-open text-primary" style="font-size:60px;"></i>
                        <p class="text-muted">Check out the datas we get about Prestashop Database !</p>

            </div>
<!--
		 <table class="table">
    <thead>
      <tr >
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Default</td>
        <td>Defaultson</td>
        <td>def@somemail.com</td>
      </tr>      
      <tr>
        <td>Success</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr class="danger">
        <td>Danger</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr class="info">
        <td>Info</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
      <tr class="warning">
        <td>Warning</td>
        <td>Refs</td>
        <td>bo@example.com</td>
      </tr>
      <tr class="active">
        <td>Active</td>
        <td>Activeson</td>
        <td>act@example.com</td>
      </tr>
    </tbody>
  </table>

-->
  
        </div>
    </section>


    <section id="datawarehouse" class="contact bg-primary">
        <div class="container">
                    <div class="section-heading" style="text-align:center;margin-bottom:20px;">
                        <h2>Dataware House</h2>
                        <p class="text-muted">Check out the datas we get about Datawarehouse Database !</p>

            </div>
<?php
/* --- CONNECTION ON THE MYSQL DATABASE */
$nameDB = array(
    "prestashop" => "test_prestashop",
    "datawarehouse" => "test_datawarehouse",
);



//TEST
//// Lets pick one of them

try {
$db = new PDO('mysql:host=localhost;dbname='.$nameDB['datawarehouse']. ';charset=utf8', 'root', 'root');
}

catch(Exception $e) {
	die('Special error :' . $e->getMessage());
} // and show if there is a particular problem.

// About cogs
$first_query = $db->query('SELECT * FROM cogs_ecommerce');
$amount_cogs = 0;
while ($datas = $first_query->fetch()) $amount_cogs+= $datas['cogs'];

// About facebook spend
$first_query = $db->query('SELECT * FROM facebook_spend');
$amount_fb = 0;
while ($datas = $first_query->fetch()) $amount_fb += $datas['spend'];

// About gateway spend 
// About facebook spend
$first_query = $db->query('SELECT * FROM gateway_spend');
$amount_gt = 0;
while ($datas = $first_query->fetch()) $amount_gt += $datas['spend'];

?>

<div class="list-group">
  <p class="list-group-item active">Cogs Total Amount : <?php echo $amount_cogs; ?> euros</a>
  <p class="list-group-item" style="color:#000000;">Facebook Total amount : <?php echo $amount_fb; ?> euros</a>
  <p class="list-group-item active">Gateway Total amount : <?php echo $amount_gt; ?> euros</a>
</div>  
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2016 BravaFabrics & Bootstrap Template All Rights Reserved.</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="lib/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>

</body>

</html>
