<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\IuranService;

class GenerateIuranBulanan extends BaseCommand
{
    protected $group       = 'Iuran';
    protected $name        = 'iuran:generate';
    protected $description = 'Generate tagihan iuran bulanan otomatis';

    public function run(array $params)
    {
        $service = new IuranService();
        $total   = $service->generateBulanan();

        CLI::write("Generate iuran selesai. Total: {$total}", 'green');
    }
}
