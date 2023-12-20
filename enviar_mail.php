<?php 
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  //SMTP::DEBUG_OFF;    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'c1602108.ferozo.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'no-responder@semillares.com.ar';                     //SMTP username
    $mail->Password   = '@G1mjr48lV';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('andrespablo.mm@gmail.com', 'Tienda Semillares NR');
    $mail->addAddress('contacto@semillares.com.ar', 'Contacto');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalle de su compra';
    $cuerpo = "<h4> Gracias por su compra! <\h4>";
    $cuerpo = "<p> El ID de su compra es ... <\p>";
    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');
    $mail->send();
    echo 'Mail enviado con exito';
} catch (Exception $e) {
    echo "Error al enviar el correo de compra: {$mail->ErrorInfo}";
}
?>