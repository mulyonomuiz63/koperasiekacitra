<?php
if (!function_exists('ringkas_uang')) {
    function ringkas_uang($n) {
        // if ($n < 1000) {
            return number_format($n, 0, ',', '.');
        // } 
        
        // if ($n < 1000000) {
        //     $hasil = $n / 1000;
        //     return (floatval($hasil) == intval($hasil) ? number_format($hasil, 0, ',', '.') : number_format($hasil, 1, ',', '.')) . ' K';
        // } 
        
        // if ($n < 1000000000) {
        //     $hasil = $n / 1000000;
        //     // Jika hasil desimalnya .0 maka format tanpa koma, jika ada angka selain .0 maka tampilkan 1 desimal
        //     return (floatval($hasil) == intval($hasil) ? number_format($hasil, 0, ',', '.') : number_format($hasil, 1, ',', '.')) . ' Juta';
        // } 
        
        // if ($n < 1000000000000) {
        //     $hasil = $n / 1000000000;
        //     return (floatval($hasil) == intval($hasil) ? number_format($hasil, 0, ',', '.') : number_format($hasil, 1, ',', '.')) . ' M';
        // } 
        
        // $hasil = $n / 1000000000000;
        // return (floatval($hasil) == intval($hasil) ? number_format($hasil, 0, ',', '.') : number_format($hasil, 1, ',', '.')) . ' T';
    }
}