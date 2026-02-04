<?php

namespace App\Services\Pengguna;

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

    public function getProfilLengkap(string $userId): array
    {
        // 1. Ambil Data User, Pegawai, Perusahaan, dan Jabatan
        $user = $this->userModel
            ->join('pegawai', 'pegawai.user_id = users.id')
            ->join('perusahaan', 'perusahaan.id = pegawai.perusahaan_id')
            ->join('jabatan', 'jabatan.id = pegawai.jabatan_id')
            ->select('users.email, perusahaan.nama_perusahaan, jabatan.nama_jabatan, pegawai.*')
            ->where('users.id', $userId)
            ->first();

        // 2. Hitung Total Saldo (Hanya yang statusnya 'A' / Sukses)
        $totalSaldo = $this->db->table('pembayaran')
            ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
            ->where('pembayaran.status', 'A')
            ->where('pegawai.user_id', $userId)
            ->selectSum('pembayaran.jumlah_bayar')
            ->get()->getRow()->jumlah_bayar ?? 0;

        return [
            'user'        => $user,
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
}
