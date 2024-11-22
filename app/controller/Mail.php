<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';

class Mail{
    private $mailer;

    # https://stackoverflow.com/questions/29854795/implementing-a-try-catch-block-in-php-constructor-function
    public function __construct(){
        $this->mailer = new PHPMailer(true);

        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'rodrigo.villablanca@est.fi.uncoma.edu.ar';
            $this->mailer->Password = 'krdh nlth lnpp tzbt';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
    
            $this->mailer->setFrom('celayes.brisaabril@gmail.com', 'uwu');
        } catch (Exception $e) {
            throw new \Exception("Error al configurar PHPMailer: {$e->getMessage()}");
        }
    }

    public function getMailer()
    {
        return $this->mailer;
    }

    public function enviarCorreo($destinatario, $nombre, $asunto, $contenidoHtml, $contenidoAlt)
    {
        $resultado = ['success' => false, 'message' => ''];
        try {
            $this->getMailer()->addAddress($destinatario, $nombre);

            $this->getMailer()->isHTML(true);
            $this->getMailer()->Subject = $asunto;
            $this->getMailer()->Body = $contenidoHtml;
            $this->getMailer()->AltBody = $contenidoAlt;

            $this->mailer->send();
            $resultado['success'] = true;
            $resultado['message'] = 'Correo enviado exitosamente.';
        } catch (Exception $e) {
            throw new \Exception("Error al enviar el correo: {$this->getMailer()->ErrorInfo}");
        }
        return $resultado;
    }
}