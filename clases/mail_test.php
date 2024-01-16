<?php
    use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
    require '../phpmailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  //SMTP::DEBUG_OFF;  //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'c1602108.ferozo.com';                  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'no-responder@semillares.com.ar';       //SMTP username
    $mail->Password   = '@Nore2023';                            //SMTP password
    $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    $mail->Username   = 'no-responder@semillares.com.ar';       //SMTP username
    $mail->Password   = '@Nore2023';                            //SMTP password

    $mail->setFrom('no-responder@semillares.com.ar', 'Tienda Semillares');
    $mail->addAddress('andrespablo.mm@gmail.com');

    $mail->Subject = 'Prueba';
    $mail->Body = 'Este es un correo de prueba';

    if($mail->send()) {
        echo 'Correo enviado!';
    } else {
        echo 'Error: ' . $mail->ErrorInfo;
    }