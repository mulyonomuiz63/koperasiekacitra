<?php

namespace App\Filters;

use App\Models\RoleModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah session role_id ada
        $roleId = session()->get('role_id');
        if (!$roleId) {
            return redirect()->to('/login');
        }

        // 2. Inisialisasi model di sini
        $roleModel = new RoleModel();
        $role = $roleModel->where('id', $roleId)->first();

        // 3. Cek apakah role ditemukan di database
        if (!$role) {
            return redirect()->to('/unauthorized');
        }

        // 4. Validasi argumen (ADMIN, dsb)
        // Pastikan $arguments tidak null sebelum dicek
        if ($arguments) {
            if (!in_array($role['role_key'], $arguments, true)) {
                return redirect()->to('/unauthorized');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosong
    }
}