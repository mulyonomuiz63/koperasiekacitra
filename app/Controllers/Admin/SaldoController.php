<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\Admin\SaldoService;
use CodeIgniter\API\ResponseTrait;

class SaldoController extends BaseController
{
    use ResponseTrait;

    protected $saldoService;

    public function __construct()
    {
        $this->saldoService = new SaldoService();
    }

    // Jalankan via URL: domain.com/admin/sync-saldo
    public function massSync()
    {
        try {
            $total = $this->saldoService->syncAllSaldo();
            return $this->respond([
                'status' => 'success',
                'message' => "Sinkronisasi selesai. $total data pegawai diperbarui."
            ]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    // Jalankan via URL: domain.com/admin/sync-saldo/{uuid_user}
    public function userSync($userId)
    {
        $db = \Config\Database::connect();
        $pegawai = $db->table('pegawai')->where('user_id', $userId)->get()->getRow();

        if (!$pegawai) return $this->failNotFound('Pegawai tidak ditemukan');

        $this->saldoService->syncOneUser($pegawai->id, $userId);
        return $this->respond(['status' => 'success', 'message' => 'Saldo user berhasil diperbarui.']);
    }
}