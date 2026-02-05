<?php

namespace App\Services\Admin;

use App\Models\PegawaiModel;
use App\Models\UserModel;
use Config\Database;

class ProfileService
{
    protected $pegawaiModel;
    protected $userModel;
    protected $uploadPath;
    protected $db;

    public function __construct()
    {
        $this->pegawaiModel    = new PegawaiModel();
        $this->userModel    = new UserModel();
        $this->uploadPath = FCPATH . 'uploads/avatars/';
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
        $totalSaldo = $this->db->table('pembayaran')
            ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
            ->where('pembayaran.status', 'A')
            ->where('pegawai.user_id', $userId)
            ->selectSum('pembayaran.jumlah_bayar')
            ->get()->getRow()->jumlah_bayar ?? 0;

        return [
            'user'        => $userData,
            'total_saldo' => $totalSaldo
        ];
    }

    public function savePegawaiData(string $id, array $data): bool
    {
        $validation = \Config\Services::validation();

        // 1. Definisi Aturan (Rules)
        $rules = [
            'nik'           => 'required|numeric|exact_length[16]',
            'nama'          => 'required|alpha_space|max_length[25]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'no_hp'         => 'required|numeric|min_length[10]|max_length[15]',
            'tempat_lahir'  => 'required|alpha_space|max_length[50]',
            'alamat'        => 'required|string|max_length[255]'
        ];

        // 2. Definisi Pesan Error Custom (Bahasa Indonesia)
        $errors = [
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
            ],
            'angkatan' => [
                'required'   => 'Angkatan wajib diisi.',
                'numeric'    => 'Angkatan harus berupa angka.',
            ],
        ];

        // Jalankan Validasi
        if (!$validation->setRules($rules, $errors)->run($data)) {
            // Ambil pesan error pertama dan lemparkan sebagai Exception
            $errorMsg = $validation->getErrors();
            throw new \RuntimeException(reset($errorMsg));
        }

        // 3. Sanitasi Data (Antisipasi Serangan XSS & SQL Injection)
        $updateData = [
            'nik'           => esc($data['nik']),
            'nama'          => strip_tags($data['nama']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => strip_tags($data['tempat_lahir']),
            'alamat'        => htmlspecialchars($data['alamat']),
            'no_hp'         => esc($data['no_hp']),
            'tanggal_masuk' => date('Y-m-d'),
            'angkatan'      => esc($data['angkatan'])
        ];

        return (bool) $this->pegawaiModel
            ->where('id', $id)
            ->set($updateData)
            ->update();
    }

    public function updatePassword(string $id, array $data): bool
    {
        // 1. Pastikan key sesuai dengan input form (tadi kita pakai 'new_password')
        // Jika di controller Anda sudah mengubahnya menjadi 'password', ini sudah oke.
        $passwordBaru = $data['new_password'] ?? $data['password'];

        // 2. Lakukan Hashing
        $updateData = [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s') // Opsional: catat waktu perubahan
        ];

        // 3. Jalankan Update
        // Menggunakan return langsung karena update() mengembalikan boolean
        return $this->userModel->update($id, $updateData);
    }

    public function updateAvatar($userId, $file)
    {
        // 1. Validasi File awal
        if (!$file->isValid() || $file->hasMoved()) {
            return ['status' => false, 'message' => 'File tidak valid, Coba dengan file lain.'];
        }

        // Cek mime type
        if (!in_array($file->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png'])) {
            return ['status' => false, 'message' => 'Format file harus JPG atau PNG.'];
        }

        // 2. Ambil data user
        $user = $this->pegawaiModel->where('user_id', $userId)->first();
        if (!$user) {
            return ['status' => false, 'message' => 'User tidak ditemukan.'];
        }

        // 3. Generate nama unik
        $newName = $file->getRandomName();

        // 4. Pindahkan file asli sementara
        if ($file->move($this->uploadPath, $newName)) {

            // --- PROSES KOMPRESI & RESIZE ---
            $this->compressImage($newName);

            // 5. Logika Hapus Foto Lama (Kecuali default.jpg)
            $oldAvatar = is_array($user) ? $user['avatar'] : $user->avatar;
            $this->deleteOldAvatar($oldAvatar);

            // 6. Update Database
            $this->pegawaiModel->where('user_id', $userId)->set(['avatar' => $newName])->update();

            return [
                'status' => true,
                'message' => 'Avatar berhasil diperbarui dan dikompres.',
                'file_name' => $newName
            ];
        }

        return ['status' => false, 'message' => 'Gagal memindahkan file ke server.'];
    }

    /**
     * Fungsi privat untuk kompresi gambar
     */
    private function compressImage($fileName)
    {
        $imageService = \Config\Services::image();
        $fullPath = $this->uploadPath . $fileName;

        // Proses: Resize ke 300x300 (biar simetris) dan kualitas 70%
        $imageService->withFile($fullPath)
            ->resize(300, 300, true, 'center') // Resize ke 300px agar seragam
            ->save($fullPath, 70); // Simpan kembali dengan kualitas 70%
    }

    /**
     * Fungsi internal untuk menghapus file fisik
     */
    private function deleteOldAvatar($fileName)
    {
        if (!empty($fileName) && $fileName !== 'default.jpg') {
            $fullPath = $this->uploadPath . $fileName;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
