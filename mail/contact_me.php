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

$client = ucfirst($_POST['name']);

$sendgrid = new SendGrid('rslucchese', 'S3ndGr33d');
$email = new SendGrid\Email();
$email
    ->addTo('grumr@grumr.com.br')
    ->addTo('rafael@grumr.com.br')
    ->addTo('junior@grumr.com.br')
    ->addTo('pedro@grumr.com.br')
    ->addTo('neto@grumr.com.br')
    ->addTo('sarah@grumr.com.br')
    ->setFrom($_POST['email'])
    ->setSubject('Grumr: Nova Solicitação')
    ->setText("Equipe Grumr, \r\n {$client} acaba de enviar a seguinte solicitação:\r\n \r\n" . $_POST['message'])
    ->setHtml("Equipe Grumr, <br/> {$client} acaba de enviar a seguinte solicitação:<br/><br/>" . $_POST['message'])
;

$email2 = new SendGrid\Email();
$email2
    ->addTo($_POST['email'])
    ->setFrom('grumr@grumr.com.br')
    ->setSubject('Sua Solicitação foi Recebida')
    ->setText('Querido ' . $client . ", \r\n A sua solicitação foi recebida. Entraremos em contato em breve. \r\n\r\n Atenciosamente, \r\n\r\n Equipe Grumr")
    ->setHtml('<i>Querido ' . $client . ", </i><br /> A sua solicitação foi recebida. Entraremos em contato em breve. <br /><br /> Atenciosamente, <br /><br /> <b><i>Equipe Grumr</i></b>")
;

try {
    $sendgrid->send($email);
    $sendgrid->send($email2);
} catch(\SendGrid\Exception $e) {
    echo $e->getCode();
    foreach($e->getErrors() as $er) {
        echo $er;
    }
}
		
?>