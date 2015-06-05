<?php
error_reporting(-1);
ini_set('display_errors', 'On');

// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "Nenhum campo foi preenchido!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
	
// Create the email and send the message
$to = 'rafael@grumr.com.br'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";
$email_body = "Você recebeu uma nova mensagem de contato do atravéz do Grumr.\n\n"."Seguem os detalhes:\n\nNome: $name\n\nEmail: $email_address\n\nTelefone: $phone\n\nMensagem:\n$message";

$headers = "";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
$headers .= 'From: From: noreply@grumr.com.br' . "\r\n" .
'Reply-To: ' . $email_address . "\r\n" .
'X-Mailer: PHP/' . phpversion();

if(mail($to,$email_subject,$email_body,$headers)) {
   return true;   
} else {
   return false;   
}
		
?>