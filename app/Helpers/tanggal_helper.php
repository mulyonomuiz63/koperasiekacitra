<?php

function bulanIndo($bulan)
{
    $arr = [
        1=>'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ];
    return $arr[(int)$bulan] ?? '';
}
function tglIndo(string $tanggal): string
{
    if (! $tanggal) {
        return '';
    }

    $time = strtotime($tanggal);

    return date('d', $time) . ' ' .
           bulanIndo(date('n', $time)) . ' ' .
           date('Y', $time);
}
