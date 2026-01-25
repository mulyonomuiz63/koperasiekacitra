<?php

namespace App\Services\Pengguna;

use App\Models\PegawaiModel;
class ProfileService
{
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel    = new PegawaiModel();
    }

   
    public function savePegawaiData(int $id, array $data): bool
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
