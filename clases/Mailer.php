<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer {
    function enviarMail($email, $asunto, $cuerpo)
    {
        require_once './config/config.php';
        require './phpmailer/src/PHPMailer.php';
        require './phpmailer/src/SMTP.php';
        require './phpmailer/src/Exception.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;  //SMTP::DEBUG_SERVER;  //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                  //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;       //SMTP username
            $mail->Password   = MAIL_PASS;                            //SMTP password
            $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
            $mail->Port       =  MAIL_PORT;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Correo emisor y nombre
            $mail->setFrom(MAIL_USER, 'Tienda Semillares');
            // Correo receptor y nombre
            $mail->addAddress($email); 
            $mail->addAddress('semillares.lp@gmail.com', 'Prueba de compra');  
            // Enviar copia correo
            $mail->addReplyTo('contacto@semillares.com.ar', 'Contacto');   // responde a esta direccion en lugar de la otra 

            // Contenido
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;


            $mail->Body    = mb_convert_encoding($cuerpo, 'UTF-8', 'ISO-8859-1');
            $mail->AltBody = $cuerpo;

            $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');
            if($mail->send())
            {
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
            return false;
            exit; // quitar una vez que funcione porque se detiene aca
        }
    }
}