<?php
/**
 * This example shows sending a message using PHP's mail() function.
 */

require 'PHPMailerAutoload.php';
date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)

$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');

$finale_yesterday = $yesterday_date->format("Y-m-d");

//Create a new PHPMailer instance
        $mail             = new PHPMailer(); 
                               $mail->IsSMTP(); // telling the class to use SMTP
                               $mail->Host       = "smtp.office365.com"; // SMTP server
                               //$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                               // 1 = errors and messages
                               // 2 = messages only
                               $mail->SMTPAuth   = true;                  // enable SMTP authentication
                               $mail->Port       = 587;
                               $mail->Username   = "david@bravafabrics.com"; // SMTP account username
                               $mail->Password   = "Zerah123$";

//Set who the message is to be sent from
$mail->setFrom('david@bravafabrics.com', 'David @ Brava Fabrics');
//Set an alternative reply-to address
$mail->addReplyTo('david@bravafabrics.com', 'David @ Brava Fabrics');
//Set who the message is to be sent to
$mail->addAddress('david@bravafabrics.com', 'David Zerah');
$mail->addAddress('david.xox@gmail.com', 'Zerah');
//Set the subject line
$mail->Subject = 'Report from '.$finale_yesterday;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//Replace the plain text body with one created manually
$mail->Body= 'This is a plain-text message body';
//Attach an image file

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

?>
