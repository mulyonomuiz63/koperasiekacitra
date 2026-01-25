<?php

namespace App\Services\Pengguna;

use App\Models\PegawaiModel;
use App\Models\PembayaranModel;
use DateTime;

class ActivityService
{
    protected $pegawaiModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pegawaiModel    = new PegawaiModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    /**
     * Ambil data pegawai dan pembayaran terakhir untuk user aktif
     */
    public function getUserActivity(string $userId): array
    {
        $pegawai = $this->pegawaiModel
            ->where('user_id', $userId)
            ->first();

        $pembayaran = $this->pembayaranModel
            ->where('pegawai_id', $pegawai['id'])
            ->where('jenis_transaksi', 'pendaftaran')
            ->whereIn('status', ['P', 'R'])
            ->orderBy('tgl_bayar', 'DESC')
            ->first();

        return [
            'pegawai'    => $pegawai,
            'pembayaran' => $pembayaran
        ];
    }

    /**
     * Simpan data pegawai dari form lengkapiData
     */
    public function savePegawaiData(string $userId, array $data): bool
    {
        $updateData = [
            'nip'           => $data['nip'] ?? null,
            'nik'           => $data['nik'] ?? null,
            'nama'          => $data['nama'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'tempat_lahir'  => $data['tempat_lahir'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'no_hp'         => $data['no_hp'] ?? null,
            'tanggal_masuk' => date('Y-m-d')
        ];

        return (bool) $this->pegawaiModel
            ->where('user_id', $userId)
            ->set($updateData)
            ->update();
    }

    /**
     * Upload bukti pembayaran dan simpan data ke DB
     */
    public function uploadPembayaran(string $userId, $file, array $postData): array
    {
        $pegawai = $this->pegawaiModel
            ->where('user_id', $userId)
            ->first();

        if (!$pegawai) {
            return ['status' => false, 'message' => 'Data pegawai tidak ditemukan'];
        }

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return ['status' => false, 'message' => 'File tidak valid'];
        }

        $dt    = new DateTime($postData['tgl_bayar']);
        $bulan = (int) $dt->format('n');
        $tahun = (int) $dt->format('Y');
        $jumlah = $postData['jumlah_bayar'] ?? 0;

        $namaFile = $file->getRandomName();
        $path     = FCPATH . 'uploads/bukti-bayar/';

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $namaFile);
        $this->compressImage($path . $namaFile);

        $data = [
            'pegawai_id'      => $pegawai['id'],
            'jenis_transaksi' => 'pendaftaran',
            'bulan'           => $bulan,
            'tahun'           => $tahun,
            'jumlah_bayar'    => $jumlah,
            'bukti_bayar'     => $namaFile,
            'tgl_bayar'       => date('Y-m-d H:i:s', strtotime($postData['tgl_bayar'])),
            'status'          => 'P',
            'keterangan'      => null,
        ];

        // Cek pembayaran sebelumnya
        $pembayaran = $this->pembayaranModel
            ->where('pegawai_id', $pegawai['id'])
            ->where('jenis_transaksi', 'pendaftaran')
            ->whereIn('status', ['P', 'R'])
            ->first();

        if ($pembayaran) {
            if (!empty($pembayaran['bukti_bayar']) && file_exists($path . $pembayaran['bukti_bayar'])) {
                unlink($path . $pembayaran['bukti_bayar']);
            }
            $this->pembayaranModel->update($pembayaran['id'], $data);
        } else {
            $this->pembayaranModel->insert($data);
        }

        return ['status' => true, 'message' => 'Bukti pembayaran berhasil diupload, menunggu approval admin'];
    }

    /**
     * Kompresi gambar (jpeg/png)
     */
    private function compressImage(string $filePath, int $quality = 75): bool
    {
        $info = getimagesize($filePath);
        if (!$info) return false;

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($filePath);
                imagejpeg($image, $filePath, $quality);
                break;

            case 'image/png':
                $image = imagecreatefrompng($filePath);
                $pngQuality = (int)((100 - $quality) / 10);
                imagepng($image, $filePath, $pngQuality);
                break;

            default:
                return false;
        }

        imagedestroy($image);
        return true;
    }
}
