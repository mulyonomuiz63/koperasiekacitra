<?php

namespace App\Services\Admin;

use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use App\Models\PerusahaanModel;

class PegawaiService
{
    protected $pegawai;
    protected $perusahaan;
    protected $jabatan;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->perusahaan = new PerusahaanModel();
        $this->jabatan    = new JabatanModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->pegawai->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = $this->mapRow($row, $menuId);
        }

        return [
            'draw'            => (int) $request['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    protected function mapRow(array $row, string $menuId): array
    {
        return [
            'id'         => $row['id'],
            'namaPegawai'       => $row['namaPegawai'],
            'perusahaan' => $row['nama_perusahaan'],
            'jabatan'    => $row['nama_jabatan'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function getEditData(string $pegawaiId): array
    {
        $pegawai = $this->pegawai
            ->select('pegawai.*, users.username')
            ->join('users', 'users.id = pegawai.user_id')
            ->where('pegawai.id', $pegawaiId)
            ->first();

        if (! $pegawai) {
            return [
                'pegawai' => null,
            ];
        }

        return [
            'pegawai'    => $pegawai,
            'perusahaan' => $this->perusahaan->findAll(),
            'jabatan'    => $this->jabatan->findAll(),
        ];
    }
}
