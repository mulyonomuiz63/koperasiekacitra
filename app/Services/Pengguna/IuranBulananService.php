<?php

namespace App\Services\Pengguna;

use App\Models\IuranBulananModel;

class IuranBulananService
{
    protected $iuranBulanan;

    public function __construct()
    {
        $this->iuranBulanan = new IuranBulananModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->iuranBulanan->getDatatable($request);

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
            'id'                    => $row['id'],
            'pegawai_id'            => $row['pegawai_id'],
            'nama_pegawai'          => $row['nama_pegawai'],
            'tgl_tagihan'          => $row['tgl_tagihan'],
            'bulan_tahun'           => bulanIndo($row['bulan']) . ' - ' . $row['tahun'],
            'bulan'                 => $row['bulan'],
            'tahun'                 => $row['tahun'],
            'jumlah_iuran'          => $row['jumlah_iuran'],
            'status'                => $row['status'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
        ];
    }

    public function createIuran(array $data)
    {
        try {
            // 1. Bersihkan format uang (jika dari input ada titik/koma)
            if (isset($data['jumlah_iuran'])) {
                $data['jumlah_iuran'] = str_replace(['.', ','], '', $data['jumlah_iuran']);
            }

            // 2. Set default status jika tidak ada (Misal 'P' untuk Pending atau 'S' untuk Success)
            if (!isset($data['status'])) {
                $data['status'] = 'P';
            }

            // 3. Eksekusi simpan
            return $this->iuranBulanan->insert($data);
        } catch (\Throwable $e) {
            throw new \Exception("Gagal mencatat iuran: " . $e->getMessage());
        }
    }

    public function getIuranById(string $id)
    {
        $iuran = $this->iuranBulanan->find($id);

        if (!$iuran) {
            throw new \Exception('Data iuran tidak ditemukan.');
        }
        return $iuran;
    }

    public function updateIuran(string $id, array $data)
    {
        try {
            // 1. Cek keberadaan data
            $existing = $this->iuranBulanan->find($id);
            if (!$existing) {
                throw new \Exception('Data iuran tidak ditemukan.');
            }

            // 2. Sanitasi Data: Bersihkan format titik/koma jika ada
            if (isset($data['jumlah_iuran'])) {
                $data['jumlah_iuran'] = str_replace(['.', ','], '', $data['jumlah_iuran']);
            }

            // 3. Mapping data untuk keamanan (hanya field tertentu yang boleh update)
            $updateData = [
                'pegawai_id'   => $data['pegawai_id'],
                'bulan'        => $data['bulan'],
                'tahun'        => $data['tahun'],
                'jumlah_iuran' => $data['jumlah_iuran'],
                'status'       => $data['status'] ?? $existing['status'],
                'keterangan'   => $data['keterangan'] ?? '',
            ];

            return $this->iuranBulanan->update($id, $updateData);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
