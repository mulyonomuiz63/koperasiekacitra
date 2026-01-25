<?php

namespace App\Filters;

use App\Models\RoleModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GuestFilter implements FilterInterface
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika SUDAH login → arahkan ke dashboard masing-masing
        if (session()->get('logged_in')) {
            
            // Ambil data role berdasarkan role_id yang disimpan di session
            $cekRole = $this->roleModel->where('id', session()->get('role_id'))->first();

            // Pastikan role ditemukan untuk menghindari error "trying to access array offset on null"
            if ($cekRole) {
                $roleKey = $cekRole['role_key'];

                if ($roleKey == 'ADMIN') {
                    return redirect()->to('/dashboard');
                } 
                elseif ($roleKey == 'ANGGOTA') { // Ubah dari ADMIN ke ANGGOTA
                    return redirect()->to('/sw-anggota');
                } 
                else {
                    // Jika role tidak dikenali sistem
                    return redirect()->to('/logout');
                }
            }

            // Jika user punya session tapi role_id-nya tidak ada di database
            return redirect()->to('/logout');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
