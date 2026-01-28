<?php

namespace App\Libraries;

class CaptchaService
{
    protected $status, $siteKey, $secretKey;

    public function __construct()
    {
        // Ambil dari database sesuai sistem Anda
        $this->status    = setting('captcha_status'); 
        $this->siteKey   = setting('captcha_site_key');
        $this->secretKey = setting('captcha_secret_key');
    }

    // Mengambil Site Key untuk JS di View
    public function getSiteKey()
    {
        return ($this->status === 'A') ? $this->siteKey : null;
    }

    // Validasi Score ke Google
    public function verify($token)
    {
        if ($this->status !== 'A') return true;
        if (empty($token)) return false;

        $client = \Config\Services::curlrequest();
        try {
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => $this->secretKey,
                    'response' => $token,
                ],
            ]);
            
            $body = json_decode($response->getBody(), true);
            
            // v3 menganggap sukses jika success = true DAN score di atas ambang batas (misal 0.5)
            // Score 1.0 (sangat mungkin manusia), 0.0 (sangat mungkin bot)
            return ($body['success'] && $body['score'] >= 0.5);
        } catch (\Exception $e) {
            return false;
        }
    }
}