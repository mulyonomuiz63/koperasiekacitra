<?php

namespace App\Services\Admin;

use App\Libraries\EmailService;
use App\Models\PegawaiModel;
use App\Models\PembayaranModel;
use Config\Database;

class PembayaranService
{
    protected $pembayaran;
    protected $pegawai;
    protected $db;
    protected $emailService;

    public function __construct()
    {
        $this->db         = Database::connect();
        $this->pembayaran = new PembayaranModel();
        $this->pegawai = new PegawaiModel();
        $this->emailService = new EmailService();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->pembayaran->getDatatable($request);

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
            'nama_pegawai'          => $row['nama_pegawai'],
            'keterangan'            => $row['keterangan'] ? $row['keterangan'] : '-',
            'status'                => $row['status'],
            
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function getEditData(string $id): array
    {
        $pembayaran = $this->pembayaran
            ->select('pembayaran.*, pegawai.nama, pegawai.nip, pegawai.no_hp')
            ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
            ->where('pembayaran.id', $id)
            ->first();

        if (! $pembayaran) {
            return [
                'pembayaran' => null,
            ];
        }

        return [
            'pembayaran'    => $pembayaran,
        ];
    }

    public function updateStatus(string $id, string $status, ?string $rejectReason = null): void
    {
        $this->db->transBegin();

        try {
            $pembayaran = $this->pembayaran->find($id);
            // Saya asumsikan ada relasi pegawai_id di tabel pembayaran pendaftaran
            $pembayaran = $this->db->table('pembayaran p')
                ->select('p.*, pg.nama as nama_lengkap, u.email, pg.user_id')
                ->join('pegawai pg', 'pg.id = p.pegawai_id')
                ->join('users u', 'u.id = pg.user_id')
                ->where('p.id', $id)
                ->where('p.jenis_transaksi','pendaftaran')
                ->get()
                ->getRowArray();

            if (! $pembayaran) {
                throw new \Exception('Data pembayaran tidak ditemukan');
            }

            // Cegah double approve
            if ($pembayaran['status'] === 'A') {
                throw new \Exception('Pembayaran ini sudah di-approve');
            }
            $invoiceNo = generateBigInvoiceNumber();
            $dataUpdate = [
                'status'             => $status,
                'invoice_no'         => $invoiceNo,
                'invoice_at'         => date('Y-m-d H:i:s'),
                'validated_at'       => date('Y-m-d H:i:s'),
            ];

            if ($status === 'R') {
                $dataUpdate['keterangan'] = $rejectReason;
                $dataUpdate['status_iuran'] = 'T';

                 //untuk notif
                send_notification_anggota($pembayaran['user_id'], [
                    'title'   => 'Bukti pembayaran ditolak',
                    'message' => $rejectReason,
                    'link'    => 'sw-anggota/activity'
                ]);
                
            }

            $this->pembayaran->update($id, $dataUpdate);

            // Jika approved → update pegawai
            if ($status === 'A') {
                $this->pegawai->update($pembayaran['pegawai_id'], [
                    'status'     => 'A',
                    'status_iuran' => 'A',
                ]);

                send_notification_anggota($pembayaran['user_id'], [
                    'title'   => 'Pembayaran diverifikasi',
                    'message' => 'Pendaftaran berhasil diverifikasi',
                    'link'    => 'sw-anggota'
                ]);
            }

            $this->db->transCommit();
            // =============================================
            // PROSES KIRIM EMAIL KONFIRMASI PENDAFTARAN
            // =============================================

            $dataEmail = [
                'nama_lengkap' => $pembayaran['nama_lengkap'],
                'total_bayar'  => $pembayaran['jumlah_bayar'], // sesuaikan field jumlah_bayar bayar Anda
                'invoice_no'   => $invoiceNo, // No invoice dummy pendaftaran
                'status'       => $status,
                'catatan'      => $rejectReason,
                'tipe'         => 'Pendaftaran Anggota Baru'
            ];

            // Gunakan view yang sama (pembayaran_status)
            $htmlContent = view('emails/pembayaran_status', $dataEmail);
            
            $subject = ($status == 'A') 
                ? "Selamat! Pendaftaran & Pembayaran Anda Disetujui" 
                : "Pemberitahuan: Pembayaran Pendaftaran Ditolak";

            $this->emailService->send($pembayaran['email'], $subject, $htmlContent);

        } catch (\Throwable $e) {

            if ($this->db->transStatus()) {
                $this->db->transRollback();
            }

            throw $e;
        }
    }
}
