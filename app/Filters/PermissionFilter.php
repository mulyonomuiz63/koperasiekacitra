<?php

namespace App\Filters;

use App\Models\RoleModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$arguments || count($arguments) < 2) {
            return;
        }

        [$menuSlug, $action] = $arguments;

        $menu = model('MenuModel')
            ->where('slug', $menuSlug)
            ->first();

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        if (!can($menu['id'], $action)) {
            // Ambil data role berdasarkan role_id yang disimpan di session
            $cekRole = $this->roleModel->where('id', session()->get('role_id'))->first();

            // Pastikan role ditemukan untuk menghindari error "trying to access array offset on null"
            if ($cekRole) {
                $roleKey = $cekRole['role_key'];

                if ($roleKey == 'ADMIN') {
                    return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses');;
                } 
                elseif ($roleKey == 'ANGGOTA') { // Ubah dari ADMIN ke ANGGOTA
                    return redirect()->to('/sw-anggota')->with('error', 'Anda tidak memiliki akses');;
                } 
                else {
                    // Jika role tidak dikenali sistem
                    return redirect()->to('/logout');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
