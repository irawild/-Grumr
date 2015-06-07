<?php
//error_reporting(-1);
//ini_set('display_errors', 'On');

require '../vendor/autoload.php';

// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['bairro'])	||
   empty($_POST['cep'])  ||
   empty($_POST['dia'])  ||
   empty($_POST['finde'])  ||
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
    ->setText("Equipe Grumr, \r\n\r\n {$client} acaba de enviar uma solicitação com os seguintes detalhes:\r\n \r\n Bairro: " . $_POST['bairro'] . "\r\n \r\n Cep: {$_POST['cep']} \r\n \r\n Manhã ou Tarde: {$_POST['dia']} \r\n \r\n Dia de Semana ou Fim de Semana: {$_POST['finde']} \r\n \r\n Telefone: {$_POST['phone']} \r\n \r\n Email: {$_POST['email']}")
    ->setHtml("<i>Equipe Grumr,</i> <br/><br/> {$client} acaba de enviar a seguinte solicitação com os seguintes detalhes:<br/><br/> <b>Bairro:</b> {$_POST['bairro']} <br/><b>Cep:</b> {$_POST['cep']} <br/> <b>Manhã ou Tarde:</b> {$_POST['dia']} <br/> <b>Dia de Semana ou Fim de Semana:</b> {$_POST['finde']} <br/> <b>Telefone:</b> {$_POST['phone']} <br/> <b>Email:</b> {$_POST['email']}")
;

$email2 = new SendGrid\Email();
$email2
    ->addTo($_POST['email'])
    ->setFrom('grumr@grumr.com.br')
    ->setSubject('Sua Solicitação foi Recebida')
    ->setText('Querido ' . $client . ", \r\n\r\n A sua solicitação foi recebida. Entraremos em contato em breve. \r\n\r\n Atenciosamente, \r\n\r\n Equipe Grumr")
    ->setHtml('<i>Querido ' . $client . ", </i><br /><br /> A sua solicitação foi recebida. Entraremos em contato em breve. <br /><br /> Atenciosamente, <br /><br /> <b><i>Equipe Grumr</i></b>")
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