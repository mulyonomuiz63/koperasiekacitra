<?php

namespace App\Services\Admin;

use App\Models\UserModel;
use App\Services\Validation\UserValidation;

class UserService
{
    protected $user;
    protected $validasi;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->validasi = new UserValidation();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->user->getDatatable($request);

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
            'username'   => $row['username'],
            'email'      => $row['email'],
            'role_name'  => $row['role_name'],
            'status'     => $row['status'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    /* ============================
     * CREATE
     * ============================ */
    public function validateCreate(array $data): bool
    {
        return $this->validasi->validateCreate($data);
    }

    public function create(array $data): void
    {
        $email = trim($data['email']);

        // 1. Sanitasi Email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // 2. Validasi Format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Format email tidak valid.');
        }

        // 3. Validasi Domain (MX Record)
        if (!is_valid_domain($email)) {
            throw new \Exception('Email tidak valid atau tidak dapat menerima email.');
        }

        // 4. Cek Duplikat (Agar tidak Error Duplicate Entry di Database)
        $existing = $this->user->where('email', $email)->first();
        if ($existing) {
            throw new \Exception('Email tersebut sudah digunakan oleh pengguna lain.');
        }

        $this->user->insert([
            'username' => $data['username'],
            'email'    => $email, // Gunakan email yang sudah dibersihkan
            'role_id'  => $data['role_id'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
    }

    /* ============================
     * UPDATE
     * ============================ */
    public function validateUpdate(array $data, string $id): bool
    {
        return $this->validasi->validateUpdate($data, $id);
    }

    public function update(string $id, array $data): void
    {
        // 1. Sanitasi & Validasi Format
        $email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Format email tidak valid.');
        }

        // 2. Gunakan HELPER untuk Validasi Domain
        // Pastikan helper sudah di-load di BaseController atau Constructor
        if (!is_valid_domain($email)) {
            throw new \Exception('Email tidak valid atau tidak dapat menerima email.');
        }

        // 3. Cek Email Duplikat (Kecuali milik user itu sendiri)
        $isUsed = $this->user->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($isUsed) {
            throw new \Exception('Email sudah digunakan oleh pengguna lain.');
        }

        // 4. Siapkan Data
        $updateData = [
            'username' => $data['username'],
            'email'    => $email,
            'role_id'  => $data['role_id'],
            'status'   => $data['status'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // 5. Eksekusi
        if (!$this->user->update($id, $updateData)) {
            throw new \Exception('Gagal memperbarui data pengguna.');
        }
    }

    public function getErrors(): array
    {
        return $this->validasi->getErrors();
    }

    public function deleteUser(string $id)
    {
        // Cek apakah data ada
        $user = $this->user->find($id);

        if (!$user) {
            throw new \Exception('User tidak ditemukan atau sudah dihapus.');
        }

        // Eksekusi hapus
        return $this->user->delete($id);
    }
}
