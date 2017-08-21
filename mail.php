<?php

function send_mail ($amount, $withoutrefunds, $marketing_cost_percentage) { 


$list_mails = array("david@bravafabrics.com", "ivan@bravafabrics.com", "ramon@bravafabrics.com", "sara@bravafabrics.com");

require 'mail/PHPMailerAutoload.php';


date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)

$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');

$finale_yesterday = $yesterday_date->format("Y-m-d");

        $mail             = new PHPMailer(); 
                               $mail->IsSMTP(); // telling the class to use SMTP
                               $mail->Host       = "smtp.office365.com"; // SMTP server
                               //$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                               // 1 = errors and messages
                               // 2 = messages only
                               $mail->SMTPAuth   = true;                  // enable SMTP authentication
                               $mail->Port       = 587;
                               $mail->Username   = "ivan@bravafabrics.com"; // SMTP account username
                               $mail->Password   = "33954526V123$";

$mail->setFrom('ivan@bravafabrics.com', 'Ivan @ Brava Fabrics');
$mail->addReplyTo('ivan@bravafabrics.com', 'Ivan @ Brava Fabrics');
for($i = 0; $i < sizeof($list_mails); $i++) { 
$mail->addAddress(''.$list_mails[$i].'', '');

}
$mail->Subject = 'Daily Report from '.$finale_yesterday;
$amount_iva = $amount*(1 + IVA/100);
$withoutrefunds_iva = $withoutrefunds*(1 + IVA/100);

$body = 'Data from yesterday : '.$finale_yesterday . ' is ready. <br />
<br /><br />
Yesterday incomes ('.$finale_yesterday.') were (Taxes and Shipping paid included) :
<br />
With refunds <b>'.$amount_iva . ' euros</b><br />
Without refunds <b>'.$withoutrefunds_iva.' euros</b>.
<br />
The marking spend represents : <b>'.$marketing_cost_percentage.'%</b> of the net sales.
<br /><br />
See more : <a href="http://www.bravafabrics.com/DataWarehouse/index.php?date='.$finale_yesterday.'" target="_blank">Report from '.$finale_yesterday.' </a>
';
$mail->Body = $body;
$mail->IsHTML(true);  
//Attach an image file

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
}

function send_mail_recurrency ($recurrency_longterm, $recurrency_shortterm) { 


$list_mails = array("david@bravafabrics.com");

require 'mail/PHPMailerAutoload.php';


date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)

$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !

$finale_yesterday = $yesterday_date->format("M-y");

        $mail             = new PHPMailer(); 
                               $mail->IsSMTP(); // telling the class to use SMTP
                               $mail->Host       = "smtp.office365.com"; // SMTP server
                               //$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                               // 1 = errors and messages
                               // 2 = messages only
                               $mail->SMTPAuth   = true;                  // enable SMTP authentication
                               $mail->Port       = 587;
                               $mail->Username   = "ivan@bravafabrics.com"; // SMTP account username
                               $mail->Password   = "33954526V123$";

$mail->setFrom('ivan@bravafabrics.com', 'Ivan @ Brava Fabrics');
$mail->addReplyTo('ivan@bravafabrics.com', 'Ivan @ Brava Fabrics');
for($i = 0; $i < sizeof($list_mails); $i++) { 
$mail->addAddress(''.$list_mails[$i].'', '');

}
$mail->Subject = 'Recurrency Report from '.$finale_yesterday;


$body = 'Recurrency for the month : '.$finale_yesterday . ' is ready. <br />

Recurrency for short term (12 months) <b>'.$recurrency_shortterm . '</b><br />
Recurrency for long term (24 months) <b>'.$recurrency_longterm.'</b>.
<br />
<br /><br />
See more about the computation : <a href="http://www.bravafabrics.com/DataWarehouse/recurrency_index.php" target="_blank">Recurrency Comoute from '.$finale_yesterday.' </a>
';
$mail->Body = $body;
$mail->IsHTML(true);  
//Attach an image file

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
}


?>
