<?php
$to = "bhupesh.verz@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a test email message.";
$from = "info@abacus.verz1.com";
$headers = "From:" . $from;

mail($to,$subject,$message,$headers)
?>