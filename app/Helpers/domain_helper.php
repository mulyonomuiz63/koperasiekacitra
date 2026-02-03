<?php

if (!function_exists('is_valid_domain')) {
    /**
     * Mengecek apakah domain email benar-benar ada/aktif
     */
    function is_valid_domain($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        if (!$domain) return false;

        // Bypass untuk lingkungan development
        if (in_array($domain, ['localhost', 'test', 'example.com'])) {
            return true;
        }
        
        // Cek MX Record (Mail Server) atau A Record (IP Host)
        // checkdnsrr mengembalikan TRUE jika domain valid
        return checkdnsrr($domain, "MX");
    }
}
