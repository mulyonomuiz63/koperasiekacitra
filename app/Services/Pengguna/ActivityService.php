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
        $validation = \Config\Services::validation();

        // 1. Definisi Aturan (Rules)
        $rules = [
            'nip'           => 'required|numeric|max_length[20]',
            'nik'           => 'required|numeric|exact_length[16]',
            'nama'          => 'required|alpha_space|max_length[25]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'no_hp'         => 'required|numeric|min_length[10]|max_length[15]',
            'tempat_lahir'  => 'required|alpha_space|max_length[50]',
            'alamat'        => 'required|string|max_length[255]'
        ];

        // 2. Definisi Pesan Error Custom (Bahasa Indonesia)
        $errors = [
            'nip' => [
                'required'   => 'NIP wajib diisi.',
                'numeric'    => 'NIP harus berupa angka.',
                'max_length' => 'NIP tidak boleh lebih dari 20 karakter.'
            ],
            'nik' => [
                'required'     => 'NIK wajib diisi.',
                'numeric'      => 'NIK harus berupa angka.',
                'exact_length' => 'NIK harus tepat 16 digit.'
            ],
            'nama' => [
                'required'    => 'Nama lengkap wajib diisi.',
                'alpha_space' => 'Nama hanya boleh berisi huruf dan spasi.',
                'max_length'  => 'Nama tidak boleh lebih dari 25 karakter.'
            ],
            'jenis_kelamin' => [
                'in_list' => 'Jenis kelamin harus Laki-laki (L) atau Perempuan (P).'
            ],
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi.',
                'numeric'    => 'Nomor HP harus berupa angka.',
                'min_length' => 'Nomor HP minimal 10 digit.',
                'max_length' => 'Nomor HP maksimal 15 digit.'
            ],
            'alamat' => [
                'required'   => 'Alamat wajib diisi.',
                'max_length' => 'Alamat terlalu panjang (maksimal 255 karakter).'
            ]
        ];

        // Jalankan Validasi
        if (!$validation->setRules($rules, $errors)->run($data)) {
            // Ambil pesan error pertama dan lemparkan sebagai Exception
            $errorMsg = $validation->getErrors();
            throw new \RuntimeException(reset($errorMsg));
        }

        // 3. Sanitasi Data (Antisipasi Serangan XSS & SQL Injection)
        $updateData = [
            'nip'           => esc($data['nip']),
            'nik'           => esc($data['nik']),
            'nama'          => strip_tags($data['nama']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => strip_tags($data['tempat_lahir']),
            'alamat'        => htmlspecialchars($data['alamat']),
            'no_hp'         => esc($data['no_hp']),
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
            $pembayaranID = $pembayaran['id'];
        } else {
            $pembayaranID = $this->pembayaranModel->insert($data);
        }
        //untuk notif
        send_notification('Bendahara', [
            'title'   => 'Upload pembayaran pendaftaran',
            'message' => 'Ada bukti baru dari ' . $pegawai['nama'],
            'link'    => 'pembayaran/edit/' . $pembayaranID
        ]);

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
