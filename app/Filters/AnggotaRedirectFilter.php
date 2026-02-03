<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\RoleModel;

class AnggotaRedirectFilter implements FilterInterface
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Pastikan user login
        if (!$session->get('logged_in')) {
            return;
        }

        $cekRole = $this->roleModel->where('id', $session->get('role_id'))->first();
        if (!$cekRole) return;

        $roleKey = $cekRole['role_key'];
        $path = $request->getUri()->getPath();

        // 2. LOGIKA IZIN AKSES:
        // Jika user adalah ADMIN, dia bebas mengakses area admin maupun area anggota.
        // Maka kita biarkan Admin lolos (return) tanpa cek status pegawai.
        if ($roleKey === 'ADMIN') {
            return;
        }

        // --- MULAI DARI SINI, HANYA ROLE 'ANGGOTA' YANG AKAN DIPROSES ---

        // 3. Pengecualian path agar tidak looping redirect
        if (str_contains($path, 'sw-anggota/lengkapi-data') || str_contains($path, 'sw-anggota/pembayaran')) {
            return;
        }

        $pegawai = (new PegawaiModel())
            ->where('user_id', $session->get('user_id'))
            ->first();

        // 4. Jika data pegawai tidak ditemukan atau status masih 'T' (Tertunda)
        if (!$pegawai || $pegawai['status'] === 'T') {
            if (!str_contains($path, 'sw-anggota/activity')) {
                return redirect()->to('/sw-anggota/activity');
            }
            return;
        }

        // 5. Jika status Aktif ('A'), cegah masuk ke halaman pendaftaran/activity
        if ($pegawai['status'] === 'A') {
            if (
                str_contains($path, 'sw-anggota/activity') ||
                str_contains($path, 'sw-anggota/lengkapi-data') ||
                str_contains($path, 'sw-anggota/pembayaran')
            ) {
                return redirect()->to('/sw-anggota');
            }
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
