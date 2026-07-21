<?php
namespace TableCrown\Foundation;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class PHPMailerService implements MailInterface
{
    private string $smtpHost;
    private string $smtpUser;
    private string $smtpPass;
    private int $smtpPort;
    private string $mittente;
    private string $nomeMittente;

    public function __construct(
        string $smtpHost,
        string $smtpUser,
        string $smtpPass,
        int $smtpPort = 587,
        string $mittente = 'no-reply@tablecrown.it',
        string $nomeMittente = 'TableCrown'
    ) {
        $this->smtpHost = $smtpHost;
        $this->smtpUser = $smtpUser;
        $this->smtpPass = $smtpPass;
        $this->smtpPort = $smtpPort;
        $this->mittente = $mittente;
        $this->nomeMittente = $nomeMittente;
    }

    public function inviaEmail(string $destinatario, string $oggetto, string $corpo): bool
    {
        $mail = new PHPMailer(true); // true = lancia eccezioni sugli errori

        try {
            // Configurazione SMTP
            $mail->isSMTP();
            $mail->Host       = $this->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->smtpUser;
            $mail->Password   = $this->smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->smtpPort;

            $mail->setFrom($this->mittente, $this->nomeMittente);
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->Subject = $oggetto;
            $mail->Body    = $corpo;

            $mail->send();
            return true;

        } catch (PHPMailerException $e) {
            error_log("Errore invio email: " . $mail->ErrorInfo);
            return false;
        }
    }
}