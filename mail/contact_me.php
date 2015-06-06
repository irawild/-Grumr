<?php
//error_reporting(-1);
//ini_set('display_errors', 'On');

require '../vendor/autoload.php';

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

$sendgrid = new SendGrid('rslucchese', 'S3ndGr33d');
$email = new SendGrid\Email();
$email
    ->addTo('grumr@grumr.com.br')
    ->setFrom($_POST['email'])
    ->setSubject('Grumr: Nova Solicitação')
    ->setText($_POST['message'])
    ->setHtml($_POST['message'])
;

$sendgrid->send($email);

// Or catch the error

try {
    $sendgrid->send($email);
} catch(\SendGrid\Exception $e) {
    echo $e->getCode();
    foreach($e->getErrors() as $er) {
        echo $er;
    }
}
		
?>