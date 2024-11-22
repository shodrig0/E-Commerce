<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{
    private $mailer;


    public function __construct(){
        $this->mailer = new PHPMailer(true);
    }

    public function getMail()
    {
        return $this->mailer;
    }


    public function envioMail($usNombre, $email, $tipoMail, $colProductos){
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'gruposi797@gmail.com';
            $this->mailer->Password = 'xtfb fvdw zwic sttw';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
    
            $this->mailer->setFrom('gruposi797@gmail.com', 'Notificación de Compra');
        } catch (Exception $e) {
            throw new \Exception("Error al configurar PHPMailer: {$e->getMessage()}");
        }

    }

}