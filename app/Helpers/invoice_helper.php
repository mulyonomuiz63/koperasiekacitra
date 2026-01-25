<?php

function generateBigInvoiceNumber(): string
{
    $db = \Config\Database::connect();

    $year  = date('Y');
    $month = date('m');

    // Lock row untuk mencegah duplikasi (important!)
    $db->query('LOCK TABLES pembayaran WRITE');

    try {
        $count = $db->table('pembayaran')
            ->where('status', 'A')
            ->where('YEAR(invoice_at)', $year)
            ->where('MONTH(invoice_at)', $month)
            ->countAllResults();

        $sequence = str_pad($count + 1, 5, '0', STR_PAD_LEFT);

        $invoiceNo = "INV/$year/$month/$sequence";

    } finally {
        $db->query('UNLOCK TABLES');
    }

    return $invoiceNo;
}
