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


    <section  class="features" style="padding-top:65px;"> 
        <div class="container">  
                    <div class="section-heading" style="text-align:center;margin-bottom:20px;">
                        <h2>Glossary</h2>
						A quick explanation about fields and their computation.	All numbers are deducted from the IVA.
						</div>
					
		<h3>About Sales Report</h3>
<div class="list-group">
  <a class="list-group-item active" style="text-align:center;"><h4>Net Sales</h4> <span style="font-size:10px;">(it considers that a "validate" order)</span></a>
  <a class="list-group-item"><b><u>Fullpricing</u></b> : The fullpricing is a sum of the price of each items for each order without IVA
  <br /><span style="font-size:10px;padding-left:30px;">For example (Order #9601) : Total (89.04€), Discounts (24.75€), Shipping (6.52€). So Fullpricing is <b>107.27 €</b> (Total + Discounts - Shipping) (It also considers the Sales cases !) </span></a>
  <a class="list-group-item"><b><u>Discount</u></b> : Is a sum of two different discounts : coupon discount & sales discount
   <br /><span style="font-size:10px;padding-left:30px;"><u>Coupon Discount</u> is a word that customer can put on their order to have a discount (for example WELCOMEBRAVA). <u>Sales Discount</u> Only during the sales (January).</span></a>
 
  </a>
  <a class="list-group-item"><b><u>Refund</u></b> : An additional case in case of customer has asked for a refund. (Coming from the bravafabrics dataoffice base.)   
  </a>
   <a class="list-group-item"><b><u>Net Sales</u></b> : Is the net sales (fullpricing deducted from cost). Net Sales = Fullpricing - Discount - Refund
  </a>
  <a class="list-group-item active" style="text-align:center;"><h4>Gateways</h4> <span style="font-size:10px;">(Go to Home > Gateways/Logitics > Gateways to manage)</span></a>
   <a class="list-group-item"><b><u>Refund Gateways</u></b> : In case of refunds, the "Payment methods" refund their fees, so it sees as <b>a bonus cost</b>. 
   <br /><span style="font-size:10px;padding-left:30px;">It will check THE MOST RECENT cost for each payment method which has been added manually in Home > Gateways and make a computation by : <b>Price*Percentage + Fee</b>. In case of "Pago contra reembolso", it takes : <b>max(price*perc, fee)</b></span></a>
  </a>
   <a class="list-group-item"><b><u>Gateways</u></b> : Are calculated from the Home > Gateways. (It deducts the gateways refunds which is seen as bonus). 
   <br /><span style="font-size:10px;padding-left:30px;">It will check THE MOST RECENT cost for each payment method which has been added manually in Home > Gateways and make a computation by : <b>Price*Percentage + Fee</b>. In case of "Pago contra reembolso", it takes : <b>max(price*perc, fee)</b></span></a>
  </a> 
   <a class="list-group-item active" style="text-align:center;"><h4>Logistics</h4> <span style="font-size:10px;">(Go to Home > Gateways/Logitics to manage)</span></a>
   <a class="list-group-item"><b><u>Shipping Paid</u></b> : Is the amount that the <b>customer paids</b> for delivery. 
   <a class="list-group-item"><b><u>Shipping Logistics</u></b> : Is the amount that <b>Brava paids</b> for delivery. It takes consideration of the zone, the weight, the delivery method (UPS, Envialia..) and an extra price (fuel..)
      <br /><span style="font-size:10px;padding-left:30px;">It will check THE MOST RECENT data, every datas has to be fulfill in Home > Gateways/Logisitcs (Zone, Shipping, Extra shipping)</span></a>

  </a> 
   <a class="list-group-item"><b><u>Handling Cost</u></b> : Is the amount to handle an order. The cost (managing in Home > Gateways > Handling Cost) is multiply by the number of items.
      <br /><span style="font-size:10px;padding-left:30px;">It will check THE MOST RECENT data, every datas has to be fulfill in Home > Gateways/Logisitcs (Handling Cost).
	  <br />For example : If an order has <b>4 items</b> and the handling cost set is 1.2 €, the total handling cost will be 1.2*4 = <b>4.8€</b> </span></a>

  </a>   
   <a class="list-group-item"><b><u>Order Preparation</u></b> : Is a cost of Preparation Cost. Preparation Cost is a fix amount set in the (Gateways > Logistics > Handling Cost) <b>by order</b>
      <br /><span style="font-size:10px;padding-left:30px;">It will check THE MOST RECENT data, every datas has to be fulfill in Home > Gateways/Logisitcs (Handling Cost).
	  <br />For example : If an order has <b>4 items</b> and the handling cost set is 1.2 €, the total handling cost will be 1.2*4 = 4.8€ with a  preparation cost of 3, means that Order Preparation = <b>7.8€</b>.</span></a>

  </a>    <a class="list-group-item"><b><u>Refund Logistics Cost</u></b> : RLC = Exchanges Logistic + Refunds Logistic. Is a cost that take consideration of exchanging an item (It has to be back to Brava and after to go the customer back). Be careful this amount considers handling and preparation cost when it returns back to the customer.
      <br /><span style="font-size:10px;padding-left:30px;">You have to fulfill zone, shipping, extra shipping for the name : "UPS Refund Returns", "ENVIALIA EXCHANGES GO", "UPS EXCHANGES GO", "ENVIALIA EXCHANGES RETURNS", "UPS EXCHANGES RETURNS", go to keychain.php to edit it !</span>

  </a> 
  

   <a class="list-group-item"><b><u>Total Logistics</u></b> is following the formula : Shipping Logistics + Handling Cost  + Preparation Cost + Refund Logistic - Shipping Paid</b>.
      </a>
   <a class="list-group-item active" style="text-align:center;"><h4>Cogs</h4></a>
     <a class="list-group-item"><b><u>Cogs</u></b>  : Is the cost of each products (to make it :) )
      </a>	  
   <a class="list-group-item"><b><u>Packaging Cost</u></b>  : Is the amount to package an order. It takes consideration of the materals cost (bags..). Packaging Cost = Materals Cost (by items) + Cost to pack the order. 
      </a>	
     <a class="list-group-item"><b><u>Shipping Materals</u></b>  : Is the amount to the materals have been used from the order (bag..)
      </a>	
     <a class="list-group-item"><b><u>Cogs Refunds </u></b> : Is a <b>bonus cost</b> when customer returns the item. It takes an average of the last 7 days (Cogs/(Fullpricing-Discount)) order to make a percentage multiply by the cost of refunds.
	 
      </a>	 
     <a class="list-group-item"><b><u>Total Cogs</u></b> : Total Cogs = Cogs + Packaging Cost + Shipping Materals - Cogs Refunds.
      </a> 	  
   <a class="list-group-item active" style="text-align:center;"><h4>Marketing</h4></a>
     <a class="list-group-item"><b><u>Facebook</u></b> : Facebook Branding & Conversion Account, fulfill automatically by using the API.
      </a> 	 
     <a class="list-group-item"><b><u>Google Adwords</u></b> : Fulfill manually by the marketing menu.
      </a> 
     <a class="list-group-item"><b><u>Affiliate & Influencers</u></b> : Fulfill manually by the marketing menu.
      </a> 		  
</div>

<hr>
		<h3>About Customer Acquisition</h3>	

<div class="list-group">
  <a class="list-group-item"><b><u># New Customers</u></b> : Returns the number of new customers.
	</a>
  <a class="list-group-item"><b><u>Marketing Spend</u></b> : Returns the total number of marketing spend.
	</a>
  <a class="list-group-item"><b><u>CAC</u></b> : Follows this formula : CAC = Marketing Spend / Number of New Customers
	</a>	
  <a class="list-group-item"><b><u>CLTV</u></b> : Recurrency is taken for the database (most recent one, you can set it by the menu). CLTV follows this formula : Recurrency*(Profit + Marketing Spend)/Number of orders
	</a>	
  <a class="list-group-item"><b><u>Ratio</u></b> : Follows this formula : Ratio = CLTV/CAC
	</a>	
  <a class="list-group-item"><b><u>AOV</u></b> : Follows this formula : Ratio = (Fullpricing - Discount + Shipping Paid)/Number Orders
	</a>	
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

    <!-- Theme JavaScript -->
    <script src="js/new-age.min.js"></script>


</body>

</html>
