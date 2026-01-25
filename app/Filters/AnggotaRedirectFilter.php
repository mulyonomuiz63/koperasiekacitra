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

        // hanya untuk login user
        if (!$session->get('logged_in')) {
            return;
        }

        // hanya role anggota
        $cekRole = $this->roleModel->where('id', session()->get('role_id'))->first();
        // Pastikan role ditemukan untuk menghindari error "trying to access array offset on null"
        if ($cekRole) {
            $roleKey = $cekRole['role_key'];

            if ($roleKey !== 'ANGGOTA') {
                return;
            } 
        }

        $path = $request->getUri()->getPath();

        // IZINKAN akses ke halaman lengkapi-data baik GET maupun POST
        if (str_contains($path, 'sw-anggota/lengkapi-data') || str_contains($path, 'sw-anggota/pembayaran')) {
            return;
        }

        $pegawai = (new PegawaiModel())
            ->where('user_id', $session->get('user_id'))
            ->first();

        // belum ada data pegawai
        if (!$pegawai) {
            if (!str_contains($path, 'sw-anggota/activity')) {
                return redirect()->to('/sw-anggota/activity');
            }
            return;
        }

        // status T → activity
        if ($pegawai['status'] === 'T') {
            if (!str_contains($path, 'sw-anggota/activity')) {
                return redirect()->to('/sw-anggota/activity');
            }
        }

        // status aktif → dashboard
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


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
