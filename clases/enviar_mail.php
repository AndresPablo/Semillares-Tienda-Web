<?php 
    use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
    require '../phpmailer/src/Exception.php';

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;  //SMTP::DEBUG_SERVER;  //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'c1602108.ferozo.com';                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'no-responder@semillares.com.ar';       //SMTP username
        $mail->Password   = '@Nore2023';                            //SMTP password
        $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
        $mail->Port       =  465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Correo emisor y nombre
        $mail->setFrom(MAIL_USER, 'Tienda Semillares');
        // Correo receptor y nombre
        $mail->addAddress('andrespablo.mm@gmail.com', 'Prueba de compra'); 
        $mail->addAddress('semillares.lp@gmail.com', 'Prueba de compra');  
        // Enviar copia correo
        $mail->addReplyTo('contacto@semillares.com.ar', 'Contacto');   // responde a esta direccion en lugar de la otra 

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Detalle de su compra';

        $cuerpo = '<h4> Gracias por su compra! </h4>';
        $cuerpo .= '<p>El ID de su compra es <b>'. $id_transaccion .'</b></p>';
        $cuerpo .= '<br><p>En breve te contactamos para coordinar el envio, o llamanos al 0221 570-2432.</p>';

        $mail->Body    = mb_convert_encoding($cuerpo, 'UTF-8', 'ISO-8859-1');
        $mail->AltBody = 'Le enviamos los detalles de su compra';

        $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');
        $mail->send();
        //echo $mail->SMTPDebug;
        unset($_SESSION['carrito']); // limpiamos la variable de sesion carrito
    } catch (Exception $e) {
        echo "Error al enviar el correo de compra: {$mail->ErrorInfo}";
        exit; // quitar una vez que funcione porque se detiene aca
    }
    