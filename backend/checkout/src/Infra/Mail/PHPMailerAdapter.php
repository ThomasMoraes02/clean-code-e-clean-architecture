<?php 
namespace Checkout\Infra\Mail;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerAdapter implements Mail
{
    private readonly PHPMailer $mail;

    public function __construct(string $host, int $port, string $userName, string $password)
    {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $host;
        $phpmailer->Port = $port;
        $phpmailer->Username = $userName;
        $phpmailer->Password = $password;
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail = $phpmailer;
    }

    public function to(string $email, ?string $name = null): Mail
    {
        $this->mail->addAddress($email, $name ??= '');
        return $this;
    }

    public function subject(string $subject): Mail
    {
        $this->mail->isHTML();
        $this->mail->Subject = $subject;
        return $this;
    }

    public function body(string $body): Mail
    {
        $this->mail->Body = $body;
        return $this;
    }

    public function send(): void
    {
        $this->mail->send();
    }
}