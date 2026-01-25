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
        $this->user->insert([
            'username' => $data['username'],
            'email'    => $data['email'],
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
        $update = [
            'username' => $data['username'],
            'email'    => $data['email'],
            'role_id'  => $data['role_id'],
            'status'   => $data['status'],
        ];

        if (!empty($data['password'])) {
            $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $this->user->update($id, $update);
    }

    public function getErrors(): array
    {
        return $this->validasi->getErrors();
    }
}
