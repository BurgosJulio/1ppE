<?php

use JetBrains\PhpStorm\Language;
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP ::DEBUG_OFF;                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'julioemburgos@gmail.com';                     //SMTP username
    $mail->Password   = 'ChloE59557082';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //si usas 587 if vamos a usar esto `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('julioemburgos@gmail.com', 'Pañalera Los Jefes');
    $mail->addAddress('prof.burgosjulio@gmail.com', 'Joe User');     //Add a recipient

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments - por si queremos enviar archivos , hay que poner la ruta de donde van a salir
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de su compra';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo.='<p>El ID de su compra es <b>' .$id_transaccion.'</b></p>';


    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';


    $mail->setLanguage('es','../phpmailer/Language/phpmailer.lang-es.php');


    $mail->send();
    
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
    //exit;
}