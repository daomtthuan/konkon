<?php
namespace KonKon;

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/vendor.php';

class Mail {
  private static $__instance = null;
  private $__mail;

  private function __construct() {}

  private function __init(): void {
    $this->__mail = new PHPMailer();
    $this->__mail->isSMTP();
    $this->__mail->Host       = getenv('mail_host');
    $this->__mail->SMTPAuth   = true;
    $this->__mail->Username   = getenv('mail_username');
    $this->__mail->Password   = getenv('mail_password');
    $this->__mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $this->__mail->Port       = 465;
    $this->__mail->setFrom(getenv('mail_username'), 'KonKon - Computer Store');

    $this->__mail->Subject = 'Here is the subject';
    $this->__mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $this->__mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  }

  public static function getInstance(): Mail {
    if (is_null(self::$__instance)) {
      self::$__instance = new Mail();
    }
    return self::$__instance;
  }

  public function sendText(string $toMail, string $toName, string $subject, string $body): bool {
    $this->__init();
    $this->__mail->addAddress($toMail, $toName);
    $this->__mail->Subject = $subject;
    $this->__mail->Body    = $body;
    return $this->__mail->send();
  }

  public function sendHtml(string $toMail, string $toName, string $subject, string $body): bool {
    $this->__init();
    $this->__mail->addAddress($toMail, $toName);
    $this->__mail->isHTML(true);
    $this->__mail->Subject = $subject;
    $this->__mail->Body    = $body;
    return $this->__mail->send();
  }
}
