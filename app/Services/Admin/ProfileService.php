<?php

namespace App\Services\Admin;

use App\Models\PegawaiModel;
use App\Models\UserModel;
use Config\Database;

class ProfileService
{
    protected $pegawaiModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->pegawaiModel    = new PegawaiModel();
        $this->userModel    = new UserModel();
        $this->db = Database::connect();
    }
    public function getProfilData(string $userId): array
    {
        // 1. Ambil Data Detail User & Pegawai
        $userData = $this->userModel
            ->join('pegawai', 'pegawai.user_id = users.id')
            ->join('perusahaan', 'perusahaan.id = pegawai.perusahaan_id')
            ->join('jabatan', 'jabatan.id = pegawai.jabatan_id')
            ->select('users.email, perusahaan.nama_perusahaan, jabatan.nama_jabatan, pegawai.*')
            ->where('users.id', $userId)
            ->first();

        if (!$userData) {
            throw new \Exception('Data profil tidak ditemukan.');
        }

        // 2. Hitung Total Saldo Iuran (Hanya yang statusnya 'S' / Sukses)
        $totalSaldo = $this->db->table('iuran_bulanan')
            ->join('pegawai', 'pegawai.id = iuran_bulanan.pegawai_id')
            ->where('iuran_bulanan.status', 'S')
            ->where('pegawai.user_id', $userId) // Menggunakan user_id dari session
            ->selectSum('jumlah_iuran')
            ->get()
            ->getRow()->jumlah_iuran ?? 0;

        return [
            'user'        => $userData,
            'total_saldo' => $totalSaldo
        ];
    }
   
    public function savePegawaiData(string $id, array $data): bool
    {
        $updateData = [
            'nik'           => $data['nik'] ?? null,
            'nama'          => $data['nama'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'tempat_lahir'  => $data['tempat_lahir'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'no_hp'         => $data['no_hp'] ?? null,
        ];

        return (bool) $this->pegawaiModel
            ->where('id', $id)
            ->set($updateData)
            ->update();
    }
}
