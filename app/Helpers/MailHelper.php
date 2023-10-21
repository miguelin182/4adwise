<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 16/10/17
 * Time: 18:34
 */

namespace App\Helpers;



use Core\ServicesContainer;
use PHPMailer\PHPMailer\PHPMailer;

class MailHelper
{


    public static function senMail(string $title, string $toMail, string $body):bool {


        $configg=ServicesContainer::getConfig();
        $config=$configg["emailconfig"];
        try{
            $mail=new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            //$mail->isSMTP();
            $mail->SMTPAuth=true;
            $mail->Host=$config['host'];
            $mail->Port=$config['port'];
            $mail->Username=$config['user'];
            $mail->Password=$config['password'];
            $mail->SMTPDebug  = 4;

            $mail->addAddress($toMail);

            $mail->From=$config['user'];
            $mail->FromName= $configg['company_name'] ." " .date("Y");

            $mail->Subject= $configg['company_name']. " - ". $title;
            $mail->Body=$body;
            $mail->IsHTML(true);


            $mail->From=$config['user'];
            $mail->send();
            return true;
        }catch (\phpmailerException $e){
            Log::critical(MailHelper::class, $e->getMessage());
            return false;
        }
    }


}

/*
$mail = new Email('smtp.gmail.com', 465);
$mail->setProtocol(Email::SSL); //SSL or TLS can be used. Or if there's other protocol you have
$mail->setLogin('<email address>', '<password>');
$mail->addTo('<receiver email>', '<receiver name>'); //receiver's name is optional
$mail->setFrom('<sender email>', '<sender name>'); //sender's name is optional
$mail->setSubject('Test subject');
$mail->setMessage('<b>test message</b>', true); //argument 2=true (send HTML mail) | default: false (plain text)
echo (($mail->send()) ? 'Mail has been sent' : 'Error sending email') . PHP_EOL;
print_r($mail->getLog()); //display SMTP log


 * */