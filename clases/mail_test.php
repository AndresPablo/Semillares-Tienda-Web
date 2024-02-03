<?php
    require 'Mailer.php';
    $asunto = "Mail d e prueba";
    $cuerpo = '<h4> Este mail es una prueba </h4>';

    $mailer = new Mailer();
    $mailer->enviarMail('andrespablo.mm@gmail.com', $asunto, $cuerpo);