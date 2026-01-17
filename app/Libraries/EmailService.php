<?php

namespace App\Libraries;

use App\Models\SettingModel;
use App\Models\EmailLogModel;
use Config\Services;

class EmailService
{
    protected $email;
    protected $log;

    public function __construct()
    {
        $setting = new SettingModel();
        $smtp = $setting->getSMTP();

        $this->log = new EmailLogModel();

        $config = [
            'protocol'  => 'smtp',
            'SMTPHost'  => $smtp['smtp_host'],
            'SMTPUser'  => $smtp['smtp_user'],
            'SMTPPass'  => $smtp['smtp_pass'],
            'SMTPPort'  => (int) $smtp['smtp_port'], // ✅ WAJIB CAST
            'SMTPCrypto'=> $smtp['smtp_crypto'], // tls / ssl
            'mailType'  => 'html',
            'charset'   => 'UTF-8',
            'newline'   => "\r\n",
        ];

        $this->email = Services::email();
        $this->email->initialize($config);
        $this->email->setFrom(
            $smtp['smtp_from_email'],
            $smtp['smtp_from_name']
        );
    }

    public function send(string $to, string $subject, string $message)
    {
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        if ($this->email->send()) {
            $this->log->insert([
                'recipient' => $to,
                'subject'   => $subject,
                'status'    => 'success'
            ]);
            return true;
        }

        $this->log->insert([
            'recipient'     => $to,
            'subject'       => $subject,
            'status'        => 'failed',
            'error_message' => $this->email->printDebugger(['headers'])
        ]);

        return false;
    }
}
