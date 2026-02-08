<?php
if (!function_exists('ringkas_uang')) {
    function ringkas_uang($n) {
        if (!is_numeric($n) || $n < 1000) {
            return number_format($n, 0, ',', '.');
        }

        // Definisi ambang batas dan satuannya
        $units = [
            1000000000000 => ' T',
            1000000000    => ' M',
            1000000       => ' Juta',
            1000          => ' K',
        ];

        foreach ($units as $value => $suffix) {
            if ($n >= $value) {
                $hasil = $n / $value;
                // Cek apakah angka bulat atau punya desimal
                $format = (fmod($hasil, 1) == 0) ? 0 : 1;
                return number_format($hasil, $format, ',', '.') . $suffix;
            }
        }

        return number_format($n, 0, ',', '.');
    }
}