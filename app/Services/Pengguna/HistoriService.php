<?php

namespace App\Services\Pengguna;

use App\Models\PembayaranModel;
use Config\Database;
use CodeIgniter\Exceptions\PageNotFoundException;

class HistoriService
{
    protected $db;
    protected $pembayaran;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->pembayaran = new PembayaranModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->pembayaran->getDatatableAnggota($request);

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
            'id'                => $row['id'],
            'nama_pegawai'      => $row['nama_pegawai'],
            'jenis_transaksi'   => $row['jenis_transaksi'],
            'bulan'             => $row['bulan'],
            'tahun'             => $row['tahun'],
            'jumlah_bayar'      => $row['jumlah_bayar'],
            'status'            => $row['status'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
        ];
    }

    /**
     * Ambil detail histori pembayaran
     *
     * @param int $id
     * @return array
     * @throws PageNotFoundException
     */
    public function getHistoriDetail(string $id): array
    {
        // Ambil pembayaran
        $pembayaran = $this->db->table('pembayaran p')
            ->select('p.*, pg.nama as nama_pegawai')
            ->join('pegawai pg', 'pg.id = p.pegawai_id')
            ->where('p.id', $id)
            ->get()
            ->getRowArray();

        if (!$pembayaran) {
            throw new PageNotFoundException('Data pembayaran tidak ditemukan');
        }

        // Ambil detail pembayaran
        $detail = $this->db->table('pembayaran_detail d')
            ->select('d.*, i.bulan, i.tahun')
            ->join('iuran_bulanan i', 'i.id = d.iuran_id')
            ->where('d.pembayaran_id', $id)
            ->get()
            ->getResultArray();

        // Contoh rekening statis (nanti bisa ambil dari tabel bank)
        $rekening = [
            'bank' => setting('nama_bank'),
            'no'   => setting('norek'),
            'nama' => setting('nama_pemilik')
        ];

        return [
            'pembayaran' => $pembayaran,
            'detail'     => $detail,
            'rekening'   => $rekening
        ];
    }
}
