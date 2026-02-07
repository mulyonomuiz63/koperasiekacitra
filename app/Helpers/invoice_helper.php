<?php

function generateBigInvoiceNumber(): string
{
    $db = \Config\Database::connect();
    
    // Gunakan date periode yang ringkas
    $period = date('Ym'); 
    
    // Tambahkan Random Factor di DEPAN sequence agar pencarian MAX tetap efisien 
    // atau gunakan teknik Microtime agar probabilitas bentrok mendekati nol
    $microTime = substr(str_replace('.', '', microtime(true)), -4); 
    $randomFactor = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

    // Optimasi Query: Cukup ambil MAX dari bulan ini
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $row = $db->table('pembayaran')
              ->selectMax('invoice_no')
              ->where('invoice_at >=', $start)
              ->where('invoice_at <=', $end)
              ->get()
              ->getRow();

    $lastInvoice = $row->invoice_no;
    
    // Mengambil 5 digit terakhir sebagai counter
    $nextSequence = 1;
    if ($lastInvoice) {
        $lastParts = explode('/', $lastInvoice);
        $nextSequence = (int)end($lastParts) + 1;
    }

    $sequence = str_pad($nextSequence, 6, '0', STR_PAD_LEFT);
    
    // Format: INV/PERIODE/RANDOM-MICRO/SEQUENCE
    // Contoh: INV/202602/A1B2-5521/000001
    return "INV/$period/$randomFactor-$microTime/$sequence";
}
