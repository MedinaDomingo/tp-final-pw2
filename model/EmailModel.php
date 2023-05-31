<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

class Email
{
    private $mail;


    public function __construct($name, $username, $password, $host, $port)
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = $host;
        $this->mail->Port = $port;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SetFrom($username, $name);
        $this->mail->CharSet = 'UTF-8';
    }

    function enviarCodigoValidacion($destinatarioEmail, $nombreDestinatario, $activation_code, $url)
    {
        try {

            $this->mail->AddAddress($destinatarioEmail, $nombreDestinatario);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Validación de Cuenta';
            $this->mail->Body = '<h1>Hola '.$nombreDestinatario.'</h1>Tu código de validación es: '.$activation_code.
                '<br>Pizza gratis ->-><a href="'.$url.'">'.$url.'</a>';

            $this->mail->Send();

        } catch (Exception $e) {
            echo 'Ocurrió un error durante el envío del correo: ' . $this->mail->ErrorInfo;
        }
    }

}
