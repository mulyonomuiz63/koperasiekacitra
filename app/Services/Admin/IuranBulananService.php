<?php

namespace App\Services\Admin;

use App\Libraries\EmailService;
use App\Models\PembayaranDetailModel;
use App\Models\PembayaranModel;
use Config\Database;

class IuranBulananService
{
    protected $pembayaran;
    protected $pembayaranDetail;
    protected $db;
    protected $emailService;

    public function __construct()
    {
        $this->pembayaran = new PembayaranModel();
        $this->pembayaranDetail = new PembayaranDetailModel();
        $this->db = Database::connect();
        $this->emailService = new EmailService();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->pembayaran->getDatatablePembayaranBulanan($request);

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

    public function getPembayaranDetail(string $pembayaranId): array
    {
        $pembayaran = $this->pembayaran
            ->getPembayaranWithPegawai($pembayaranId);

        if (! $pembayaran) {
            throw new \RuntimeException('Pembayaran tidak ditemukan');
        }

        $detail = $this->pembayaranDetail
            ->getDetailByPembayaran($pembayaranId);

        return [
            'pembayaran' => $pembayaran,
            'detail'     => $detail,
        ];
    }

    public function verifikasi(string $pembayaranId, string $aksi, ?string $catatan = null): string
    {
        $this->db->transBegin();

        try {

            // =============================
            // 1. VALIDASI INPUT
            // =============================
            if (empty($pembayaranId) || empty($aksi)) {
                throw new \Exception('Input tidak lengkap');
            }

            if (! in_array($aksi, ['setujui', 'tolak'])) {
                throw new \Exception('Aksi tidak valid');
            }

            // =============================
            // 2. AMBIL PEMBAYARAN
            // =============================
            $pembayaran = $this->db->table('pembayaran p')
                ->select('p.*, pg.nama as nama_lengkap, u.email, pg.user_id')
                ->join('pegawai pg', 'pg.id = p.pegawai_id')
                ->join('users u', 'u.id = pg.user_id')
                ->where('p.id', $pembayaranId)
                ->where('p.jenis_transaksi','bulanan')
                ->get()
                ->getRowArray();

            if (! $pembayaran) {
                throw new \Exception('Pembayaran tidak ditemukan');
            }

            if ($pembayaran['status'] !== 'V') {
                throw new \Exception('Pembayaran tidak dapat diverifikasi');
            }

            // =============================
            // 3. DETAIL PEMBAYARAN
            // =============================
            $detail = $this->db->table('pembayaran_detail')
                ->select('iuran_id')
                ->where('pembayaran_id', $pembayaranId)
                ->get()
                ->getResultArray();

            if (empty($detail)) {
                throw new \Exception('Detail pembayaran tidak ditemukan');
            }

            // =============================
            // 4. PROSES
            // =============================
            $status = ($aksi === 'setujui' ? 'A' : 'R');
            $invoiceNo = null;

            if ($aksi === 'setujui') {
                $invoiceNo = generateBigInvoiceNumber();

                $this->db->table('pembayaran')->where('id', $pembayaranId)->update([
                    'invoice_no'         => $invoiceNo,
                    'invoice_at'         => date('Y-m-d H:i:s'),
                    'status'             => 'A',
                    'catatan_verifikasi' => $catatan,
                    'validated_at'       => date('Y-m-d H:i:s'),
                ]);

                foreach ($detail as $row) {
                    $this->db->table('iuran_bulanan')->where('id', $row['iuran_id'])->update(['status' => 'S']);
                }
                $message = 'Pembayaran berhasil diverifikasi';
            } else {
                $this->db->table('pembayaran')->where('id', $pembayaranId)->update([
                    'status'             => 'R',
                    'catatan_verifikasi' => $catatan,
                ]);

                foreach ($detail as $row) {
                    $this->db->table('iuran_bulanan')->where('id', $row['iuran_id'])->update(['status' => 'B']);
                }
                $message = 'Pembayaran ditolak';
            }

            $this->db->transCommit();

            // =============================
            // PROSES KIRIM EMAIL VIA LIB
            // =============================
            // Siapkan data untuk view invoice
            $dataEmail = [
                'nama_lengkap' => $pembayaran['nama_lengkap'],
                'total_bayar'  => $pembayaran['jumlah_bayar'],
                'invoice_no'   => $invoiceNo,
                'status'       => $status,
                'catatan'      => $catatan,
                'tipe'         => 'Iuran Bulanan Anggota'
            ];

            // Render view menjadi string HTML
            $htmlContent = view('emails/pembayaran_status', $dataEmail);

            $subject = ($status == 'A') ? "Invoice Pembayaran: $invoiceNo" : "Pemberitahuan Penolakan Pembayaran";

            // Kirim via library
            $this->emailService->send($pembayaran['email'], $subject, $htmlContent);

            send_notification_anggota($pembayaran['user_id'], [
                'title'   => $message,
                'message' => $catatan,
                'link'    => 'sw-anggota/iuran'
            ]);

            return $message;
        } catch (\Throwable $e) {

            if ($this->db->transStatus()) {
                $this->db->transRollback();
            }

            throw $e;
        }
    }
}
