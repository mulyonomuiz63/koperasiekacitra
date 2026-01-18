<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;

class AnggotaRedirectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // hanya untuk login user
        if (!$session->get('logged_in')) {
            return;
        }

        // hanya role anggota
        if ((int)$session->get('role_id') !== 4) {
            return;
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

        // status nonaktif → activity
        if ($pegawai['status'] === 'nonaktif') {
            if (!str_contains($path, 'sw-anggota/activity')) {
                return redirect()->to('/sw-anggota/activity');
            }
        }

        // status aktif → dashboard
        if ($pegawai['status'] === 'aktif') {
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
